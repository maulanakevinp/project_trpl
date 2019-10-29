<?php

namespace App\Http\Requests;

use App\Rules\BirthDate;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'nama_lengkap'          => ['required','string','max:255'],
            'nik'                   => ['required','digits:16'],
            'kk'                    => ['nullable','digits:16','required_with:kk_file'],
            'email'                 => ['required','string','email','max:255'],
            'jenis_kelamin'         => ['required'],
            'agama'                 => ['required'],
            'status_pernikahan'     => ['required'],
            'nomor_telepon'         => ['nullable','digits_between:7,13'],
            'alamat'                => ['required','string'],
            'tempat_lahir'          => ['required','string'],
            'tanggal_lahir'         => ['required','date',new BirthDate],
            'pekerjaan'             => ['required','string'],
            'foto'                  => ['nullable','image','mimes:jpeg,png,gif,webp','max:2048'],
            'nik_file'              => ['nullable','image','mimes:jpeg,png','max:2048'],
            'kk_file'               => ['nullable','image','mimes:jpeg,png','max:2048'],
        ];

        if (request()->isMethod('post')) {
            $rules['peran']                 = ['required','numeric'];
            $rules['email']                 = ['required','string','email','unique:users','max:255'];
            $rules['kata_sandi']            = ['required','min:6','required_with:konfirmasi_kata_sandi','same:konfirmasi_kata_sandi'];
            $rules['konfirmasi_kata_sandi'] = ['required','min:6'];
        } else if(request()->isMethod('patch')){
            $rules['peran']                 = ['required','numeric'];
        }
        return $rules;
    }
}
