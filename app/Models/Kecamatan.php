<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $fillable = ['namaKecamatan'];
    protected $guarded = [];

    public function penginapans()
    {
        return $this->hasMany(Penginapan::class, 'namaKecamatan', 'namaKecamatan');
    }
}
