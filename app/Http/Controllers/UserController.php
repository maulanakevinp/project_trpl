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
        $title = 'Users Management';
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
        $title = 'Users Management';
        $subtitle = 'Add New User';
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
            'role' => 'required|numeric',
            'name' => 'required|string',
            'nik' => 'required|numeric',
            'email' => 'required|string|email|unique:users',
            'gender' => 'required',
            'religion' => 'required',
            'marital' => 'required',
            'address' => 'required',
            'birth_place' => 'required|string',
            'birth_date' => 'required|date',
            'job' => 'required|string',
            'image' => 'image|mimes:jpeg,png,gif,webp|max:2048',
            'password' => 'required|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:6'
        ]);
        $image = 'default.jpg';
        $file = $request->file('image');
        if (!empty($file)) {
            $image = time() . "_" . $file->getClientOriginalName();
            if (!$file->move(public_path('img/profile'), $image)) {
                return redirect('/users')->with('failed', 'User has not been added');
            }
        }

        User::create([
            'role_id' => $request->role,
            'name' => $request->name,
            'image' => $image,
            'gender_id' => $request->gender,
            'religion_id' => $request->religion,
            'marital_id' => $request->marital,
            'address' => $request->address,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'job' => $request->job,
            'email' => $request->email,
            'password' => Hash::make($request->confirm_password),
        ]);
        return redirect('/users')->with('success', 'User has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $title = 'My Profile';
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
        $title = 'Users Management';
        $subtitle = 'Edit User';
        $user = User::find($id);
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
            'role' => 'required|numeric',
            'name' => 'required',
            'nik' => 'required|numeric',
            'email' => 'required|email',
            'gender' => 'required',
            'religion' => 'required',
            'marital' => 'required',
            'address' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required|date',
            'job' => 'required',
            'image' => 'image|mimes:jpeg,png,gif,webp|max:2048'
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
                return redirect('/users' . '/' . $id . '/edit')->with('failed', 'Photo cannot moved');
            }
        }

        User::where('id', $id)->update([
            'role_id' => $request->role,
            'name' => $request->name,
            'nik' => $request->nik,
            'image' => $user->image,
            'gender_id' => $request->gender,
            'religion_id' => $request->religion,
            'marital_id' => $request->marital,
            'address' => $request->address,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'job' => $request->job,
            'email' => $request->email
        ]);
        return redirect('/users' . '/' . $id . '/edit')->with('success', 'Profile has been updated');
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
            return redirect('/users')->with('success', 'User has been deleted');
        } else {
            return redirect('/users')->with('failed', 'User has not been deleted');
        }
    }

    public function softdelete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/users')->with('success', 'User has been deleted');
    }

    public function trash()
    {
        $title = 'Users Management';
        $subtitle = 'Users Trash';
        $users = User::onlyTrashed()->get();
        return view('user.trash', compact('title', 'subtitle', 'users'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id);
        $user->restore();
        return redirect('/users')->with('success', 'User has been restored');
    }

    public function restoreAll()
    {
        $user = User::onlyTrashed();
        $user->restore();
        return redirect('/users')->with('success', 'User has been restored');
    }

    public function editProfile()
    {
        $title = 'Edit Profile';
        $genders = Gender::all();
        $religions = Religion::all();
        $maritals = Marital::all();
        return view('user.edit-profile', compact('title', 'genders', 'religions', 'maritals'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'name' => 'required',
            'nik' => 'required|numeric',
            'email' => 'required|email',
            'gender' => 'required',
            'religion' => 'required',
            'marital' => 'required',
            'address' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required|date',
            'job' => 'required',
            'image' => 'image|mimes:jpeg,png,gif,webp|max:2048'
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
                return redirect('/my-profile')->with('failed', 'Photo cannot moved');
            }
        }

        User::where('id', $id)->update([
            'name' => $request->name,
            'nik' => $request->nik,
            'image' => $user->image,
            'gender_id' => $request->gender,
            'religion_id' => $request->religion,
            'marital_id' => $request->marital,
            'address' => $request->address,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'job' => $request->job,
            'email' => $request->email
        ]);
        return redirect('/my-profile')->with('success', 'Profile has been updated');
    }

    public function changePassword()
    {
        $title = 'Change Password';
        return view('user.change-password', compact('title'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => 'required|min:6',
            'new_password' => 'required|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:6'
        ]);

        $user = User::find($id);

        if (Hash::check($request->current_password, $user->password)) {
            if ($request->current_password == $request->confirm_password) {
                return redirect('/my-profile')->with('failed', 'Password has not been updated, nothing changed in password');
            } else {
                if ($request->new_password == $request->confirm_password) {
                    User::where('id', $id)->update([
                        'password' => Hash::make($request->confirm_password)
                    ]);
                    return redirect('/my-profile')->with('success', 'Password has been updated');
                } else {
                    return redirect('/my-profile')->with('failed', 'Password not match, Password has not been updated');
                }
            }
        } else {
            return redirect('/my-profile')->with('failed', 'Password not match with old password, Password has not been updated');
        }
    }
}
