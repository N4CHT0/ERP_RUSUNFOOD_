<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Product;
use App\Models\Production;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index()
    {
        // Ambil data produksi dengan relasi ke produk
        $data = Production::with('product')->get(); // Menggunakan get() agar bisa memodifikasi data

        // Ambil semua data material dan produk untuk keperluan form
        $materials = Material::all(); // Ambil semua bahan baku
        $products = Product::all();

        // Modifikasi setiap produksi untuk menyertakan nama bahan baku di dalam JSON
        foreach ($data as $production) {
            $bahan_digunakan = $production->bahan_digunakan; // Ambil JSON dari kolom bahan_digunakan

            // Loop melalui setiap bahan baku yang digunakan
            if (is_array($bahan_digunakan)) {
                foreach ($bahan_digunakan as &$bahan) {
                    // Ambil nama bahan baku berdasarkan id_bahan_baku dari JSON
                    $material = Material::find($bahan['id_bahan_baku']); // Cari di tabel Material berdasarkan ID
                    if ($material) {
                        $bahan['nama_bahan'] = $material->nama_bahan; // Tambahkan nama bahan ke array
                    } else {
                        $bahan['nama_bahan'] = 'Tidak diketahui'; // Jika bahan baku tidak ditemukan
                    }
                }

                // Simpan kembali array bahan_digunakan dengan nama bahan ke dalam object produksi
                $production->bahan_digunakan = $bahan_digunakan;
            }
        }

        return view('modules.manufacturing.index', [
            'materials' => $materials,  // Data material untuk form
            'products' => $products,    // Data produk untuk form
            'data' => $data,            // Data produksi untuk tabel
        ]);
    }


    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_produksi' => 'required|string|max:255',
            'produk' => 'required|integer', // Produk harus berupa integer
            'jumlah_produksi' => 'required|numeric',
            'tanggal_produksi' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date',
            'tanggal_selesai_produksi' => 'required|date',
            'bahan_baku' => 'required|array', // Bahan baku sebagai array
            'bahan_baku.*' => 'required|integer', // Pastikan ID bahan baku adalah integer
            'bahan_digunakan' => 'required|array', // Jumlah bahan yang digunakan sebagai array
            'bahan_digunakan.*' => 'required|numeric',
        ]);

        // Siapkan array untuk menyimpan bahan baku dan jumlahnya sebagai JSON
        $bahanBakuData = [];
        foreach ($request->bahan_baku as $key => $bahanBakuId) {
            $bahanBakuData[] = [
                'id_bahan_baku' => $bahanBakuId,
                'jumlah_digunakan' => $request->bahan_digunakan[$key],
            ];
        }

        // Simpan data produksi
        $production = Production::create([
            'kode_produksi' => $request->kode_produksi,
            'jumlah_produksi' => $request->jumlah_produksi,
            'tanggal_produksi' => $request->tanggal_produksi,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'tanggal_selesai_produksi' => $request->tanggal_selesai_produksi,
            'id_produk' => $request->produk,
            'bahan_digunakan' => $bahanBakuData, // Tidak perlu menggunakan json_encode() karena sudah di-cast ke array
        ]);

        return redirect()->route('Production.index')->with('success', 'Data berhasil disimpan');
    }

    public function cetakPDF($id)
    {
        // Ambil data produksi berdasarkan ID
        $production = Production::with('product')->findOrFail($id);

        // Ambil data bahan_digunakan dari kolom JSON
        $bahan_digunakan = $production->bahan_digunakan;

        // Hitung Harga BOM berdasarkan bahan_digunakan
        foreach ($bahan_digunakan as &$bahan) {
            $material = Material::find($bahan['id_bahan_baku']);
            if ($material) {
                $bahan['nama_bahan'] = $material->nama_bahan;
                $bahan['harga_bahan'] = $material->harga_bahan;
                // Hitung harga BOM = jumlah bahan * harga bahan
                $bahan['harga_bom'] = $bahan['jumlah_digunakan'] * $material->harga_bahan;
            } else {
                $bahan['nama_bahan'] = 'Tidak diketahui';
                $bahan['harga_bom'] = 0;
            }
        }

        // Buat PDF berdasarkan view
        $pdf = PDF::loadView('modules.manufacturing.reports.bom', compact('production', 'bahan_digunakan'));

        // Unduh PDF
        return $pdf->download('BOM-Report-' . $production->kode_produksi . '.pdf');
    }
}
