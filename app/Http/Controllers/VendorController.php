<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Material;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();
        $materials = Material::all();

        // Mengisi nama bahan baku berdasarkan id dari JSON bahan_baku
        foreach ($vendors as $vendor) {
            $vendor->detailed_bahan_baku = collect($vendor->bahan_baku)->map(function ($item) {
                $material = Material::find($item['id']);
                return [
                    'id' => $item['id'],
                    'nama_bahan' => $material ? $material->nama_bahan : 'Unknown Material', // Default jika nama_bahan tidak ditemukan
                    'harga_jual' => $item['harga_jual'] ?? '0', // Default harga_jual jika null
                ];
            })->toArray(); // Pastikan ini menjadi array
        }


        return view('modules.purchasing.vendor.index', compact('vendors', 'materials'));
    }






    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string',
            'email' => 'required|email',
            'bahan_baku' => 'nullable|array',
            'harga_jual' => 'nullable|array',
        ]);

        // Kombinasikan ID bahan baku dengan harga jual menjadi satu array JSON
        $bahanBakuData = [];
        if ($request->has('bahan_baku') && $request->has('harga_jual')) {
            foreach ($request->bahan_baku as $index => $bahanBakuId) {
                $bahanBakuData[] = [
                    'id' => $bahanBakuId,
                    'harga_jual' => $request->harga_jual[$index] ?? null,
                ];
            }
        }

        // Simpan data vendor dengan kolom bahan_baku yang berisi array JSON
        Vendor::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'foto' => $request->foto,
            'bahan_baku' => $bahanBakuData,
        ]);

        return redirect()->route('Vendor.index')->with('success', 'Vendor berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string',
            'email' => 'required|email',
        ]);

        // Parsing bahan_baku_data dari JSON
        $bahanBakuData = json_decode($request->bahan_baku_data, true);

        $vendor->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'bahan_baku' => $bahanBakuData,
        ]);

        return redirect()->route('Vendor.index')->with('success', 'Vendor berhasil diperbarui');
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return redirect()->route('Vendor.index')->with('success', 'Vendor berhasil dihapus');
    }
}
