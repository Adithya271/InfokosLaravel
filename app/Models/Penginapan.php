<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penginapan extends Model
{
    use HasFactory;
    protected $fillable = [
        'namakos', 'alamat', 'cerita', 'disetujui', 'fasKamar',
        'fasKamarmandi', 'fasParkir', 'fasUmum', 'harga', 'hargaPromo',
        'gambarKos', 'isPromo', 'jenis', 'lokasi', 'jlhKamar', 'namaKecamatan',
        'pemilikId', 'peraturan', 'spektipekamar', 'tipe'
    ];
    protected $guarded = [];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'namaKecamatan', 'namaKecamatan');
    }

    public function user_pemilik()
    {
        return $this->hasOne(UserPemilik::class, 'id', 'pemilikId');
    }

    public function saveImage($filename)
    {
        $this->gambarKos = $filename;
        $this->save();
    }
}
