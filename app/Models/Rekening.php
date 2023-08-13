<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;
    protected $fillable = [
        'pemilikId', 'namaBank', 'noRek', 'atasNama'
    ];
    protected $guarded = [];

    public function user_pemiliks()
    {
        return $this->hasMany(UserPemilik::class, 'id', 'pemilikId');
    }
}
