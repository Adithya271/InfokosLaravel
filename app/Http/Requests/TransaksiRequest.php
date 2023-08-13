<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransaksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'pencariId' => 'integer|required',
            'noTransaksi' => 'string|required',
            'tglTransaksi' => 'date|required',
            'namaPencari' => 'string|required|min:3',
            'kosId' => 'integer|required',
            'pemilikId' => 'integer|required',
            'totalBayar' => 'integer|required|min:3',
            'buktiBayar' => 'required|file|mimes:jpeg,jpg,png,gif,bmp,pdf',
            'atasNama' => 'string|required|min:3',
            'namaBank' => 'string|required',
            'noRek' => 'integer|required|min:3',

        ];
    }
}
