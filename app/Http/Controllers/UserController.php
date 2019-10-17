<?php

namespace App\Http\Controllers;

use App\Gender;
use App\Marital;
use App\Religion;
use Illuminate\Http\Request;
use App\User;
use App\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use File;
use Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Manajemen Pengguna';
        $users = User::all();
        return view('user.index', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Manajemen Pengguna';
        $subtitle = 'Tambah Pengguna Baru';
        $users = User::all();
        $user_role = UserRole::all();
        $religions = Religion::all();
        $genders = Gender::all();
        $maritals = Marital::all();
        return view('user.create', compact('title', 'subtitle', 'users', 'user_role', 'genders', 'religions', 'maritals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'peran'                 => 'required|numeric',
            'nama_lengkap'          => 'required|string',
            'nik'                   => 'required|numeric',
            'email'                 => 'required|string|email|unique:users',
            'jenis_kelamin'         => 'required',
            'agama'                 => 'required',
            'status_pernikahan'     => 'required',
            'nomor_telepon'         => 'nullable|numeric',
            'alamat'                => 'required',
            'tempat_lahir'          => 'required|string',
            'tanggal_lahir'         => 'required|date',
            'pekerjaan'             => 'required|string',
            'foto'                  => 'image|mimes:jpeg,png,gif,webp|max:2048',
            'kata_sandi'            => 'required|min:6|required_with:konfirmasi_kata_sandi|same:konfirmasi_kata_sandi',
            'konfirmasi_kata_sandi' => 'required|min:6'
        ]);
        $image = 'default.jpg';
        $file = $request->file('foto');
        if (!empty($file)) {
            $image = time() . "_" . $file->getClientOriginalName();
            if (!$file->move(public_path('img/profile'), $image)) {
                Alert::error('Foto gagal diunggah', 'gagal')->persistent('tutup');
                return redirect('/users/create');
            }
        }

        User::create([
            'role_id'       => $request->peran,
            'nik'           => $request->nik,
            'name'          => $request->nama_lengkap,
            'image'         => $image,
            'gender_id'     => $request->jenis_kelamin,
            'religion_id'   => $request->agama,
            'marital_id'    => $request->status_pernikahan,
            'phone_number'  => $request->nomor_telepon,
            'address'       => $request->alamat,
            'birth_place'   => $request->tempat_lahir,
            'birth_date'    => $request->tanggal_lahir,
            'job'           => $request->pekerjaan,
            'email'         => $request->email,
            'password'      => Hash::make($request->konfirmasi_kata_sandi),
        ]);
        Alert::success('Pengguna berhasil ditambahkan', 'berhasil');
        return redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $title = 'Profil Saya';
        return view('user.show', compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Manajemen Pengguna';
        $subtitle = 'Ubah Pengguna';
        $user = User::findOrFail($id);
        $user_role = UserRole::all();
        $genders = Gender::all();
        $religions = Religion::all();
        $maritals = Marital::all();
        return view('user.edit', compact('title', 'subtitle', 'user', 'user_role', 'genders', 'religions', 'maritals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'peran'             => 'required|numeric',
            'nama_lengkap'      => 'required|string',
            'nik'               => 'required|numeric',
            'email'             => 'required|string|email',
            'jenis_kelamin'     => 'required',
            'agama'             => 'required',
            'status_pernikahan' => 'required',
            'nomor_telepon'     => 'nullable|numeric',
            'alamat'            => 'required',
            'tempat_lahir'      => 'required|string',
            'tanggal_lahir'     => 'required|date',
            'pekerjaan'         => 'required|string',
            'foto'              => 'image|mimes:jpeg,png,gif,webp|max:2048'
        ]);

        $file = $request->file('foto');
        if (!empty($file)) {
            $file_name = time() . "_" . $file->getClientOriginalName();
            if ($file->move(public_path('img/profile'), $file_name)) {
                if ($user->image != "default.jpg") {
                    File::delete(public_path('img/profile/' . $user->image));
                }
                $user->image = $file_name;
            } else {
                Alert::error('Foto gagal diunggah', 'gagal')->persistent('tutup');
                return redirect()->route('users.edit', $id);
            }
        }

        User::where('id', $id)->update([
            'role_id'       => $request->peran,
            'nik'           => $request->nik,
            'name'          => $request->nama_lengkap,
            'image'         => $user->image,
            'gender_id'     => $request->jenis_kelamin,
            'religion_id'   => $request->agama,
            'marital_id'    => $request->status_pernikahan,
            'phone_number'  => $request->nomor_telepon,
            'address'       => $request->alamat,
            'birth_place'   => $request->tempat_lahir,
            'birth_date'    => $request->tanggal_lahir,
            'job'           => $request->pekerjaan,
            'email'         => $request->email,
        ]);
        Alert::success('Pengguna berhasil diperbarui', 'berhasil');
        return redirect()->route('users.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::onlyTrashed()->where('id', $id);
        $image = DB::table('users')->where('id', $id)->first();
        if ($image->image != 'default.jpg') {
            File::delete(public_path('img/profile/' . $image->image));
        }
        $user->forceDelete();
        Alert::success('Pengguna berhasil dihapus', 'berhasil');
        return redirect('/user/trash');
    }

    public function softdelete($id)
    {
        $user = User::find($id);
        $user->delete();
        Alert::success('Pengguna berhasil dihapus', 'berhasil');
        return redirect('/users');
    }

    public function trash()
    {
        $title = 'Manajemen Pengguna';
        $subtitle = 'Pengguna Terhapus';
        $users = User::onlyTrashed()->get();
        return view('user.trash', compact('title', 'subtitle', 'users'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id);
        $user->restore();
        Alert::success('Pengguna berhasil dikembalikan', 'berhasil');
        return redirect('/users');
    }

    public function restoreAll()
    {
        $user = User::onlyTrashed();
        $user_deleted = DB::table('users')->where('deleted_at','!=',null)->first();
        if (!empty($user_deleted)) {
            $user->restore();
            Alert::success('Pengguna berhasil dikembalikan semua', 'berhasil');
            return redirect('/users');
        } else {
            Alert::error('Tidak ada pengguna yang dikembalikan, karena tidak ada pengguna yang terhapus', 'gagal')->persistent('tutup');
            return redirect('/users/trash');
        }
    }

    public function editProfile()
    {
        $title = 'Ubah Profil';
        $genders = Gender::all();
        $religions = Religion::all();
        $maritals = Marital::all();
        return view('user.edit-profile', compact('title', 'genders', 'religions', 'maritals'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'nama_lengkap'      => 'required|string',
            'nik'               => 'required|numeric',
            'email'             => 'required|string|email',
            'jenis_kelamin'     => 'required',
            'agama'             => 'required',
            'status_pernikahan' => 'required',
            'nomor_telepon'     => 'nullable|numeric',
            'alamat'            => 'required',
            'tempat_lahir'      => 'required|string',
            'tanggal_lahir'     => 'required|date',
            'pekerjaan'         => 'required|string',
            'foto'              => 'image|mimes:jpeg,png,gif,webp|max:2048'
        ]);
        $file = $request->file('image');
        if (!empty($file)) {
            $file_name = time() . "_" . $file->getClientOriginalName();
            if ($file->move(public_path('img/profile'), $file_name)) {
                if ($user->image != "default.jpg") {
                    File::delete(public_path('img/profile/' . $user->image));
                }
                $user->image = $file_name;
            } else {
                Alert::error('Foto gagal diunggah', 'gagal')->persistent('tutup');
                return redirect('/my-profile');
            }
        }

        User::where('id', $id)->update([
            'nik'           => $request->nik,
            'name'          => $request->nama_lengkap,
            'image'         => $user->image,
            'gender_id'     => $request->jenis_kelamin,
            'religion_id'   => $request->agama,
            'marital_id'    => $request->status_pernikahan,
            'phone_number'  => $request->nomor_telepon,
            'address'       => $request->alamat,
            'birth_place'   => $request->tempat_lahir,
            'birth_date'    => $request->tanggal_lahir,
            'job'           => $request->pekerjaan,
            'email'         => $request->email,
        ]);
        Alert::success('Profil berhasil diperbarui', 'berhasil');
        return redirect('/my-profile');
    }

    public function changePassword()
    {
        $title = 'Ganti Kata Sandi';
        return view('user.change-password', compact('title'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'kata_sandi'                => 'required|min:6',
            'kata_sandi_baru'           => 'required|min:6|required_with:konfirmasi_kata_sandi|same:konfirmasi_kata_sandi',
            'konfirmasi_kata_sandi'     => 'required|min:6'
        ]);

        $user = User::find($id);

        if (Hash::check($request->kata_sandi, $user->password)) {
            if ($request->kata_sandi == $request->konfirmasi_kata_sandi) {
                Alert::error('Kata sandi gagal diperbarui, tidak ada yang berubah pada kata sandi', 'gagal')->persistent("tutup");
                return redirect('/my-profile');
            } else {
                if ($request->kata_sandi_baru == $request->konfirmasi_kata_sandi) {
                    User::where('id', $id)->update([
                        'password' => Hash::make($request->konfirmasi_kata_sandi)
                    ]);
                    Alert::success('Kata sandi berhasil diperbarui', 'berhasil');
                    return redirect('/my-profile');
                } else {
                    Alert::error('Kata sandi tidak cocok', 'gagal')->persistent("tutup");
                    return redirect('/my-profile');
                }
            }
        } else {
            Alert::error('Kata sandi tidak cocok dengan kata sandi lama', 'gagal')->persistent("tutup");
            return redirect('/my-profile');
        }
    }
}
