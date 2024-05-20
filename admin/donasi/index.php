<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../../koneksi/koneksi.php'); ?>

<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Donasi</h1>
                <button type="button" class="btn btn-primary" id="addBookButton" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data Donasi</button>
            </div>
            <div class="table-responsive">
                <table id="bukuTable" class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT pengguna.nama_pengguna, donasi.* FROM donasi, pengguna WHERE donasi.id_pengguna=pengguna.id_pengguna";
                        $result = mysqli_query($conn, $query);

                        if (!$result) {
                            echo "<tr><td colspan='8'>Gagal mengambil data: " . mysqli_error($conn) . "</td></tr>";
                        } else {
                            $no = 1;
                            while ($data = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?= htmlspecialchars($no++) ?></td>
                                    <td><?= htmlspecialchars($data['nama_pengguna']) ?></td>
                                    <td><?= htmlspecialchars($data['total_donasi']) ?></td>
                                    <td><?= htmlspecialchars($data['tanggal']) ?></td>
                                    <td>
                                        <button class="btn btn-warning editBookButton" data-id="<?= htmlspecialchars($data['id_donasi']) ?>">Edit</button>
                                        <button class="btn btn-danger deleteBookButton" data-id="<?= htmlspecialchars($data['id_donasi']) ?>">Hapus</button>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
<?php
// Ambil data pengguna dari database
$queryPengguna = "SELECT id_pengguna, nama_pengguna FROM pengguna";
$resultPengguna = mysqli_query($conn, $queryPengguna);

if (!$resultPengguna) {
    die('Gagal mengambil data pengguna: ' . mysqli_error($conn));
}
?>


<!-- Modal Tambah Donasi -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addForm" method="post" action="add_donation.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Donasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_pengguna" class="form-label">Nama Pengguna</label>
                        <select class="form-select" id="id_pengguna" name="id_pengguna" required>
                            <option value="">Pilih Nama Pengguna</option>
                            <?php while ($pengguna = mysqli_fetch_assoc($resultPengguna)) : ?>
                                <option value="<?= htmlspecialchars($pengguna['id_pengguna']) ?>">
                                    <?= htmlspecialchars($pengguna['nama_pengguna']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="total_donasi" class="form-label">Jumlah Donasi</label>
                        <input type="number" class="form-control" id="total_donasi" name="total_donasi" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Donasi -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="post" action="edit_donation.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Donasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id_donasi" name="id_donasi">
                    <div class="mb-3">
                        <label for="edit_id_pengguna" class="form-label">Nama Pengguna</label>
                        <select class="form-select" id="edit_id_pengguna" name="id_pengguna" required>
                            <option value="">Pilih Nama Pengguna</option>
                            <?php
                            // Ambil data pengguna dari database
                            $queryPengguna = "SELECT id_pengguna, nama_pengguna FROM pengguna";
                            $resultPengguna = mysqli_query($conn, $queryPengguna);
                            if (!$resultPengguna) {
                                die('Gagal mengambil data pengguna: ' . mysqli_error($conn));
                            }
                            while ($pengguna = mysqli_fetch_assoc($resultPengguna)) :
                            ?>
                                <option value="<?= htmlspecialchars($pengguna['id_pengguna']) ?>">
                                    <?= htmlspecialchars($pengguna['nama_pengguna']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_total_donasi" class="form-label">Jumlah Donasi</label>
                        <input type="number" class="form-control" id="edit_total_donasi" name="total_donasi" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus Donasi -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="post" action="delete_donation.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Donasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_id_donasi" name="id_donasi">
                    <p>Apakah Anda yakin ingin menghapus donasi ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        var table = $('#bukuTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/Indonesian.json"
            }
        });

        // Function to reload table data
        function reloadTable() {
            table.destroy();
            table = $('#bukuTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/Indonesian.json"
                }
            });
        }
        // Handle edit form submit
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: 'edit_donation.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#editModal').modal('hide');
                    alert('Donasi berhasil diubah');
                    reloadTable(); // Reload DataTable data
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + xhr.responseText);
                }
            });
        });
    });

    // Handle edit button click
    $('.editBookButton').on('click', function() {
        var id = $(this).data('id');
        $.ajax({
            url: 'get_donation.php',
            type: 'POST',
            data: {
                id_donasi: id
            },
            dataType: 'json',
            success: function(response) {
                $('#edit_id_donasi').val(response.id_donasi);
                $('#edit_nama_pengguna').val(response.nama_pengguna);
                $('#edit_total_donasi').val(response.total_donasi);
                $('#edit_tanggal').val(response.tanggal);
                $('#editModal').modal('show');

            }
        });
    });

    // Handle delete button click
    $('.deleteBookButton').on('click', function() {
        var id = $(this).data('id');
        $('#delete_id_donasi').val(id);
        $('#deleteModal').modal('show');

    });

    // Handle add form submit
    $('#addForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: 'add_donation.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#addModal').modal('hide');
                alert('Donasi berhasil ditambahkan');
                reloadTable(); // Reload DataTable data
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + xhr.responseText);
            }
        });
    });
</script>