<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManajemenObat extends Model
{
    use HasFactory;

    protected $table = 'manajemen_obats';
    protected $guarded = [];
    protected $fillable = [
        'nama',
        'no_batch',
        'tgl_kadaluarsa',
        'stok',
        'tgl_penerimaan',
        'harga_beli',
        'harga_jual',
        'catatan'
    ];
}
