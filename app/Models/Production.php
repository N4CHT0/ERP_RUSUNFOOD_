<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;
    protected $table = 'produksi';
    protected $primarykey = "id";
    protected $fillable = [
        'id',
        'id_produk',
        'id_bahan_baku',
        'jumlah_produksi',
        'kode_produksi',
        'total',
        'tanggal_produksi',
        'tanggal_kadaluarsa',
        'tanggal_selesai_produksi',
        'mata_uang',
        'berat_bersih',

    ];

    public function material()
    {
        return $this->belongsTo(Material::class, 'id_bahan_baku');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
