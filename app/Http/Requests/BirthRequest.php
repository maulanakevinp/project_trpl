<?php

namespace App\Http\Requests;

use App\Rules\BirthDate;
use Illuminate\Foundation\Http\FormRequest;

class BirthRequest extends FormRequest
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
            'nama'                  => ['required'],
            'jenis_kelamin'         => ['required'],
            'tempat_lahir'          => ['required'],
            'tanggal_lahir'         => ['required','date',new BirthDate],
            'agama'                 => ['required'],
            'alamat'                => ['required'],
            'anak_ke'               => ['required','numeric','min:1'],
            'nama_orangtua'         => ['required'],
            'usia_orangtua'         => ['required','numeric','min:1'],
            'pekerjaan_orangtua'    => ['required'],
            'alamat_orangtua'       => ['required'],
        ];
        if (request()->isMethod('post')) {
            $rules['surat_pengantar'] = ['required','image','mimes:jpeg,png','max:2048'];
        } else if(request()->isMethod('patch')){
            $rules['surat_pengantar'] = ['image','mimes:jpeg,png','max:2048'];
        }
        return $rules;
    }
}
