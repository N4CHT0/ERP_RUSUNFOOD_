@extends('layouts.main')
@section('content')
    <form method="POST" action="{{ route('Product.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Produksi</h5>
                        <small class="text-muted float-end">Bill Of Material</small>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="kode_produk">Kode Produksi</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="kode_produk" class="input-group-text"><i class="bx bx-receipt"></i></span>
                                    <input type="text" class="form-control" id="kode_produk" placeholder="Kode Produk"
                                        name="kode_produk" />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nama_produk">Nama Produk</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="nama_produk" class="input-group-text"><i class="bx bx-box"></i></span>
                                    <input type="text" id="nama_produk" class="form-control" placeholder="Nama Produk"
                                        name="nama_produk" />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="jumlah_produk">Jumlah Produk</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="number" id="jumlah_produk" class="form-control"
                                        placeholder="Jumlah Produk" name="jumlah_produk" />
                                </div>
                            </div>
                        </div>

                        <!-- Bahan Baku Section -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="id_bahan_baku">Bahan Baku</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="id_bahan_baku" class="input-group-text"><i class="bx bx-box"></i></span>
                                    <select class="form-select" id="bahan_baku_select">
                                        <Option value="">Pilih Bahan Baku</Option>
                                        @foreach ($material as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_bahan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Badge Container -->
                                <div id="selected_bahan_baku" class="mt-2"></div>

                                <!-- Hidden input for storing selected values -->
                                <input type="hidden" name="bahan_baku" id="bahan_baku_hidden">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="harga_produk">Harga Produk</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="number" id="harga_produk" class="form-control" placeholder="Harga Produk"
                                        name="harga_produk" />
                                    <select class="form-select" name="mata_uang" id="mata_uang">
                                        <Option value="">Pilih Mata Uang</Option>
                                        <Option value="Rp.">Rp.</Option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Produk</h5>
                        <small class="text-muted float-end">Foto Produk</small>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nama_produk">Foto Produk</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="foto_produk" class="input-group-text"><i class="bx bx-box"></i></span>
                                    <input type="file" id="foto_produk" class="form-control" placeholder="Nama Produk"
                                        name="foto_produk" />
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection