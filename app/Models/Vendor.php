<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendor';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
        'alamat',
        'no_telepon',
        'email',
        'foto',
        'bahan_baku', // Pastikan kolom ini ada di database dan disimpan sebagai JSON
    ];

    protected $casts = [
        'bahan_baku' => 'array', // Mengubah kolom JSON menjadi array otomatis
    ];

    public function getDetailedBahanBakuAttribute()
    {
        if (is_array($this->bahan_baku)) {
            return Material::whereIn('id', array_column($this->bahan_baku, 'id'))->get()->map(function ($material) {
                $detail = collect($this->bahan_baku)->firstWhere('id', $material->id);
                return [
                    'id' => $material->id,
                    'nama_bahan' => $material->nama_bahan,
                    'harga_jual' => $detail['harga_jual'] ?? null,
                ];
            });
        }
        return collect();
    }
}
