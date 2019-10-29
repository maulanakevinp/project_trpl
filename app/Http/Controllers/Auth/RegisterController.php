<?php

namespace App\Http\Controllers\Auth;

use App\Gender;
use App\User;
use App\Http\Controllers\Controller;
use App\Marital;
use App\Religion;
use App\Rules\BirthDate;
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
            'nama'              => ['required', 'string', 'max:255'],
            'nik'               => ['required', 'digits:16'],
            'jenis_kelamin'     => ['required'],
            'agama'             => ['required'],
            'status_pernikahan' => ['required'],
            'alamat'            => ['required', 'string'],
            'tempat_lahir'      => ['required', 'string', 'max:255'],
            'tanggal_lahir'     => ['required', 'date', new BirthDate],
            'pekerjaan'         => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'          => ['required', 'string', 'min:6', 'confirmed'],
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
            'role_id'       => 4,
            'nik'           => $data['nik'],
            'name'          => $data['nama'],
            'image'         => 'default.jpg',
            'gender_id'     => $data['jenis_kelamin'],
            'religion_id'   => $data['agama'],
            'marital_id'    => $data['status_pernikahan'],
            'address'       => $data['alamat'],
            'birth_place'   => $data['tempat_lahir'],
            'birth_date'    => $data['tanggal_lahir'],
            'job'           => $data['pekerjaan'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
        ]);
    }
}
