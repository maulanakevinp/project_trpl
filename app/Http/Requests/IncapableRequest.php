<?php

namespace App\Http\Requests;

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
        return [
            'nama'              => 'required',
            'tempat_lahir'      => 'required',
            'tanggal_lahir'     => 'required|date',
            'pekerjaan'         => 'required',
            'alamat'            => 'required',
            'alasan_pengajuan'  => 'required',
            'merupakan'         => 'required',
        ];
    }
}
