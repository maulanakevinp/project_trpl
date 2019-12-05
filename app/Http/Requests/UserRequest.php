<?php

namespace App\Http\Requests;

use App\Rules\BirthDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'nama_lengkap'          => ['required','string','max:60'],
            'jenis_kelamin'         => ['required'],
            'agama'                 => ['required'],
            'status_pernikahan'     => ['required'],
            'nomor_telepon'         => ['nullable','digits_between:7,13'],
            'alamat'                => ['required','string'],
            'tempat_lahir'          => ['required','string','max:60'],
            'tanggal_lahir'         => ['required','date',new BirthDate],
            'pekerjaan'             => ['required','string','max:60'],
            'foto'                  => ['nullable','image','mimes:jpeg,png,gif,webp,bmp','max:2048'],
            'nik_file'              => ['nullable','image','mimes:jpeg,png,bmp','max:2048'],
            'kk_file'               => ['nullable','image','mimes:jpeg,png,bmp','max:2048'],
        ];

        if (request()->isMethod('post')) {
            $rules['peran']                 = ['required','numeric'];
            $rules['email']                 = ['required','string','email','unique:users','max:60'];
            $rules['nik']                   = ['required','digits:16','unique:users'];
            $rules['kk']                    = ['nullable','digits:16','required_with:kk_file','unique:users'];
            $rules['kata_sandi']            = ['required','min:6','required_with:konfirmasi_kata_sandi','same:konfirmasi_kata_sandi'];
            $rules['konfirmasi_kata_sandi'] = ['required','min:6'];
        } else if(request()->isMethod('patch')){
            $rules['peran']                 = ['required','numeric'];
            $rules['email']                 = ['required','string','email','max:60', Rule::unique('users','email')->ignore($this->user)];
            $rules['nik']                   = ['required','digits:16',Rule::unique('users','nik')->ignore($this->user)];
            $rules['kk']                    = ['nullable','digits:16','required_with:kk_file',Rule::unique('users','kk')->ignore($this->user)];
        }
        return $rules;
    }
}
