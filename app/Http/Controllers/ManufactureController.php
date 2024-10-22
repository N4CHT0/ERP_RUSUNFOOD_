<?php

namespace App\Http\Controllers;

use App\Models\Manufacture;
use App\Models\Material;
use App\Models\Product;
use App\Models\Production;
use Illuminate\Http\Request;

class ManufactureController extends Controller
{
    public function index()
    {
        // Ambil data produksi dengan relasi ke produk
        $data = Manufacture::with('product', 'bom')->get();

        // Ambil semua data material dan produk untuk keperluan form
        $materials = Material::all(); // Ambil semua bahan baku
        $products = Product::all();
        $boms = Production::all();

        return view('modules.manufacturing.manufacture', [
            'materials' => $materials,  // Data material untuk form
            'products' => $products,    // Data produk untuk form
            'boms' => $boms,            // Data bom untuk form
            'data' => $data,            // Data manufaktur untuk tabel
        ]);
    }

    public function getBomData($id)
    {
        $bom = Production::find($id);

        // Ambil bahan baku terkait BoM
        $bahan_baku = [];
        if ($bom && is_array($bom->bahan_digunakan)) {
            foreach ($bom->bahan_digunakan as $bahan) {
                $material = Material::find($bahan['id_bahan_baku']);
                if ($material) {
                    $bahan_baku[] = [
                        'nama_bahan' => $material->nama_bahan,
                        'jumlah_bahan' => $material->jumlah_bahan,  // Ini adalah reserved
                        'jumlah_digunakan' => $bahan['jumlah_digunakan']  // Ini adalah to consume
                    ];
                }
            }
        }

        return response()->json([
            'bahan_baku' => $bahan_baku
        ]);
    }



    public function store(Request $request)
    {
        // Validasi awal form
        $request->validate([
            'kode_manufaktur' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'rencana_produksi' => 'required|date',
            'batas_produksi' => 'required|date',
            'produk' => 'required',
            'bom' => 'required',
            'perusahaan' => 'required|string',
            'dibutuhkan' => 'required|numeric',  // Validasi untuk dibutuhkan
            'stok' => 'required|numeric',        // Validasi untuk stok
            'terkonsumsi' => 'required|numeric', // Validasi untuk terkonsumsi
        ]);

        // Ambil data BoM berdasarkan ID yang dipilih
        $bom = Production::find($request->bom);

        if (!$bom) {
            return redirect()->back()->with('error', 'BoM tidak ditemukan');
        }

        // Simpan data manufaktur
        $manufacture = new Manufacture([
            'kode_manufaktur' => $request->kode_manufaktur,
            'jumlah' => $request->jumlah,
            'rencana_produksi' => $request->rencana_produksi,
            'batas_produksi' => $request->batas_produksi,
            'id_produk' => $request->produk,
            'id_bom' => $request->bom,
            'perusahaan' => $request->perusahaan,
            'dibutuhkan' => $request->dibutuhkan,  // Ambil nilai dari form
            'stok' => $request->stok,              // Ambil nilai dari form
            'terkonsumsi' => $request->terkonsumsi, // Ambil nilai dari form
            'status' => 'draft',
        ]);

        $manufacture->save(); // Simpan manufaktur ke database

        // Kurangi jumlah bahan baku berdasarkan BoM
        foreach ($bom->bahan_digunakan as $bahan) {
            $bahanBaku = Material::find($bahan['id_bahan_baku']); // Cari bahan baku berdasarkan id

            if ($bahanBaku) {
                // Hitung total kebutuhan (jumlah_digunakan * jumlah produksi)
                $jumlahDigunakan = $bahan['jumlah_digunakan'] * $request->jumlah;

                // Kurangi jumlah_bahan pada tabel bahan_baku
                $bahanBaku->jumlah_bahan -= $jumlahDigunakan;

                // Pastikan tidak ada jumlah bahan negatif
                if ($bahanBaku->jumlah_bahan < 0) {
                    $bahanBaku->jumlah_bahan = 0;
                }

                // Simpan perubahan ke database
                $bahanBaku->save();
            }
        }

        return redirect()->route('Manufacture.index')->with('success', 'Manufaktur berhasil disimpan, dan stok bahan baku telah diperbarui.');
    }
}
