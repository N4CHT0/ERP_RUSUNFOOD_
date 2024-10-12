@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">

                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Bill Of Material</h5>
                    <small class="text-muted float-end">Buat Bill Of Material ( BoM )</small>
                </div>

                <div class="card-body">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#modalCenter">
                        <span class="tf-icons bx bx-add-to-queue"></span>&nbsp; Buat
                    </button>

                    <!-- Modal Buat BOM -->
                    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalCenterTitle">Buat BoM</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="form-bom" action="{{ route('Production.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="" class="form-label">Produk</label>
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
                                            <div class="col mb-0">
                                                <label for="kodeProduksi" class="form-label">Kode Produksi</label>
                                                <input type="text" name="kode_produksi" class="form-control"
                                                    placeholder="Kode Produksi" required />
                                            </div>
                                            <div class="col mb-0">
                                                <label for="jumlahProduksi" class="form-label">Jumlah Produksi</label>
                                                <input type="number" name="jumlah_produksi" class="form-control"
                                                    placeholder="Jumlah Produksi" required />
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col mb-0">
                                                <label for="tanggalProduksi" class="form-label">Tanggal Produksi</label>
                                                <input type="date" name="tanggal_produksi" class="form-control"
                                                    required />
                                            </div>
                                            <div class="col mb-0">
                                                <label for="tanggalKadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
                                                <input type="date" name="tanggal_kadaluarsa" class="form-control"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="tanggalSelesaiProduksi" class="form-label">Tanggal Selesai
                                                    Produksi</label>
                                                <input type="date" name="tanggal_selesai_produksi" class="form-control"
                                                    required />
                                            </div>
                                        </div>

                                        <!-- Tabel untuk input bahan baku -->
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Bahan Baku</th>
                                                    <th>Jumlah</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0" id="bahanBakuTable">
                                                <!-- Baris kosong untuk memulai -->
                                                <tr id="initialRow">
                                                    <td colspan="3" class="text-center" style="cursor: pointer;"
                                                        onclick="addRow()">
                                                        <i class="bx bx-plus-circle"></i> Klik untuk menambah bahan baku
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
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
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode Produk</th>
                                <th>Produk</th>
                                <th>Jumlah Produksi</th>
                                <th>Tanggal Produksi</th>
                                {{-- <th>Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse($data as $production)
                                <tr
                                    onclick="showDetailModal(
                                    {{ $production->id }},
                                    '{{ $production->kode_produksi }}',
                                    '{{ $production->product ? $production->product->nama_produk : 'Tidak diketahui' }}',
                                    {{ $production->jumlah_produksi }},
                                    '{{ $production->tanggal_produksi }}',
                                    {{ json_encode($production->bahan_digunakan) }})">
                                    <td>{{ $production->kode_produksi }}</td>
                                    <td>{{ $production->product ? $production->product->nama_produk : 'Tidak diketahui' }}
                                    </td>
                                    <td>{{ $production->jumlah_produksi }}</td>
                                    <td>{{ $production->tanggal_produksi }}</td>
                                    {{-- <td>
                                        <!-- Actions for Edit/Delete -->
                                        <a href="{{ route('Production.edit', $production->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('Production.destroy', $production->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</button>
                                        </form>
                                    </td> --}}
                                </tr>
                            @empty
                                <tr id="initialRow">
                                    <td colspan="5" class="text-center" style="cursor: pointer;">
                                        <i class="bx bx-list-ol"></i> Data Kosong
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
            <!--/ Hoverable Table rows -->
        </div>
    </div>

    <!-- Modal Detail Produksi -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Bill Of Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Kode Produksi:</strong> <span id="modalKodeProduksi"></span></p>
                    <p><strong>Nama Produk:</strong> <span id="modalNamaProduk"></span></p>
                    <p><strong>Jumlah Produksi:</strong> <span id="modalJumlahProduksi"></span></p>
                    <p><strong>Tanggal Produksi:</strong> <span id="modalTanggalProduksi"></span></p>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Bahan Baku</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="bahanBakuTableDetail">
                            <!-- Data bahan baku akan diisi dengan JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <a href="#" id="btnCetakPDF" class="btn btn-danger">Cetak</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Hidden Select for Bahan Baku -->
    <select id="materialOptions" class="d-none">
        <option value="">Pilih Bahan Baku</option>
        @foreach ($materials as $item)
            <option value="{{ $item->id }}">{{ $item->nama_bahan }}</option>
        @endforeach
        <option value="create">Buat Bahan Baku</option>
    </select>
@endsection

@section('script')
    <script>
        function addRow() {
            var table = document.getElementById("bahanBakuTable");

            // Buat baris baru
            var newRow = document.createElement("tr");

            // Cell untuk Bahan Baku (select)
            var newCell1 = document.createElement("td");
            var select = document.createElement("select");
            select.className = "form-select";
            select.name = "bahan_baku[]"; // Multiple bahan baku

            // Salin opsi dari elemen hidden
            var materialOptions = document.getElementById("materialOptions").innerHTML;
            select.innerHTML = materialOptions;

            newCell1.appendChild(select);

            // Event listener untuk mengarahkan ke halaman buat bahan baku
            select.addEventListener('change', function() {
                if (this.value === 'create') {
                    window.location.href = "{{ route('Material.create') }}";
                }
            });

            // Cell untuk Jumlah (input number)
            var newCell2 = document.createElement("td");
            var input = document.createElement("input");
            input.className = "form-control";
            input.type = "number";
            input.name = "bahan_digunakan[]"; // Multiple jumlah bahan
            input.placeholder = "Jumlah";
            newCell2.appendChild(input);

            // Cell untuk tombol hapus
            var newCell3 = document.createElement("td");
            var deleteButton = document.createElement("button");
            deleteButton.className = "btn btn-danger btn-sm"; // Tombol kecil
            deleteButton.innerHTML = '<i class="bx bx-trash"></i>'; // Icon hapus
            deleteButton.setAttribute("type", "button");
            deleteButton.setAttribute("onclick", "removeRow(this)");
            newCell3.appendChild(deleteButton);

            // Tambahkan semua cell ke baris baru
            newRow.appendChild(newCell1);
            newRow.appendChild(newCell2);
            newRow.appendChild(newCell3);

            // Tambahkan baris baru ke tabel sebelum baris "initialRow"
            table.insertBefore(newRow, document.getElementById("initialRow"));
        }

        function removeRow(button) {
            var row = button.parentElement.parentElement;
            row.remove();
        }

        function showDetailModal(id, kodeProduksi, namaProduk, jumlahProduksi, tanggalProduksi, bahanBakuJson) {
            // Isi data ke modal
            document.getElementById('modalKodeProduksi').innerText = kodeProduksi;
            document.getElementById('modalNamaProduk').innerText = namaProduk;
            document.getElementById('modalJumlahProduksi').innerText = jumlahProduksi;
            document.getElementById('modalTanggalProduksi').innerText = tanggalProduksi;

            // Kosongkan tabel bahan baku sebelumnya
            var bahanBakuTableDetail = document.getElementById('bahanBakuTableDetail');
            bahanBakuTableDetail.innerHTML = ''; // Clear previous data

            // Pastikan bahanBakuJson berisi array
            if (Array.isArray(bahanBakuJson)) {
                // Loop melalui bahan baku yang digunakan dan tambahkan ke tabel
                bahanBakuJson.forEach(function(bahan) {
                    var newRow = document.createElement('tr');
                    var cellNamaBahan = document.createElement('td');
                    cellNamaBahan.textContent = bahan.nama_bahan ? bahan.nama_bahan : 'Tidak diketahui';
                    newRow.appendChild(cellNamaBahan);

                    var cellJumlahBahan = document.createElement('td');
                    cellJumlahBahan.textContent = bahan.jumlah_digunakan;
                    newRow.appendChild(cellJumlahBahan);

                    bahanBakuTableDetail.appendChild(newRow);
                });
            }

            // Set URL button cetak
            document.getElementById('btnCetakPDF').href = '/production/cetak-pdf/' + id;

            // Tampilkan modal
            var detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
            detailModal.show();
        }

        document.getElementById('produkSelect').addEventListener('change', function() {
            if (this.value === 'create') {
                window.location.href = "{{ route('Product.create') }}";
            }
        });
    </script>
@endsection
