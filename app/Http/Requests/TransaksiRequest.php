<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'noTranskasi' => 'string|required|min:3',
            'tglTransaksi' => 'date|required',
            'namaPencari' => 'string|required|min:3',
            'kosId' => 'integer|required|min:3',
            'pemilikId' => 'integer|required|min:3',
            'totalBayar' => 'integer|required|min:3',
            'buktiBayar' => 'text|required|min:3',
            'atasNama' => 'string|required|min:3',
            'namaBank' => 'string|required|min:3',
            'noRek' => 'integer|required|min:3',

        ];
    }
}
