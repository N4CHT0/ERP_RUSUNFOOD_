<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Order;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $vendors = Vendor::all();

        return view('modules.purchasing.index', compact('orders', 'vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_vendor' => 'required|exists:vendor,id',
            'kode_pemesanan' => 'required|string',
            'nama_pemesan' => 'required|string',
            'tanggal_pemesanan' => 'required|date',
            'pemesanan_bahan' => 'required|array',
            'pemesanan_bahan.*.id_bahan_baku' => 'required|exists:bahan_baku,id',
            'pemesanan_bahan.*.harga_jual' => 'required|numeric',
            'pemesanan_bahan.*.jumlah' => 'required|numeric',
            'pemesanan_bahan.*.deskripsi' => 'nullable|string',
        ]);

        // Inisialisasi variabel untuk menyimpan data pemesanan bahan
        $pemesananBahan = [];
        $subtotal = 0;

        // Loop melalui setiap item bahan yang dipesan untuk menghitung subtotal dan total
        foreach ($request->pemesanan_bahan as $bahan) {
            // Ambil harga jual dan jumlah dari item bahan
            $hargaJual = $bahan['harga_jual'];
            $jumlah = $bahan['jumlah'];

            // Hitung subtotal untuk item bahan ini
            $bahanSubtotal = $hargaJual * $jumlah;
            $subtotal += $bahanSubtotal;

            // Tambahkan data bahan ini ke array pemesananBahan
            $pemesananBahan[] = [
                'id_bahan_baku' => $bahan['id_bahan_baku'],
                'nama_bahan' => $bahan['nama_bahan'] ?? '',
                'harga_jual' => $hargaJual,
                'jumlah' => $jumlah,
                'deskripsi' => $bahan['deskripsi'] ?? '',
                'subtotal' => $bahanSubtotal,
            ];
        }

        // Hitung pajak dan total keseluruhan
        $pajak = $subtotal * 0.1; // Pajak 10%
        $total = $subtotal + $pajak;

        // Simpan data pesanan baru ke dalam database
        $order = Order::create([
            'id_vendor' => $request->id_vendor,
            'kode_pemesanan' => $request->kode_pemesanan,
            'nama_pemesan' => $request->nama_pemesan,
            'tanggal_pemesanan' => $request->tanggal_pemesanan,
            'pemesanan_bahan' => json_encode($pemesananBahan), // Simpan data bahan sebagai JSON
            'pajak' => $pajak,
            'total' => $total,
            'status' => 'pesanan_diproses',
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('orders.index')->with('success', 'RFQ berhasil dibuat.');
    }



    public function show($id)
    {
        try {
            $order = Order::findOrFail($id);
            $pemesananBahan = json_decode($order->pemesanan_bahan, true);

            // Loop melalui setiap bahan untuk memastikan 'nama_bahan' ada
            foreach ($pemesananBahan as &$bahan) {
                if (empty($bahan['nama_bahan'])) {
                    $material = Material::find($bahan['id_bahan_baku']);
                    $bahan['nama_bahan'] = $material ? $material->nama_bahan : 'Tidak Diketahui';
                }
            }

            // Menyimpan pemesanan_bahan yang telah diperbarui ke dalam variabel order
            $order->pemesanan_bahan = $pemesananBahan;

            return response()->json($order);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Order not found or data structure error'], 500);
        }
    }



    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'id_vendor' => 'required|exists:vendor,id',
            'kode_pemesanan' => 'required|string',
            'nama_pemesan' => 'required|string',
            'tanggal_pemesanan' => 'required|date',
            'pemesanan_bahan' => 'required|array',
        ]);

        $pemesananBahan = [];
        $subtotal = 0;

        foreach ($request->pemesanan_bahan as $bahan) {
            $bahanSubtotal = $bahan['harga_jual'] * $bahan['jumlah'];
            $subtotal += $bahanSubtotal;
            $pemesananBahan[] = [
                'id_bahan_baku' => $bahan['id_bahan_baku'],
                'nama_bahan' => $bahan['nama_bahan'],
                'harga_jual' => $bahan['harga_jual'],
                'jumlah' => $bahan['jumlah'],
                'deskripsi' => $bahan['deskripsi'],
                'subtotal' => $bahanSubtotal,
            ];
        }

        $pajak = $subtotal * 0.1; // Pajak 10%
        $total = $subtotal + $pajak;

        $order->update([
            'id_vendor' => $request->id_vendor,
            'kode_pemesanan' => $request->kode_pemesanan,
            'nama_pemesan' => $request->nama_pemesan,
            'tanggal_pemesanan' => $request->tanggal_pemesanan,
            'pemesanan_bahan' => json_encode($pemesananBahan),
            'pajak' => $pajak,
            'total' => $total,
        ]);

        return response()->json(['status' => 'success', 'message' => 'RFQ berhasil diperbarui.']);
    }


    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Pesanan tidak ditemukan.'], 404);
        }

        $order->delete();

        return response()->json(['status' => 'success', 'message' => 'Pesanan berhasil dihapus.']);
    }


    public function generatePDF($id)
    {
        $order = Order::findOrFail($id);
        $pemesananBahan = json_decode($order->pemesanan_bahan, true);

        // Loop melalui setiap bahan untuk memastikan 'nama_bahan' diambil dari database jika tidak ada
        foreach ($pemesananBahan as &$bahan) {
            if (empty($bahan['nama_bahan'])) {
                $material = Material::find($bahan['id_bahan_baku']);
                $bahan['nama_bahan'] = $material ? $material->nama_bahan : 'Tidak Diketahui';
            }
        }

        // Hitung subtotal dan total
        $subtotal = array_reduce($pemesananBahan, function ($carry, $bahan) {
            return $carry + $bahan['subtotal'];
        }, 0);

        $pajak = $subtotal * 0.1;
        $total = $subtotal + $pajak;

        // Update data bahan ke dalam order dan tampilkan di view PDF
        $pdf = PDF::loadView('modules.purchasing.pdf', compact('order', 'pemesananBahan', 'subtotal', 'pajak', 'total'));
        $fileName = 'RFQ_' . $order->kode_pemesanan . '.pdf';
        Storage::put("pdf/{$fileName}", $pdf->output());

        $order->update(['dokumen' => $fileName]);

        return $pdf->download($fileName);
    }



    public function getBahanBaku($vendorId)
    {
        $vendor = Vendor::findOrFail($vendorId);
        return response()->json($vendor->detailed_bahan_baku);
    }

    public function acceptOrder($id)
    {
        $order = Order::findOrFail($id);

        $order->status = 'pesanan_selesai';
        $order->save();

        $pemesananBahan = json_decode($order->pemesanan_bahan, true); // Pastikan pemesanan_bahan terdecode

        foreach ($pemesananBahan as $bahan) {
            $material = Material::find($bahan['id_bahan_baku']);
            if ($material) {
                $material->jumlah_bahan += $bahan['jumlah'];
                $material->save();
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Pesanan diterima dan stok bahan diperbarui.']);
    }

    public function processCekBahan(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $pemesananBahan = json_decode($order->pemesanan_bahan, true);

        foreach ($pemesananBahan as &$bahan) {
            $bahanDiterima = $request->input("bahan_diterima.{$bahan['id_bahan_baku']}");

            if ($bahanDiterima < $bahan['jumlah']) {
                $difference = $bahan['jumlah'] - $bahanDiterima;
                $bahan['jumlah'] = $bahanDiterima;

                // Update jumlah di tabel bahan_baku
                $material = Material::find($bahan['id_bahan_baku']);
                if ($material) {
                    $material->jumlah_bahan -= $difference;
                    $material->save();
                }
            }
        }

        // Update pemesanan_bahan dan ubah status menjadi `menunggu_pembayaran`
        $order->update([
            'pemesanan_bahan' => json_encode($pemesananBahan),
            'status' => 'menunggu_pembayaran'
        ]);

        return redirect()->route('orders.index')->with('success', 'Cek Bahan berhasil diproses dan status diperbarui menjadi menunggu pembayaran.');
    }
}
