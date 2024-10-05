<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function create()
    {
        return view('modules.manufacturing.material.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_bahan_baku' => 'required|string|max:255',
            'nama_bahan' => 'required|string|max:255',
            'jumlah_bahan' => 'required|numeric',
            'satuan_bahan' => 'required|string',
            'harga_bahan' => 'required|numeric',
            'mata_uang' => 'required|string',
        ]);

        Material::create([
            'kode_bahan_baku' => $request->kode_bahan_baku,
            'nama_bahan' => $request->nama_bahan,
            'jumlah_bahan' => $request->jumlah_bahan,
            'satuan_bahan' => $request->satuan_bahan,
            'harga_bahan' => $request->harga_bahan,
            'mata_uang' => $request->mata_uang,
        ]);

        return redirect()->route('Home')->with('success', 'Data berhasil disimpan');
    }
}
