@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Vendor</h5>
                    <small class="text-muted float-end">Data Vendor Pemasok Bahan Baku</small>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#modalVendor">
                        <span class="tf-icons bx bx-add-to-queue"></span>&nbsp; Masukan Vendor Baru
                    </button>

                    <!-- Modal untuk Menambahkan Vendor -->
                    <div class="modal fade" id="modalVendor" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Vendor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form id="form-bom" action="{{ route('Vendor.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama Vendor</label>
                                            <input type="text" name="nama" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <input type="text" name="alamat" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="no_telepon" class="form-label">No. Telepon</label>
                                            <input type="text" name="no_telepon" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="bahan_baku" class="form-label">Pilih Material</label>
                                            <select class="form-select" id="materialSelect">
                                                <option value="">Pilih Material</option>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}"
                                                        data-nama="{{ $material->nama_bahan }}">{{ $material->nama_bahan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Tabel untuk menampilkan Bahan Baku -->
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Bahan Baku</th>
                                                    <th>Harga Jual</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bahanBakuTable">
                                                <tr id="placeholderRow">
                                                    <td colspan="3" class="text-center">Pilih Material untuk menambah
                                                        baris</td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Vendor</th>
                                <th>Alamat</th>
                                <th>No. Telepon</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendors as $vendor)
                                <tr>
                                    <td>{{ $vendor->nama }}</td>
                                    <td>{{ $vendor->alamat }}</td>
                                    <td>{{ $vendor->no_telepon }}</td>
                                    <td>{{ $vendor->email }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-vendor"
                                            data-id="{{ $vendor->id }}" data-nama="{{ $vendor->nama }}"
                                            data-alamat="{{ $vendor->alamat }}" data-telepon="{{ $vendor->no_telepon }}"
                                            data-email="{{ $vendor->email }}">
                                            Edit
                                            <script type="application/json" class="vendor-data">
        @json($vendor->detailed_bahan_baku ?? [])
    </script>
                                        </button>



                                        <form action="{{ route('Vendor.destroy', $vendor->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Mengedit Vendor (Dinamis) -->
    <div class="modal fade" id="modalVendorEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="form-bom-edit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="editVendorId" name="id">
                        <div class="mb-3">
                            <label for="editNama" class="form-label">Nama Vendor</label>
                            <input type="text" id="editNama" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAlamat" class="form-label">Alamat</label>
                            <input type="text" id="editAlamat" name="alamat" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTelepon" class="form-label">No. Telepon</label>
                            <input type="text" id="editTelepon" name="no_telepon" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" id="editEmail" name="email" class="form-control" required>
                        </div>

                        <!-- Pilih Material dan Tabel Bahan Baku -->
                        <div class="mb-3">
                            <label for="editMaterialSelect" class="form-label">Pilih Material</label>
                            <select class="form-select" id="editMaterialSelect">
                                <option value="">Pilih Material</option>
                                @foreach ($materials as $material)
                                    <option value="{{ $material->id }}" data-nama="{{ $material->nama_bahan }}">
                                        {{ $material->nama_bahan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Bahan Baku</th>
                                    <th>Harga Jual</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="editBahanBakuTable">
                                <tr id="editPlaceholderRow">
                                    <td colspan="3" class="text-center">Pilih Material untuk menambah baris</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.querySelectorAll('.btn-edit-vendor').forEach(button => {
            button.addEventListener('click', function() {
                const vendorId = this.dataset.id;
                const rawBahanBaku = this.querySelector('.vendor-data').textContent;

                let bahanBakuData = [];
                if (rawBahanBaku) {
                    try {
                        bahanBakuData = JSON.parse(rawBahanBaku);
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                    }
                }

                document.getElementById('form-bom-edit').action = `/vendor/${vendorId}`;
                document.getElementById('editNama').value = this.dataset.nama;
                document.getElementById('editAlamat').value = this.dataset.alamat;
                document.getElementById('editTelepon').value = this.dataset.telepon;
                document.getElementById('editEmail').value = this.dataset.email;

                const editTableBody = document.getElementById('editBahanBakuTable');
                editTableBody.innerHTML = ''; // Kosongkan tabel bahan baku

                if (bahanBakuData.length > 0) {
                    bahanBakuData.forEach(item => {
                        addMaterialRow('editBahanBakuTable', item.id, item.nama_bahan, item
                            .harga_jual, 'edit');
                    });
                } else {
                    editTableBody.innerHTML =
                        '<tr id="editPlaceholderRow"><td colspan="3" class="text-center">Pilih Material untuk menambah baris</td></tr>';
                }

                new bootstrap.Modal(document.getElementById('modalVendorEdit')).show();
            });
        });

        // Fungsi untuk menambah baris bahan baku
        function addMaterialRow(tableId, materialId, materialName, hargaJual = '', prefix = '') {
            const tableBody = document.getElementById(tableId);
            const newRow = `
                <tr id="${prefix}MaterialRow-${materialId}">
                    <td>${materialName}<input type="hidden" name="${prefix}bahan_baku[]" value="${materialId}"></td>
                    <td><input type="number" name="${prefix}harga_jual[]" class="form-control" placeholder="Harga Jual" value="${hargaJual}" required></td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow('${tableId}', '${prefix}MaterialRow-${materialId}')">Hapus</button></td>
                </tr>`;
            tableBody.insertAdjacentHTML('beforeend', newRow);
        }

        // Fungsi untuk menghapus baris bahan baku
        function removeRow(tableId, rowId) {
            document.getElementById(rowId).remove();
            const tableBody = document.getElementById(tableId);
            if (tableBody.childElementCount === 0) {
                tableBody.innerHTML =
                    '<tr id="editPlaceholderRow"><td colspan="3" class="text-center">Pilih Material untuk menambah baris</td></tr>';
            }
        }

        // Event handler untuk pemilihan material di modal tambah
        $('#materialSelect').on('change', function() {
            const selectedMaterial = $(this).find(':selected');
            const materialId = selectedMaterial.val();
            const materialName = selectedMaterial.data('nama');

            if (materialId) {
                addMaterialRow('bahanBakuTable', materialId, materialName);
                $('#placeholderRow').remove();
            }
        });

        // Event listener untuk mengumpulkan data bahan baku sebelum submit
        document.getElementById('form-bom-edit').addEventListener('submit', function(event) {
            // Kumpulkan data bahan_baku dari tabel edit
            const bahanBakuData = [];
            document.querySelectorAll('#editBahanBakuTable tr').forEach(row => {
                const materialId = row.querySelector('input[name="editbahan_baku[]"]').value;
                const hargaJual = row.querySelector('input[name="editharga_jual[]"]').value;
                if (materialId) {
                    bahanBakuData.push({
                        id: materialId,
                        harga_jual: hargaJual
                    });
                }
            });

            // Set data bahan_baku ke dalam field hidden input
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'bahan_baku_data';
            hiddenInput.value = JSON.stringify(bahanBakuData);
            this.appendChild(hiddenInput);
        });

        // Inisialisasi Choices untuk pencarian material di modal tambah
        document.addEventListener('DOMContentLoaded', function() {
            new Choices('#materialSelect', {
                searchEnabled: true,
                placeholderValue: 'Pilih Material',
                itemSelectText: '',
            });

            new Choices('#editMaterialSelect', {
                searchEnabled: true,
                placeholderValue: 'Pilih Material',
                itemSelectText: '',
            });
        });

        // Event handler untuk pemilihan material di modal edit
        $('#editMaterialSelect').on('change', function() {
            const selectedMaterial = $(this).find(':selected');
            const materialId = selectedMaterial.val();
            const materialName = selectedMaterial.data('nama');

            if (materialId && !document.getElementById(`editMaterialRow-${materialId}`)) {
                $('#editPlaceholderRow').remove(); // Hapus placeholder jika ada
                addMaterialRow('editBahanBakuTable', materialId, materialName, '', 'edit');
            }
        });
    </script>
@endsection
