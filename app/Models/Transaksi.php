<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function kasir()
    {
        return $this->belongsTo(\App\Models\User::class, 'kasir_id');
    }
}
