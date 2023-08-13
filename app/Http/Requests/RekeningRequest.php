<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RekeningRequest extends FormRequest
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
            'pemilikId' => 'string|required|min:3',
            'namaBank' => 'string|required|min:3',
            'noRek' => 'string|required',
            'atasNama' => 'string|required|min:3',
        ];
    }
}
