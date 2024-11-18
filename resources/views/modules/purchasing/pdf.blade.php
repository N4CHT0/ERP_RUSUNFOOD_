<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice RFQ - {{ $order->kode_pemesanan }}</title>
    <style>
        /* Import Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        /* Base styles */
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 850px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 32px;
            color: #444;
            margin: 0;
            text-transform: uppercase;
        }

        .header p {
            font-size: 16px;
            color: #666;
            margin: 5px 0;
        }

        .divider {
            border-bottom: 2px solid #eaeaea;
            margin: 20px 0;
        }

        .info-table,
        .item-table,
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
        }

        .info-table td {
            padding: 10px;
            vertical-align: top;
            color: #555;
        }

        .info-table strong {
            color: #333;
        }

        .item-table th,
        .item-table td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        .item-table th {
            background-color: #f8f8f8;
            font-size: 14px;
            text-transform: uppercase;
            color: #555;
        }

        .item-table td {
            background-color: #fff;
            color: #555;
        }

        .summary-table td {
            padding: 12px 15px;
            font-size: 14px;
            color: #333;
        }

        .summary-table .label {
            text-align: right;
            color: #666;
            font-weight: 500;
        }

        .summary-table .value {
            text-align: right;
            font-weight: 700;
            color: #333;
        }

        .summary-table tr:last-child td {
            font-size: 16px;
            font-weight: bold;
            background-color: #f8f8f8;
        }

        /* Footer styles */
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #999;
        }

        .badge {
            padding: 6px 12px;
            font-size: 12px;
            font-weight: bold;
            color: #fff;
            border-radius: 4px;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-info {
            background-color: #17a2b8;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Invoice</h1>
            <p>Kode RFQ: {{ $order->kode_pemesanan }}</p>
        </div>

        <!-- Divider -->
        <div class="divider"></div>

        <!-- Order Information -->
        <table class="info-table">
            <tr>
                <td>
                    <strong>Nama Pemesan:</strong> {{ $order->nama_pemesan }}<br>
                    <strong>Tanggal Pemesanan:</strong> {{ $order->tanggal_pemesanan }}
                </td>
                <td>
                    <strong>Vendor:</strong> {{ $order->vendor->nama }}<br>
                    <strong>Alamat:</strong> {{ $order->vendor->alamat }}<br>
                    <strong>Email:</strong> {{ $order->vendor->email }}<br>
                    <strong>No Telpon:</strong> {{ $order->vendor->no_telepon }}
                </td>
                <td>
                    <strong>Status:</strong>
                    <span class="badge {{ $order->status == 'pesanan_selesai' ? 'badge-success' : 'badge-info' }}">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </td>
            </tr>
        </table>

        <!-- Divider -->
        <div class="divider"></div>

        <!-- Items Table -->
        <table class="item-table">
            <thead>
                <tr>
                    <th>Bahan Baku</th>
                    <th>Harga Jual</th>
                    <th>Jumlah</th>
                    <th>Deskripsi</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach (json_decode($order->pemesanan_bahan, true) as $bahan)
                    <tr>
                        <td>{{ $bahan['nama_bahan'] ?? 'Nama bahan tidak tersedia' }}</td>
                        <td>Rp. {{ number_format($bahan['harga_jual'], 2, ',', '.') }}</td>
                        <td>{{ $bahan['jumlah'] }}</td>
                        <td>{{ $bahan['deskripsi'] }}</td>
                        <td>Rp. {{ number_format($bahan['subtotal'], 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary Table -->
        <table class="summary-table">
            <tr>
                <td class="label">Subtotal:</td>
                <td class="value">Rp. {{ number_format($order->total - $order->pajak, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Pajak (10%):</td>
                <td class="value">Rp. {{ number_format($order->pajak, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Total:</td>
                <td class="value">Rp. {{ number_format($order->total, 2, ',', '.') }}</td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Dokumen ini dibuat secara otomatis. Jika Anda memiliki pertanyaan, hubungi {{ $order->vendor->email }}.
            </p>
        </div>
    </div>
</body>

</html>
