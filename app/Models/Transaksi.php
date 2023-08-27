<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'pencariId', 'noTransaksi', 'tglTransaksi', 'tglBooking', 'namaPencari', 'kosId', 'jlhKamar',
         'pemilikId', 'catatanPesanan',
        'totalBayar', 'buktiBayar', 'atasNama', 'namaBank', 'noRek', 'statusTransaksi',
    ];
    protected $guarded = [];

    public function user_pemiliks()
    {
        return $this->hasMany(UserPemilik::class, 'id', 'pemilikId');
    }

    public function user_pencaris()
    {
        return $this->hasMany(UserPencari::class, 'id', 'pencariId');
    }

    public function penginapans()
    {
        return $this->hasMany(Penginapan::class, 'id', 'kosId');
    }

}
