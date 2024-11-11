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
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 850px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            color: #4a4a4a;
            margin: 0;
            padding-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            color: #888;
            margin: 0;
        }

        /* Info and tables */
        .info-table,
        .item-table,
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }

        .info-table td,
        .item-table th,
        .item-table td,
        .summary-table td {
            padding: 12px 15px;
        }

        .info-table td {
            color: #555;
            vertical-align: top;
        }

        .section-title {
            font-size: 16px;
            font-weight: 500;
            color: #333;
            padding: 10px 0;
            margin-top: 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        /* Item table styles */
        .item-table th {
            background-color: #f3f3f3;
            color: #555;
            font-weight: 500;
            border-bottom: 2px solid #e0e0e0;
            text-align: left;
        }

        .item-table td {
            border-bottom: 1px solid #f0f0f0;
            color: #555;
        }

        .item-table tr:last-child td {
            border-bottom: none;
        }

        .item-table {
            margin-top: 10px;
            border-radius: 6px;
            overflow: hidden;
        }

        /* Summary table styles */
        .summary-table td {
            padding: 12px 15px;
            font-size: 14px;
            color: #333;
        }

        .summary-table .label {
            text-align: right;
            color: #666;
        }

        .summary-table .value {
            font-weight: 700;
            color: #333;
        }

        .summary-table tr:nth-child(2) td {
            background-color: #f9f9f9;
        }

        .summary-table tr:last-child td {
            background-color: #f3f3f3;
            font-size: 16px;
            color: #333;
        }

        /* Additional styling for badges */
        .badge {
            display: inline-block;
            padding: 5px 10px;
            font-size: 12px;
            color: #fff;
            border-radius: 5px;
            font-weight: 500;
        }

        .badge-info {
            background-color: #5bc0de;
        }

        .badge-success {
            background-color: #5cb85c;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <h1>Invoice RFQ</h1>
            <p>Kode RFQ: {{ $order->kode_pemesanan }}</p>
        </div>

        <!-- Order Information -->
        <div class="section-title">Informasi Pesanan</div>
        <table class="info-table">
            <tr>
                <td style="width: 50%;"><strong>Nama Pemesan:</strong> {{ $order->nama_pemesan }}</td>
                <td><strong>Vendor:</strong> {{ $order->vendor->nama }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Pemesanan:</strong> {{ $order->tanggal_pemesanan }}</td>
                <td>
                    <strong>Status:</strong>
                    <span class="badge {{ $order->status == 'pesanan_selesai' ? 'badge-success' : 'badge-info' }}">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <strong>Alamat:</strong> {{ $order->vendor->alamat }}<br>
                    <strong>Email:</strong> {{ $order->vendor->email }}<br>
                    <strong>No Telpon:</strong> {{ $order->vendor->no_telepon }}
                </td>
            </tr>
        </table>

        <!-- Order Items Table -->
        <div class="section-title">Detail Bahan Baku</div>
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
                        <td>{{ $bahan['nama_bahan'] }}</td>
                        <td>Rp. {{ number_format($bahan['harga_jual'], 2, ',', '.') }}</td>
                        <td>{{ $bahan['jumlah'] }}</td>
                        <td>{{ $bahan['deskripsi'] }}</td>
                        <td>Rp. {{ number_format($bahan['subtotal'], 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary Table -->
        <div class="section-title">Ringkasan Pembayaran</div>
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
                <td class="label"><strong>Total:</strong></td>
                <td class="value"><strong>Rp. {{ number_format($order->total, 2, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>
</body>

</html>
