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
            'nomor_telepon'     => 'nullable|numeric',
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
                return redirect('/users')->with('failed', 'Pengguna gagal ditambahkan');
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
        return redirect('/users')->with('success', 'Pengguna berhasil ditambahkan');
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
                return redirect('/users' . '/' . $id . '/edit')->with('failed', 'Foto gagal diunggah');
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
        return redirect('/users' . '/' . $id . '/edit')->with('success', 'Pengguna berhasil diperbarui');
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
        $delete = File::delete(public_path('img/profile/' . $image->image));

        if ($delete) {
            $user->forceDelete();
            return redirect('/users')->with('success', 'Pengguna berhasil dihapus');
        } else {
            return redirect('/users')->with('failed', 'Pengguna gagal dihapus');
        }
    }

    public function softdelete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/users')->with('success', 'Pengguna berhasil dihapus');
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
        return redirect('/users')->with('success', 'Pengguna berhasil dikembalikan');
    }

    public function restoreAll()
    {
        $user = User::onlyTrashed();
        $user->restore();
        return redirect('/users')->with('success', 'Pengguna berhasil dikembalikan semua');
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
                return redirect('/my-profile')->with('failed', 'Foto gagal diunggah');
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
        return redirect('/my-profile')->with('success', 'Profil berhasil diperbarui');
    }

    public function changePassword()
    {
        $title = 'Ganti Kata Sandi';
        return view('user.change-password', compact('title'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'kata_sandi' => 'required|min:6',
            'kata_sandi_baru' => 'required|min:6|required_with:konfirmasi_kata_sandi|same:konfirmasi_kata_sandi',
            'konfirmasi_kata_sandi' => 'required|min:6'
        ]);

        $user = User::find($id);

        if (Hash::check($request->kata_sandi, $user->password)) {
            if ($request->kata_sandi == $request->konfirmasi_kata_sandi) {
                return redirect('/my-profile')->with('failed', 'Kata sandi gagal diperbarui, tidak ada yang berubah pada kata sandi');
            } else {
                if ($request->kata_sandi_baru == $request->konfirmasi_kata_sandi) {
                    User::where('id', $id)->update([
                        'password' => Hash::make($request->konfirmasi_kata_sandi)
                    ]);
                    return redirect('/my-profile')->with('success', 'Kata sandi berhasil diperbarui');
                } else {
                    return redirect('/my-profile')->with('failed', 'Kata sandi tidak cocok');
                }
            }
        } else {
            return redirect('/my-profile')->with('failed', 'Kata sandi tidak cocok dengan kata sandi lama');
        }
    }
}
