@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Purchase Orders</h5>
                    <small class="text-muted float-end">Data Pesanan Yang Selesai</small>
                </div>

                <div class="card-body">
                    <input type="text" class="form-control" placeholder="Cari....">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover" id="orderTable">
                        <thead>
                            <tr>
                                <th>Kode Pesanan</th>
                                <th>Penanggung Jawab</th>
                                <th>Vendor</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr data-id="{{ $order->id }}" onclick="openEditModal({{ $order->id }})"
                                    style="cursor:pointer;">
                                    <td>{{ $order->kode_pemesanan }}</td>
                                    <td>{{ $order->nama_pemesan }}</td>
                                    <td>{{ $order->vendor->nama ?? 'Tidak Diketahui' }}</td>
                                    <td>{{ $order->tanggal_pemesanan }}</td>
                                    <td>
                                        @if ($order->status == 'pesanan_diproses')
                                            <span class="badge bg-info">Pesanan Diproses</span>
                                        @elseif ($order->status == 'pesanan_selesai')
                                            <span class="badge bg-success">Pesanan Selesai</span>
                                        @else
                                            <span class="badge bg-secondary">Status Tidak Diketahui</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
