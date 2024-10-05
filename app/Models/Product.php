<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $primarykey = "id";
    protected $fillable = [
        'id',
        'kode_produk',
        'nama_produk',
        'jumlah_produk',
        'id_bahan_baku',
        'harga_produk',
        'mata_uang',

    ];
    public function Material()
    {
        return $this->belongsTo(User::class, 'id_bahan_baku');
    }
}
