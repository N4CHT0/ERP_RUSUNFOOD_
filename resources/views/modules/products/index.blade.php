@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"></h5>
                    <small class="text-muted float-end">Daftar Produk</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($data as $produk)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 position-relative">
                                    <!-- Gambar Produk -->
                                    <img src="{{ asset('storage/img/' . $produk->foto_produk) }}" class="card-img-top"
                                        alt="{{ $produk->nama_produk }}" style="max-height: 200px; object-fit: cover;">

                                    <!-- Ikon Aksi Dropdown -->
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded bx-md"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                                        <p class="card-text">Harga Satuan: {{ $produk->mata_uang }}
                                            {{ number_format($produk->harga_produk, 0, ',', '.') }}</p>
                                        <p class="card-text">Jumlah: {{ $produk->jumlah_produk }}</p>
                                        <p class="card-text">
                                            <strong>Bahan Baku:</strong>
                                            @php
                                                $bahan_baku = App\Models\Material::whereIn(
                                                    'id',
                                                    explode(',', $produk->id_bahan_baku),
                                                )
                                                    ->pluck('nama_bahan')
                                                    ->toArray();
                                                echo implode(', ', $bahan_baku);
                                            @endphp
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // Fungsi untuk toggle popup saat klik ikon aksi
        document.querySelectorAll('.action-icon').forEach(icon => {
            icon.addEventListener('click', function(e) {
                e.preventDefault();
                const popup = this.nextElementSibling; // Mengambil elemen popup berikutnya
                popup.classList.toggle('d-none'); // Menampilkan/menghilangkan popup

                // Menutup popup lainnya
                document.querySelectorAll('.action-popup').forEach(otherPopup => {
                    if (otherPopup !== popup) {
                        otherPopup.classList.add('d-none');
                    }
                });
            });
        });

        // Menutup popup jika mengklik di luar ikon atau popup
        window.addEventListener('click', function(e) {
            if (!e.target.closest('.action-icon') && !e.target.closest('.action-popup')) {
                document.querySelectorAll('.action-popup').forEach(popup => {
                    popup.classList.add('d-none'); // Menyembunyikan semua popup
                });
            }
        });
    </script>
@endsection
