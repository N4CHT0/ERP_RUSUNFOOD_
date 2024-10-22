<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
    use HasFactory;
    protected $table = 'manufaktur';
    protected $primaryKey = "id"; // Ejaan yang benar untuk 'primaryKey'
    protected $fillable = [
        'id_produk',
        'id_bom',
        'jumlah',
        'kode_manufaktur',
        'perusahaan',
        'dibutuhkan',
        'stok',
        'terkonsumsi',
        'rencana_produksi',
        'batas_produksi',
        'dibutuhkan',
        'stok',
        'dikonsumsi',
        'status',
    ];

    // Set default value untuk field 'status'
    protected $attributes = [
        'status' => 'draft',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function bom()
    {
        return $this->belongsTo(Production::class, 'id_bom');
    }
}
