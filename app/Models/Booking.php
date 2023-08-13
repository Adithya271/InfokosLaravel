<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'namakos', 'alamat', 'cerita', 'disetujui', 'fasKamar',
        'fasKamarmandi', 'fasParkir', 'fasUmum', 'harga', 'hargaPromo',
         'gambarKos', 'isPromo', 'jenis', 'lokasi', 'jlhKamar', 'kecamatan',
          'pemilikId', 'peraturan', 'spektipekamar', 'tipe', 'pencariId'
    ];
    protected $guarded = [];
}
