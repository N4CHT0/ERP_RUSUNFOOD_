<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'id_vendor',
        'kode_pemesanan',
        'nama_pemesan',
        'pajak',
        'status',
        'tanggal_pemesanan',
        'total',
        'pemesanan_bahan',
        'metode_pembayaran',
        'tanggal_pembayaran',
        'dokumen',
    ];

    protected $casts = [
        'pemesanan_bahan' => 'array', // JSON ke array otomatis
    ];

    // Relasi ke tabel vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor');
    }

    // Ambil daftar bahan baku terkait vendor jika diperlukan
    public function getBahanBakuAttribute()
    {
        // Mengakses data bahan baku dari vendor terkait
        return $this->vendor->detailed_bahan_baku ?? [];
    }

    // Total perhitungan untuk subtotal dan pajak secara otomatis
    public function calculateTotals()
    {
        $subtotal = collect($this->pemesanan_bahan)->sum('subtotal');
        $pajak = $subtotal * (count($this->pemesanan_bahan) * 0.1); // Asumsi 10% per item
        $this->total = $subtotal + $pajak;
        $this->pajak = $pajak;
        $this->save();
    }
}
