<?php

namespace App\Http\Controllers\Auth;

use App\Gender;
use App\User;
use App\Http\Controllers\Controller;
use App\Marital;
use App\Religion;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/my-profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function showRegistrationForm()
    {
        $religions = Religion::all();
        $genders = Gender::all();
        $maritals = Marital::all();
        return view('auth.register', compact('genders', 'religions', 'maritals'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16'],
            'gender' => ['required'],
            'religion' => ['required'],
            'marital' => ['required'],
            'address' => ['required', 'string'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required'],
            'job' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'role_id' => 4,
            'nik' => $data['nik'],
            'name' => $data['name'],
            'image' => 'default.jpg',
            'gender_id' => $data['gender'],
            'religion_id' => $data['religion'],
            'marital_id' => $data['marital'],
            'address' => $data['address'],
            'birth_place' => $data['birth_place'],
            'birth_date' => $data['birth_date'],
            'job' => $data['job'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
