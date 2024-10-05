@extends('layouts.main')
@section('title')
    Buat Data Bahan Baku |
@endsection
@section('content')
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Bahan Baku</h5>
                    <small class="text-muted float-end">Buat Data Bahan Baku</small>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('Material.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="kode_bahan_baku">Kode Bahan Baku</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="kode_bahan_baku" class="input-group-text"><i class="bx bx-receipt"></i></span>
                                    <input type="text" class="form-control" id="kode_bahan_baku"
                                        placeholder="Kode Bahan Baku" name="kode_bahan_baku" />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nama_bahan">Nama Bahan Baku</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="nama_bahan" class="input-group-text"><i class="bx bx-box"></i></span>
                                    <input type="text" id="nama_bahan" class="form-control" placeholder="Nama Bahan Baku"
                                        name="nama_bahan" />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="jumlah_bahan">Jumlah Bahan</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="number" id="jumlah_bahan" class="form-control"
                                        placeholder="Jumlah Bahan Baku" name="jumlah_bahan" />
                                    <select class="form-select" name="satuan_bahan" id="satuan_bahan">
                                        <Option value="">Pilih Satuan Bahan</Option>
                                        <option value="kg">Kg</option>
                                        <option value="ton">Ton</option>
                                        <option value="g">Gram</option>
                                        <option value="ons">Ons</option>
                                        <option value="liter">Liter</option>
                                        <option value="ml">Ml</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="harga_bahan">Harga Bahan Baku</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="number" id="harga_bahan" class="form-control"
                                        placeholder="Harga Bahan Baku" name="harga_bahan" />
                                    <select class="form-select" name="mata_uang" id="mata_uang">
                                        <Option value="">Pilih Satuan Mata Uang</Option>
                                        <option value="Rp.">Rp.</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
