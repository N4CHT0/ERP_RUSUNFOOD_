<!DOCTYPE html>
<html>

<head>
    <title>Bill of Material Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        tfoot tr td {
            font-weight: bold;
        }

        .right-align {
            text-align: right;
        }

        .center-align {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>BoM Structure & Cost - {{ $production->product->nama_produk }}</h2>
    <p><strong>Kode Produksi:</strong> {{ $production->kode_produksi }}</p>
    <p><strong>Tanggal Produksi:</strong> {{ $production->tanggal_produksi }}</p>
    <p><strong>Jumlah Produksi:</strong> {{ $production->jumlah_produksi }}</p>

    <h3>Detail Bahan Baku dan Produk</h3>
    <table>
        <thead>
            <tr>
                <th>Product / Bahan</th>
                <th class="center-align">Quantity</th>
                <th class="right-align">Product Cost (Rp)</th>
                <th class="right-align">BoM Cost (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <!-- Baris untuk Produk -->
            <tr>
                <td>{{ $production->product->nama_produk }}</td>
                <td class="center-align">{{ $production->jumlah_produksi }}</td>
                <td class="right-align">{{ number_format($production->product->harga_produk, 2, ',', '.') }}</td>
                <td class="right-align"></td> <!-- Kosong karena ini adalah harga BOM untuk bahan baku -->
            </tr>

            <!-- Baris untuk Bahan Baku -->
            @php $totalHargaBOM = 0; @endphp
            @foreach ($bahan_digunakan as $bahan)
                <tr>
                    <td>{{ $bahan['nama_bahan'] }}</td>
                    <td class="center-align">{{ $bahan['jumlah_digunakan'] }}</td>
                    <td class="right-align">{{ number_format($bahan['harga_bahan'], 2, ',', '.') }}</td>
                    <td class="right-align">{{ number_format($bahan['harga_bom'], 2, ',', '.') }}</td>
                </tr>
                @php $totalHargaBOM += $bahan['harga_bom']; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <!-- Baris Total untuk Harga BOM -->
            <tr>
                <td colspan="3" class="right-align">Unit Cost</td>
                <td class="right-align">{{ number_format($totalHargaBOM, 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
