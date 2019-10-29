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
use App\Http\Requests\UserRequest;

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
    public function store(UserRequest $request)
    {
        $request->validated();

        $image = 'default.jpg';
        if ($request->file('foto')) {
            $nik_file = $this->uploadFile($request->file('foto'), 'img/profile');
        }

        $nik_file = null;
        if ($request->file('nik_file')) {
            $nik_file = $this->uploadFile($request->file('nik_file'), 'img/nik');
        }

        $kk_file = null;
        if ($request->file('kk_file')) {
            $kk_file = $this->uploadFile($request->file('kk_file'), 'img/kk');
        }

        User::create($this->dataUser('store', $request, $image, $nik_file, $kk_file));
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
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        $request->validated();

        if ($request->file('foto')) {
            $user->image = $this->updateUploadPhoto($request->file('foto'), 'img/profile', $user->image);
        }

        if ($request->file('nik_file')) {
            $user->nik_file = $this->uploadFile($request->file('nik_file'), 'img/nik');
        }

        if ($request->file('kk_file')) {
            $user->kk_file = $this->uploadFile($request->file('kk_file'), 'img/kk');
        }

        User::where('id', $id)->update($this->dataUser('update', $request, $user->image, $user->nik_file, $user->kk_file));
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
        if ($image->nik_file != null) {
            if (file_exists(public_path('img/nik/' . $image->nik_file))) {
                File::delete(public_path('img/nik/' . $image->nik_file));
            }
        }
        if ($image->kk_file != null) {
            if (file_exists(public_path('img/kk/' . $image->kk_file))) {
                File::delete(public_path('img/kk/' . $image->kk_file));
            }
        }
        $user->forceDelete();
        Alert::success('Pengguna berhasil dihapus', 'berhasil');
        return redirect()->back();
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
        $user_deleted = DB::table('users')->where('deleted_at', '!=', null)->first();
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

    public function updateProfile(UserRequest $request, $id)
    {
        $user = User::find($id);
        $request->validated();

        if ($request->file('foto')) {
            $user->image = $this->updateUploadPhoto($request->file('foto'), 'img/profile', $user->image);
        }

        if ($request->file('nik_file')) {
            $user->nik_file = $this->uploadFile($request->file('nik_file'), 'img/nik');
        }

        if ($request->file('kk_file')) {
            $user->kk_file = $this->uploadFile($request->file('kk_file'), 'img/kk');
        }

        User::where('id', $id)->update($this->dataUser('updateProfile', $request, $user->image, $user->nik_file, $user->kk_file));
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

    public function detailKK($kk_file)
    {
        if (auth()->user()->kk_file == $kk_file || auth()->user()->role_id == 2 || auth()->user()->role_id == 3 || auth()->user()->role_id == 1) {
            $title = 'Detail KK';
            $file = 'img/kk/' . $kk_file;
            $file_name = $kk_file;
            return view('user/detail', compact('title', 'file', 'file_name'));
        }
    }

    public function detailNIK($nik_file)
    {
        if (auth()->user()->nik_file == $nik_file || auth()->user()->role_id == 2 || auth()->user()->role_id == 3 || auth()->user()->role_id == 1) {
            $title = 'Detail NIK';
            $file = 'img/nik/'.$nik_file;
            $file_name = $nik_file;
            return view('user/detail', compact('title','file','file_name'));
        }
    }

    private function uploadFile($file, $path)
    {
        $name = time() . "_" . $file->getClientOriginalName();
        if (!$file->move(public_path($path), $name)) {
            Alert::error('Foto gagal diunggah', 'gagal')->persistent('tutup');
            return redirect()->back();
        } else {
            return $name;
        }
    }

    private function updateUploadPhoto($file, $path, $old_file)
    {
        $file_name = time() . "_" . $file->getClientOriginalName();
        if ($file->move(public_path($path), $file_name)) {
            if ($old_file != "default.jpg") {
                File::delete(public_path('img/profile/' . $old_file));
            }
            return $file_name;
        } else {
            Alert::error('Foto gagal diunggah', 'gagal')->persistent('tutup');
            return redirect()->back();
        }
    }

    private function dataUser($method, $request, $image, $nik_file, $kk_file)
    {
        $data = [
            'nik'           => $request->nik,
            'nik_file'      => $nik_file,
            'kk'            => $request->kk,
            'kk_file'       => $kk_file,
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
        ];

        if ($method == 'store') {
            $data['role_id'] = $request->peran;
            $data['password'] = Hash::make($request->konfirmasi_kata_sandi);
        } else if ($method == 'update') {
            $data['role_id'] = $request->peran;
        }

        return $data;
    }
}
