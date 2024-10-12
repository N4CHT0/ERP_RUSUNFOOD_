<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $table = 'produksi';
    protected $primaryKey = "id"; // Ejaan yang benar untuk 'primaryKey'
    protected $fillable = [
        'id_produk',
        'jumlah_produksi',
        'kode_produksi',
        'tanggal_produksi',
        'tanggal_kadaluarsa',
        'tanggal_selesai_produksi',
        'bahan_digunakan', // Bahan baku yang disimpan sebagai JSON
    ];

    // Cast 'bahan_digunakan' sebagai array otomatis
    protected $casts = [
        'bahan_digunakan' => 'array', // Laravel otomatis akan decode JSON menjadi array
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
