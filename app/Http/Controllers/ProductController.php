<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index()
    {
        $data = Product::with('material')->paginate(100);

        return view('modules.products.index', [
            'data' => $data,
        ]);
    }

    public function create()
    {
        $material = Material::all();
        return view('modules.products.create', compact('material'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|string|max:255',
            'nama_produk' => 'required|string|max:255',
            'jumlah_produk' => 'required|numeric',
            'harga_produk' => 'required|numeric',
            'mata_uang' => 'required|string',
            'bahan_baku' => 'required|string',
            'foto_produk' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
        ]);

        $data = [
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'jumlah_produk' => $request->jumlah_produk,
            'harga_produk' => $request->harga_produk,
            'mata_uang' => $request->mata_uang,
            'id_bahan_baku' => $request->bahan_baku,
        ];

        // Upload image jika tersedia
        $this->processImageUpload($request, 'foto_produk', $data);

        Product::create($data);

        return redirect()->route('Home')->with('success', 'Data berhasil disimpan');
    }

    // Fungsi Untuk Upload Gambar Ke Sistem

    private function processImageUpload($request, $fieldName, &$data, $model = null)
    {
        if ($request->hasFile($fieldName)) {
            $image = $request->file($fieldName);
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/img', $imageName);

            if ($model && $model->$fieldName) {
                Storage::delete('public/img/' . $model->$fieldName);
            }

            $data[$fieldName] = $imageName;
        } elseif ($model && $model->$fieldName) {
            $data[$fieldName] = $model->$fieldName;
        }
    }

    // Fungsi Untuk Hapus Gambar dari Sistem

    private function deleteRelatedFiles($data)
    {
        $fileFields = ['foto_ktp', 'foto_kk'];

        foreach ($fileFields as $fieldName) {
            if ($data->$fieldName) {
                Storage::delete('public/img/' . basename($data->$fieldName));
            }
        }
    }
}
