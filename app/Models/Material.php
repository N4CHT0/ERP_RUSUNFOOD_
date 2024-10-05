<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table = 'bahan_baku';
    protected $primarykey = "id";
    protected $fillable = [
        'id',
        'kode_bahan_baku',
        'nama_bahan',
        'jumlah_bahan',
        'satuan_bahan',
        'harga_bahan',
        'mata_uang',
    ];
}
