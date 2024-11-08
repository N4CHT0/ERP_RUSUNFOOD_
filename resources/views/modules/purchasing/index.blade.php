@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">RFQ ( Request For Quotation ) </h5>
                    <small class="text-muted float-end">Data RFQ</small>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#modalCenter">
                        <span class="tf-icons bx bx-add-to-queue"></span>&nbsp; Lakukan RFQ
                    </button>

                    <!-- Modal Proses Manufaktur -->
                    {{-- <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalCenterTitle">Proses Manufaktur</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="form-bom" action="{{ route('Manufacture.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">

                                        <!-- Input tersembunyi untuk menyimpan hasil perhitungan dari JavaScript -->
                                        <input type="hidden" name="dibutuhkan" id="inputDibutuhkan">
                                        <input type="hidden" name="stok" id="inputStok">
                                        <input type="hidden" name="terkonsumsi" id="inputTerkonsumsi">

                                        <!-- Menampilkan error dari session jika ada -->
                                        @if (session('error'))
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif

                                        <!-- Alert jika ada bahan baku yang kurang -->
                                        <div id="alertBahanBaku" class="alert alert-danger alert-dismissible d-none"
                                            role="alert">
                                            Harap mengecek ketersediaan bahan baku pada bahan yang memiliki nilai berwarna
                                            merah.
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="produk" class="form-label">Produk</label>
                                                <select class="form-select" name="produk" id="produkSelect">
                                                    <option value="">Pilih Produk</option>
                                                    @foreach ($products as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nama_produk }}
                                                        </option>
                                                    @endforeach
                                                    <option value="create">Buat Produk Baru</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col mb-3">
                                                <label for="kode_manufaktur" class="form-label">Kode Manufaktur</label>
                                                <input type="text" name="kode_manufaktur" class="form-control"
                                                    placeholder="Kode Manufaktur" required />
                                            </div>
                                            <div class="col mb-3">
                                                <label for="jumlah" class="form-label">Jumlah</label>
                                                <input type="number" name="jumlah" id="quantity" class="form-control"
                                                    placeholder="Jumlah" required value="1" min="1" />
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col mb-3">
                                                <label for="rencana_produksi" class="form-label">Rencana Produksi</label>
                                                <input type="date" name="rencana_produksi" class="form-control"
                                                    required />
                                            </div>
                                            <div class="col mb-3">
                                                <label for="batas_produksi" class="form-label">Batas Produksi</label>
                                                <input type="date" name="batas_produksi" class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col mb-3">
                                                <label for="perusahaan" class="form-label">Perusahaan</label>
                                                <input type="text" name="perusahaan" class="form-control"
                                                    placeholder="Perusahaan" required />
                                            </div>
                                        </div>
                                        <!-- Select BoM -->
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="bom" class="form-label">Bill Of Material (BoM)</label>
                                                <select class="form-select" name="bom" id="bomSelect">
                                                    <option value="">Pilih BoM</option>
                                                    @foreach ($boms as $item)
                                                        <option value="{{ $item->id }}">{{ $item->kode_produksi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Tabel untuk menampilkan Bahan Baku -->
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Bahan Baku</th>
                                                    <th>To Consume</th>
                                                    <th>Reserved</th>
                                                    <th>Consumed</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0" id="bahanBakuTable">
                                                <tr>
                                                    <td colspan="4" class="text-center">Pilih BoM untuk melihat data
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Tutup
                                        </button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl">
            <!-- Hoverable Table rows -->
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <div class="card">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover" id="">
                                <thead>
                                    <tr>
                                        <th>Kode RFQ</th>
                                        <th>Deskripsi</th>
                                        <th>Pemesan</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($data as $production)
                                        <tr data-id="{{ $production->id }}" class="manufaktur-row">
                                            <td>{{ $production->kode_manufaktur }}</td>
                                            <td>{{ $production->product->nama_produk ?? 'Tidak diketahui' }}</td>
                                            <td>{{ $production->jumlah }}</td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill {{ $production->status == 'draft' ? 'bg-warning' : ($production->status == 'produce' ? 'bg-primary' : 'bg-success') }}">
                                                    {{ ucfirst($production->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Hoverable Table rows -->
        </div>
    </div>
@endsection
