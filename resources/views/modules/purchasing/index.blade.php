@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">RFQ (Request For Quotation)</h5>
                    <small class="text-muted float-end">Data RFQ</small>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalRFQ">
                        <span class="tf-icons bx bx-add-to-queue"></span>&nbsp; Lakukan RFQ
                    </button>

                    <!-- Modal untuk Menambahkan RFQ -->
                    <div class="modal fade" id="modalRFQ" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah RFQ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form id="form-rfq" action="{{ route('orders.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="id_vendor" class="form-label">Pilih Vendor</label>
                                            <select class="form-select w-100" id="id_vendor" name="id_vendor" required>
                                                <option value="">Pilih Vendor</option>
                                                @foreach ($vendors as $vendor)
                                                    <option value="{{ $vendor->id }}">{{ $vendor->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Bahan Baku</th>
                                                        <th>Harga Jual</th>
                                                        <th>Jumlah</th>
                                                        <th>Deskripsi</th>
                                                        <th>Subtotal</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="pemesananBahanTable">
                                                    <tr id="placeholderRow">
                                                        <td colspan="6" class="text-center">Pilih Vendor untuk menambah
                                                            baris</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal_pemesanan" class="form-label">Tanggal Pemesanan</label>
                                            <input type="date" name="tanggal_pemesanan" class="form-control w-100"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="kode_pemesanan" class="form-label">Kode Pemesanan</label>
                                            <input type="text" name="kode_pemesanan" class="form-control w-100" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama_pemesan" class="form-label">Nama Pemesanan</label>
                                            <input type="text" name="nama_pemesan" class="form-control w-100" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit yang Lebih Kompleks -->
                    <div class="modal fade" id="modalEditRFQ" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Pesanan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form id="form-edit-rfq" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <!-- Konten modal edit yang sama dengan modal tambah -->
                                        <div class="mb-3">
                                            <label for="edit_id_vendor" class="form-label">Pilih Vendor</label>
                                            <select class="form-select w-100" id="edit_id_vendor" name="id_vendor" required>
                                                <option value="">Pilih Vendor</option>
                                                @foreach ($vendors as $vendor)
                                                    <option value="{{ $vendor->id }}">{{ $vendor->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_tanggal_pemesanan" class="form-label">Tanggal
                                                Pemesanan</label>
                                            <input type="date" name="tanggal_pemesanan" class="form-control w-100"
                                                id="edit_tanggal_pemesanan" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_kode_pemesanan" class="form-label">Kode Pemesanan</label>
                                            <input type="text" name="kode_pemesanan" class="form-control w-100"
                                                id="edit_kode_pemesanan" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_nama_pemesan" class="form-label">Nama Pemesanan</label>
                                            <input type="text" name="nama_pemesan" class="form-control w-100"
                                                id="edit_nama_pemesan" required>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Bahan Baku</th>
                                                        <th>Harga Jual</th>
                                                        <th>Jumlah</th>
                                                        <th>Deskripsi</th>
                                                        <th>Subtotal</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="editPemesananBahanTable">
                                                    <tr id="editPlaceholderRow">
                                                        <td colspan="6" class="text-center">Pilih Vendor untuk menambah
                                                            baris</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <br>

                                        <div class="d-flex flex-column align-items-end mt-2 ms-auto"
                                            style="width: 100%; max-width: 300px;">
                                            <div class="d-flex justify-content-between w-100">
                                                <span class="text-muted" style="font-size: 1rem;">Subtotal:</span>
                                                <div>
                                                    <strong class="text-muted" style="font-size: 1rem;">Rp. </strong>
                                                    <strong id="subtotalAmount" style="font-size: 1rem;">0.00</strong>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between w-100 mt-1">
                                                <span class="text-muted" style="font-size: 1rem;">Pajak:</span>
                                                <div>
                                                    <strong class="text-muted" style="font-size: 1rem;">Rp. </strong>
                                                    <strong id="pajakAmount" style="font-size: 1rem;">0.00</strong>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between w-100 mt-2">
                                                <span class="fw-bold" style="font-size: 1.25rem;">Total:</span>
                                                <div>
                                                    <strong class="fw-bold text-dark" style="font-size: 1.25rem;">Rp.
                                                    </strong>
                                                    <strong id="totalAmount" style="font-size: 1.25rem;">0.00</strong>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-success" id="paymentButton"
                                            onclick="openPaymentModalFromEdit()" style="display: none;">Proses
                                            Pembayaran</button>
                                        <!-- Button Cek Bahan -->
                                        <button type="button" class="btn btn-warning" id="cekBahanButton"
                                            onclick="openCekBahanModal()" style="display: none;">Cek Bahan</button>
                                        <button type="button" class="btn btn-danger"
                                            onclick="deleteOrder()">Hapus</button>
                                        <button type="button" class="btn btn-success" id="acceptOrderButton"
                                            onclick="acceptOrder()">Terima Pesanan</button>
                                        <a id="pdfDownloadButton" href="#" class="btn btn-secondary"
                                            target="_blank">Cetak</a>
                                        <button type="submit" class="btn btn-primary edit">Perbarui</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Cek Bahan -->
                    <div class="modal fade" id="modalCekBahan" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cek Bahan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form id="form-cek-bahan" method="POST">
                                    @csrf
                                    <div class="modal-body" id="cekBahanContainer">
                                        <!-- Input bahan_diterima akan ditambahkan melalui JavaScript -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary cek">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalPayment" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Proses Pembayaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form id="form-payment" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-select"
                                                required>
                                                <option value="">Pilih Metode</option>
                                                <option value="Tunai">Tunai</option>
                                                <option value="Bank">Bank</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
                                            <input type="date" name="tanggal_pembayaran" id="tanggal_pembayaran"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary tagihan">Proses</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Table for existing RFQs -->
    <div class="row">
        <div class="col-xxl">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover" id="orderTable">
                        <thead>
                            <tr>
                                <th>Kode RFQ</th>
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
                                            <span class="badge bg-warning">Pesanan Selesai</span>
                                        @elseif ($order->status == 'tagihan_dibuat')
                                            <span class="badge bg-success">Tagihan Dibuat</span>
                                        @elseif ($order->status == 'menunggu_pembayaran')
                                            <span class="badge bg-danger">Menunggu Pembayaran</span>
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

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let selectedMaterialsTambah = new Set();
        let selectedMaterialsEdit = new Set();
        let currentAvailableMaterials = [];

        // Fungsi untuk memuat bahan baku berdasarkan vendor yang dipilih
        $('#id_vendor, #edit_id_vendor').on('change', function() {
            const vendorId = $(this).val();
            const tableId = this.id === 'id_vendor' ? 'pemesananBahanTable' : 'editPemesananBahanTable';
            const selectedMaterials = this.id === 'id_vendor' ? selectedMaterialsTambah : selectedMaterialsEdit;

            $('#' + tableId).empty();
            selectedMaterials.clear();

            if (vendorId) {
                $.get(`/vendor/${vendorId}/bahan-baku`, function(data) {
                    currentAvailableMaterials = data;
                    if (data.length > 0) {
                        if (tableId === 'pemesananBahanTable') {
                            addBahanBakuRowTambah(tableId);
                        } else {
                            loadEditRows(data);
                        }
                    }
                });
            }
        });

        // Fungsi untuk menambahkan row bahan baku di modal tambah, berhenti jika semua bahan baku sudah dipilih
        function addBahanBakuRowTambah(tableId) {
            if (selectedMaterialsTambah.size >= currentAvailableMaterials.length) {
                return; // Hentikan jika semua bahan baku sudah dipilih
            }

            const tableBody = document.getElementById(tableId);
            const rowCount = tableBody.querySelectorAll('tr').length;
            let bahanOptions = '<option value="">Pilih Bahan Baku</option>';

            currentAvailableMaterials.forEach(material => {
                if (!selectedMaterialsTambah.has(material.id)) {
                    bahanOptions +=
                        `<option value="${material.id}" data-harga="${material.harga_jual}">${material.nama_bahan}</option>`;
                }
            });

            const newRow = `
        <tr>
            <td>
                <select class="form-select w-100 bahan-baku-select" name="pemesanan_bahan[${rowCount}][id_bahan_baku]" required>
                    ${bahanOptions}
                </select>
            </td>
            <td><input type="number" name="pemesanan_bahan[${rowCount}][harga_jual]" class="form-control w-100" readonly></td>
            <td><input type="number" name="pemesanan_bahan[${rowCount}][jumlah]" class="form-control w-100" required oninput="updateSubtotalTambah(this)"></td>
            <td><input type="text" name="pemesanan_bahan[${rowCount}][deskripsi]" class="form-control w-100"></td>
            <td class="subtotal">0</td>
            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRowTambah(this)">Hapus</button></td>
        </tr>`;

            tableBody.insertAdjacentHTML('beforeend', newRow);

            const newSelect = tableBody.querySelector('tr:last-child .bahan-baku-select');
            newSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const hargaJual = selectedOption.dataset.harga || 0;
                this.closest('tr').querySelector(`input[name="pemesanan_bahan[${rowCount}][harga_jual]"]`).value =
                    hargaJual;

                if (this.value) {
                    selectedMaterialsTambah.add(parseInt(this.value));
                    addBahanBakuRowTambah(tableId);
                }
            });
        }

        // Fungsi untuk menghitung subtotal setiap row di modal tambah
        function updateSubtotalTambah(input) {
            const row = input.closest('tr');
            const hargaJual = parseFloat(row.querySelector(`input[name*="[harga_jual]"]`).value);
            const jumlah = parseFloat(input.value);
            const subtotal = hargaJual * jumlah;
            row.querySelector('.subtotal').textContent = subtotal.toFixed(2);
            updateTotalTambah();
        }

        // Fungsi untuk menghitung total dari semua row di modal tambah
        function updateTotalTambah() {
            let total = 0;
            document.querySelectorAll('#pemesananBahanTable .subtotal').forEach(element => {
                total += parseFloat(element.textContent) || 0;
            });
            document.getElementById('totalAmount').textContent = total.toFixed(2);
        }

        // Fungsi untuk menghapus row di modal tambah
        function removeRowTambah(button) {
            const row = button.closest('tr');
            const bahanId = parseInt(row.querySelector('.bahan-baku-select').value);

            if (bahanId) {
                selectedMaterialsTambah.delete(bahanId);
            }

            row.remove();
            updateTotalTambah();
        }

        // Fungsi untuk menambahkan row bahan baku di modal edit
        function addBahanBakuRowEdit(tableId, bahanId = '', bahanName = '', hargaJual = '', jumlah = '', deskripsi = '') {
            const tableBody = document.getElementById(tableId);
            const rowCount = tableBody.querySelectorAll('tr').length;

            // Buat opsi combobox dan set opsi yang sesuai dengan bahan yang sudah ada
            let bahanOptions = '<option value="">Pilih Bahan Baku</option>';
            currentAvailableMaterials.forEach(material => {
                bahanOptions +=
                    `<option value="${material.id}" ${material.id == bahanId ? 'selected' : ''}>${material.nama_bahan}</option>`;
            });

            const newRow = `
                <tr>
                    <td>
                        <select class="form-select w-100 bahan-baku-select" name="pemesanan_bahan[${rowCount}][id_bahan_baku]" required>
                            ${bahanOptions}
                        </select>
                    </td>
                    <td><input type="number" name="pemesanan_bahan[${rowCount}][harga_jual]" class="form-control w-100" value="${hargaJual}" readonly></td>
                    <td><input type="number" name="pemesanan_bahan[${rowCount}][jumlah]" class="form-control w-100" value="${jumlah}" required oninput="updateSubtotalEdit(this)"></td>
                    <td><input type="text" name="pemesanan_bahan[${rowCount}][deskripsi]" class="form-control w-100" value="${deskripsi}"></td>
                    <td class="subtotal">${(hargaJual * jumlah).toFixed(2)}</td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRowEdit(this)">Hapus</button></td>
                </tr>`;

            tableBody.insertAdjacentHTML('beforeend', newRow);
            updateTotalEdit();
        }


        // Fungsi untuk menghitung subtotal setiap row di modal edit
        function updateSubtotalEdit(input) {
            const row = input.closest('tr');
            const hargaJual = parseFloat(row.querySelector(`input[name*="[harga_jual]"]`).value);
            const jumlah = parseFloat(input.value);
            const subtotal = hargaJual * jumlah;
            row.querySelector('.subtotal').textContent = subtotal.toFixed(2);
            updateTotalEdit();
        }

        // Fungsi untuk menghitung total dari semua row di modal edit
        function updateTotalEdit() {
            let subtotal = 0;

            document.querySelectorAll('#editPemesananBahanTable .subtotal').forEach(
                element => {
                    subtotal += parseFloat(element.textContent) || 0;
                }
            );

            const pajak = subtotal * 0.1;
            const total = subtotal + pajak;

            document.getElementById('subtotalAmount').textContent = subtotal.toFixed(2);
            document.getElementById('pajakAmount').textContent = pajak.toFixed(2);
            document.getElementById('totalAmount').textContent = total.toFixed(2);
        }

        // Fungsi untuk menghapus row di modal edit
        function removeRowEdit(button) {
            const row = button.closest('tr');
            const bahanId = parseInt(row.querySelector('.bahan-baku-select').value);

            if (bahanId) {
                selectedMaterialsEdit.delete(bahanId);
            }

            row.remove();
            updateTotalEdit();
        }

        // Fungsi untuk membuka modal edit RFQ dan memuat data pemesanan bahan
        function openEditModal(orderId) {
            $('#modalEditRFQ').modal('show');
            $('#modalEditRFQ').data('orderId', orderId); // Simpan orderId di modal
            $('#pdfDownloadButton').attr('href', `/orders/${orderId}/pdf`);

            // Ambil data pesanan berdasarkan ID untuk mengisi modal edit
            $.get(`/orders/${orderId}`, function(data) {
                $('#edit_id_vendor').val(data.id_vendor).trigger(
                    'change'); // Set vendor dan panggil 'change' untuk memuat bahan baku
                $('#edit_tanggal_pemesanan').val(data.tanggal_pemesanan);
                $('#edit_kode_pemesanan').val(data.kode_pemesanan);
                $('#edit_nama_pemesan').val(data.nama_pemesan);
                $('#editPemesananBahanTable').empty();

                // Load bahan baku berdasarkan vendor
                $.get(`/vendor/${data.id_vendor}/bahan-baku`, function(bahanBakuData) {
                    currentAvailableMaterials = bahanBakuData;

                    // Tambahkan bahan baku ke tabel edit sesuai data dari server
                    data.pemesanan_bahan.forEach(bahan => {
                        addBahanBakuRowEdit(
                            'editPemesananBahanTable',
                            bahan.id_bahan_baku,
                            bahan.nama_bahan,
                            bahan.harga_jual,
                            bahan.jumlah,
                            bahan.deskripsi
                        );
                    });
                });

                // Cek status pesanan dan atur visibilitas tombol berdasarkan status
                if (data.status === 'pesanan_selesai') {
                    $('#acceptOrderButton').hide(); // Sembunyikan tombol "Terima Pesanan"
                    $('.btn-primary.edit').hide(); // Sembunyikan tombol "Perbarui"
                    $('#cekBahanButton').show(); // Sembunyikan tombol "Cek Bahan"
                    $('#paymentButton').hide(); // Sembunyikan tombol "Proses Pembayaran"
                } else if (data.status === 'menunggu_pembayaran') {
                    $('#acceptOrderButton').hide(); // Sembunyikan tombol "Terima Pesanan"
                    $('.btn-primary.edit').hide(); // Sembunyikan tombol "Perbarui"
                    $('#cekBahanButton').hide(); // Sembunyikan tombol "Cek Bahan"
                    $('#paymentButton').show(); // Tampilkan tombol "Proses Pembayaran"
                } else if (data.status === 'tagihan_dibuat') {
                    $('#acceptOrderButton').hide(); // Sembunyikan tombol "Terima Pesanan"
                    $('.btn-primary.edit').hide(); // Sembunyikan tombol "Perbarui"
                    $('#cekBahanButton').hide(); // Sembunyikan tombol "Cek Bahan"
                    $('#paymentButton').hide(); // Sembunyikan tombol "Proses Pembayaran"
                } else {
                    // Kondisi default untuk status lainnya
                    $('#acceptOrderButton').show(); // Tampilkan tombol "Terima Pesanan"
                    $('.btn-primary.edit').show(); // Tampilkan tombol "Perbarui"
                    $('#cekBahanButton').hide(); // Sembunyikan tombol "Cek Bahan"
                    $('#paymentButton').hide(); // Sembunyikan tombol "Proses Pembayaran"
                }


            }).fail(function() {
                alert("Gagal mengambil data. Silakan coba lagi.");
            });
        }




        // Fungsi untuk menampilkan row bahan baku yang sesuai pada modal edit
        function loadEditRows(data) {
            const tableBody = document.getElementById('editPemesananBahanTable');
            selectedMaterialsEdit.clear();

            data.forEach(material => {
                if (material.id_bahan_baku) {
                    addBahanBakuRowEdit(
                        'editPemesananBahanTable',
                        material.id_bahan_baku,
                        material.nama_bahan,
                        material.harga_jual,
                        material.jumlah,
                        material.deskripsi
                    );
                    selectedMaterialsEdit.add(material.id_bahan_baku);
                }
            });
        }


        // Fungsi untuk menerima pesanan dan memperbarui stok bahan
        function acceptOrder() {
            const orderId = $('#modalEditRFQ').data('orderId'); // Dapatkan orderId dari data modal
            if (!orderId) {
                alert("Order ID tidak ditemukan.");
                return;
            }

            $.ajax({
                url: `/orders/${orderId}/accept`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Pesanan berhasil diterima, stok bahan diperbarui
                    alert(response.message || "Pesanan diterima dan stok bahan diperbarui.");
                    window.location.href = "{{ route('orders.index') }}";
                },
                error: function(xhr) {
                    alert("Gagal menerima pesanan. Silakan coba lagi.");
                }
            });
        }




        // Fungsi untuk menghapus pesanan dan melakukan redirect setelah sukses
        function deleteOrder() {
            const orderId = $('#modalEditRFQ').data('orderId'); // Ambil orderId dari data modal
            if (!orderId) {
                alert("Order ID tidak ditemukan.");
                return;
            }

            $.ajax({
                url: `/orders/${orderId}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message || "Pesanan berhasil dihapus.");
                        // Redirect ke halaman utama setelah penghapusan sukses
                        window.location.href = "{{ route('orders.index') }}";
                    } else {
                        alert("Gagal menghapus pesanan: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 404) {
                        alert("Pesanan tidak ditemukan.");
                    } else {
                        alert("Gagal menghapus pesanan. Silakan coba lagi.");
                    }
                }
            });
        }

        // Fungsi untuk memperbarui order (submit form)
        $('#form-edit-rfq').on('submit', function(e) {
            e.preventDefault();
            const orderId = $('#modalEditRFQ').data('orderId');
            const url = `/orders/${orderId}`;
            $.ajax({
                url: url,
                type: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    alert(response.message || "RFQ berhasil diperbarui.");
                    window.location.href = "{{ route('orders.index') }}";
                },
                error: function(xhr) {
                    alert("Gagal memperbarui pesanan. Silakan coba lagi.");
                }
            });
        });

        // Fungsi untuk membuka modal Cek Bahan dan mengisi data bahan
        function openCekBahanModal() {
            $('#modalEditRFQ').modal('hide'); // Tutup modal edit
            $('#modalCekBahan').modal('show'); // Buka modal cek bahan

            const orderId = $('#modalEditRFQ').data('orderId');

            // Set action form cek bahan sesuai orderId
            $('#form-cek-bahan').attr('action', `/orders/${orderId}/cek-bahan`);

            $.get(`/orders/${orderId}`, function(data) {
                let cekBahanHtml = '';

                data.pemesanan_bahan.forEach((bahan, index) => {
                    cekBahanHtml += `
                        <div class="mb-3">
                            <label class="form-label">Bahan Baku: ${bahan.nama_bahan} (Jumlah Dipesan: ${bahan.jumlah})</label>
                            <input type="number" name="bahan_diterima[${bahan.id_bahan_baku}]" class="form-control" placeholder="Masukkan jumlah diterima" required>
                        </div>`;
                });

                $('#cekBahanContainer').html(cekBahanHtml);

                // Tambahkan tombol submit jika belum ada
                if (!$('#form-cek-bahan button[type="submit"]').length) {
                    $('#form-cek-bahan').append('<button type="submit" class="btn btn-primary">Simpan</button>');
                }
            });
        }

        function openPaymentModalFromEdit() {
            $('#modalEditRFQ').modal('hide'); // Tutup modal edit
            $('#modalPayment').modal('show'); // Buka modal pembayaran

            const orderId = $('#modalEditRFQ').data('orderId'); // Dapatkan order ID dari modal edit

            // Set action form pembayaran sesuai orderId
            $('#form-payment').attr('action', `/orders/${orderId}/payment`);
        }
    </script>
@endsection
