<?php

namespace App\Http\Requests;

use App\Rules\BirthDate;
use Illuminate\Foundation\Http\FormRequest;

class IncapableRequest extends FormRequest
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
            'nama'            => ['required','max:60'],
            'tempat_lahir'    => ['required','max:60'],
            'tanggal_lahir'   => ['required','date',new BirthDate],
            'pekerjaan'       => ['required','max:60'],
            'alamat'          => ['required'],
            'tujuan'          => ['required','max:60'],
            'merupakan'       => ['required'],
        ];
        if (request()->isMethod('post')) {
            $rules['surat_pengantar'] = ['required','image','mimes:jpeg,png','max:2048'];
        } else if(request()->isMethod('patch')){
            $rules['surat_pengantar'] = ['image','mimes:jpeg,png','max:2048'];
        }
        return $rules;
    }
}
