<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookingRequest extends BaseApiRequest
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
            'namaKos' => 'string|required|min:3',
            'alamat' => 'string|required|min:3',
            'cerita' => 'string|required|min:3',
            'disetujui' => 'string|required',
            'fasKamar' => 'string|required|min:3',
            'fasKamarmandi' => 'string|required|min:3',
            'fasParkir' => 'string|required|min:3',
            'fasUmum' => 'string|required|min:3',
            'harga' => 'string|required|min:3',
            'hargaPromo' => 'string|min:3',
            'isPromo' => 'string|required',
            'lokasi' => 'string|required|min:5',
            'jlhKamar' => 'integer|required|min:1',
            'jenis' => 'string|required|min:3',
            'namaKecamatan' => 'string|required|min:3',
            'pemilikId' => 'integer|required|min:1',
            'peraturan' => 'string|required|min:3',
            'spektipekamar' => 'string|required|min:3',
            'tipe' => 'string|required|min:3',


        ];
    }
}
