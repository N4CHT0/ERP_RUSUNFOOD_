<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'pemesanan';
    protected $primarykey = "id";
    protected $fillable = [
        'id',
        'id_vendor',
        'id_bahan_baku',
        'kode_pemesanan',
        'deskripsi',
        'nama_pemesanan',
        'jumlah',
        'pajak',
        'tanggal_pemesanan',
        'total',
    ];
}
