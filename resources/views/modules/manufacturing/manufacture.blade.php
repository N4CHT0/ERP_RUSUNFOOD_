@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Daftar Manufaktur</h5>
                    <small class="text-muted float-end">Lakukan Proses Manufaktur</small>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#modalCenter">
                        <span class="tf-icons bx bx-add-to-queue"></span>&nbsp; Proses Manufaktur
                    </button>

                    <!-- Modal Proses Manufaktur -->
                    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
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
                    </div>

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
                            <table class="table table-hover" id="manufakturTable">
                                <thead>
                                    <tr>
                                        <th>Kode Manufaktur</th>
                                        <th>Produk</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $production)
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Hoverable Table rows -->
        </div>
    </div>

    <!-- Modal Detail Manufaktur -->
    <div class="modal fade" id="modalManufakturDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Manufaktur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Kode Manufaktur:</strong> <span id="detailKodeManufaktur"></span></p>
                    <p><strong>Produk:</strong> <span id="detailProduk"></span></p>
                    <p><strong>Jumlah:</strong> <span id="detailJumlah"></span></p>
                    <p><strong>Status:</strong> <span id="detailStatus"></span></p>

                    <!-- Tabel Bahan Baku -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Bahan Baku</th>
                                <th>To Consume</th>
                                <th>Reserved</th>
                                <th>Consumed</th>
                            </tr>
                        </thead>
                        <tbody id="detailBahanBakuTable">
                            <tr>
                                <td colspan="4" class="text-center">Data bahan baku belum tersedia</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnProduce"
                        style="display: none;">Produksi</button>
                    <button type="button" class="btn btn-success" id="btnDone" style="display: none;">Tandai Sudah
                        Selesai</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Event listener untuk klik baris tabel manufaktur
            $('.manufaktur-row').on('click', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '/manufacture/' + id,
                    method: 'GET',
                    success: function(response) {
                        $('#detailKodeManufaktur').text(response.manufacture.kode_manufaktur);
                        $('#detailProduk').text(response.manufacture.product.nama_produk);
                        $('#detailJumlah').text(response.manufacture.jumlah);
                        $('#detailStatus').text(response.manufacture.status);

                        // Tampilkan tabel bahan baku
                        var bahanBakuTable = '';
                        response.bahan_baku.forEach(function(bahan) {
                            var reserved = bahan.reserved;
                            var consumed = bahan.consumed;
                            var colorClass = reserved < consumed ? 'text-danger' :
                                'text-success'; // Tentukan warna

                            bahanBakuTable += `<tr>
                    <td>${bahan.nama_bahan}</td>
                    <td class="${colorClass}">${(bahan.to_consume).toFixed(2)}</td>
                    <td class="${colorClass}">${reserved.toFixed(2)}</td>
                    <td class="${colorClass}">${consumed.toFixed(2)}</td>
                </tr>`;
                        });
                        $('#detailBahanBakuTable').html(bahanBakuTable);

                        // Tampilkan atau sembunyikan tombol berdasarkan status
                        if (response.manufacture.status == 'draft') {
                            $('#btnProduce').show();
                            $('#btnDone').hide();
                        } else if (response.manufacture.status == 'produce') {
                            $('#btnProduce').hide();
                            $('#btnDone').show();
                        } else {
                            $('#btnProduce').hide();
                            $('#btnDone').hide();
                        }

                        $('#modalManufakturDetail').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });


            $('.manufaktur-row').on('click', function() {
                var id = $(this).data('id'); // Ambil ID manufaktur dari baris yang diklik
                $('#detailKodeManufaktur').data('id',
                    id); // Simpan ID ini dalam elemen modal atau elemen lainnya
            });


            // Event listener untuk tombol 'Produksi'
            $('#btnProduce').on('click', function() {
                var id = $('#detailKodeManufaktur').data(
                    'id'); // Pastikan ID yang dikirim adalah ID manufaktur yang valid

                $.ajax({
                    url: '/manufacture/produce/' + id, // Gunakan ID manufaktur
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        location.reload(); // Refresh halaman untuk memperbarui status
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });



            // Event listener untuk tombol 'Tandai Sudah Selesai'
            $('#btnDone').on('click', function() {
                var id = $('#detailKodeManufaktur').data('id'); // Ambil ID manufaktur dari modal

                $.ajax({
                    url: '/manufacture/done/' + id, // Endpoint untuk mengubah status menjadi 'done'
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        location.reload(); // Refresh halaman untuk memperbarui status
                    },
                    error: function(xhr, status, error) {
                        console.error(error); // Log error jika ada masalah
                    }
                });
            });


            // Inisialisasi Choices.js untuk elemen select
            var bomSelect = new Choices('#bomSelect', {
                searchEnabled: true,
                itemSelectText: '', // Hapus teks default ketika tidak ada pilihan
                placeholderValue: 'Pilih BoM'
            });

            var produkSelect = new Choices('#produkSelect', {
                searchEnabled: true,
                itemSelectText: '', // Hapus teks default ketika tidak ada pilihan
                placeholderValue: 'Pilih Produk'
            });

            // Event listener ketika BoM dipilih
            $('#bomSelect').on('change', function() {
                var bomId = $(this).val();
                if (bomId) {
                    updateTable(bomId);
                } else {
                    $('#bahanBakuTable').html(
                        '<tr><td colspan="4" class="text-center">Pilih BoM untuk melihat data</td></tr>'
                    );
                }
            });

            $('#modalCenter').on('show.bs.modal', function() {
                $('#quantity').val(1); // Set quantity ke 1 saat modal dibuka
            });

            // Event listener untuk quantity
            $('#quantity').on('input', function() {
                var bomId = $('#bomSelect').val();
                if (bomId) {
                    updateTable(bomId);
                }
            });
        });

        function updateTable(bomId) {
            var quantity = parseFloat($('#quantity').val()) || 1; // Ambil nilai quantity, set default ke 1 jika tidak ada

            $.ajax({
                url: '/get-bom-data/' + bomId,
                method: 'GET',
                success: function(response) {
                    var tableBody = '';
                    var hasRed = false; // Flag untuk mengecek apakah ada warna merah
                    var totalDibutuhkan = 0;
                    var totalStok = 0;
                    var totalTerkonsumsi = 0;

                    response.bahan_baku.forEach(function(bahan) {
                        var reserved = parseFloat(bahan.jumlah_bahan) || 0; // Reserved (stok tersedia)
                        var toConsumePerUnit = parseFloat(bahan.jumlah_digunakan) ||
                            0; // To consume per unit produksi
                        var toConsumeTotal = toConsumePerUnit *
                            quantity; // Hitung total to consume berdasarkan quantity
                        var consumed = toConsumeTotal; // Consumed sekarang adalah total to consume

                        // Tambahkan ke total dibutuhkan, stok, dan terkonsumsi
                        totalDibutuhkan += toConsumeTotal;
                        totalStok += reserved;
                        totalTerkonsumsi += consumed;

                        // Tentukan warna berdasarkan apakah stok cukup atau tidak
                        var diff = reserved - consumed;
                        var colorClass = diff < 0 ? 'text-danger' : 'text-success';

                        // Jika ada angka merah (kekurangan bahan baku), set flag hasRed ke true
                        if (diff < 0) {
                            hasRed = true;
                        }

                        tableBody += `
                    <tr>
                        <td>${bahan.nama_bahan}</td>
                        <td>${toConsumeTotal.toFixed(2)}</td>  <!-- To consume dipengaruhi oleh quantity -->
                        <td class="${colorClass}">${reserved.toFixed(2)}</td>
                        <td class="${colorClass}">${consumed.toFixed(2)}</td>
                    </tr>
                `;
                    });

                    $('#bahanBakuTable').html(tableBody);

                    // Perbarui nilai input tersembunyi
                    $('#inputDibutuhkan').val(totalDibutuhkan.toFixed(2));
                    $('#inputStok').val(totalStok.toFixed(2));
                    $('#inputTerkonsumsi').val(totalTerkonsumsi.toFixed(2));

                    // Tampilkan atau sembunyikan alert berdasarkan apakah ada bahan baku yang kurang
                    if (hasRed) {
                        $('#alertBahanBaku').removeClass('d-none'); // Tampilkan alert
                        $('#form-bom button[type="submit"]').prop('disabled',
                            true); // Nonaktifkan tombol submit
                    } else {
                        $('#alertBahanBaku').addClass('d-none'); // Sembunyikan alert
                        $('#form-bom button[type="submit"]').prop('disabled', false); // Aktifkan tombol submit
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>
@endsection
