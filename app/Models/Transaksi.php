<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'pencariId', 'noTransaksi', 'tglTransaksi', 'namaPencari', 'kosId', 'pemilikId', 'catatanPesanan',
        'totalBayar', 'buktiBayar', 'atasNama', 'namaBank', 'noRek', 'statusTransaksi',
    ];
    protected $guarded = [];
}
