<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../../koneksi/koneksi.php'); ?>

<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Galeri</h1>
                <button type="button" class="btn btn-primary" id="addBookButton" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Galeri</button>
            </div>
            <table id="galeriTable" class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Foto</th>
                        <th>Diunggah Pada</th>
                        <th>Diunggah Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT pengguna.nama_pengguna, galeri.* FROM galeri JOIN pengguna ON galeri.diunggah_oleh = pengguna.id_pengguna";
                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        echo "<tr><td colspan='6'>Gagal mengambil data: " . mysqli_error($conn) . "</td></tr>";
                    } else {
                        $no = 1;
                        while ($data = mysqli_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td><?= htmlspecialchars($no++) ?></td>
                                <td><?= htmlspecialchars($data['judul_foto']) ?></td>
                                <td><img src="<?= htmlspecialchars($data['path_file']) ?>" alt="Foto Galeri" style="width: 100px; height: auto;"></td>
                                <td><?= htmlspecialchars($data['diunggah_pada']) ?></td>
                                <td><?= htmlspecialchars($data['nama_pengguna']) ?></td>
                                <td>
                                    <button class="btn btn-warning editBookButton" data-id="<?= htmlspecialchars($data['id_galeri']) ?>">Edit</button>
                                    <button class="btn btn-danger deleteBookButton" data-id="<?= htmlspecialchars($data['id_galeri']) ?>">Hapus</button>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
</div>

<!-- Add Gallery Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addGalleryForm" action="add_gallery.php" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Galeri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul_foto" class="form-label">Judul Foto</label>
                        <input type="text" class="form-control" id="judul_foto" name="judul_foto" required>
                    </div>
                    <div class="mb-3">
                        <label for="path_file" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="path_file" name="path_file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Gallery Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editGalleryForm" action="edit_gallery.php" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Galeri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id_galeri" name="id_galeri">
                    <div class="mb-3">
                        <label for="edit_judul_foto" class="form-label">Judul Foto</label>
                        <input type="text" class="form-control" id="edit_judul_foto" name="judul_foto" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_path_file" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="edit_path_file" name="path_file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Gallery Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteGalleryForm" action="delete_gallery.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Galeri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_id_galeri" name="id_galeri">
                    <p>Apakah Anda yakin ingin menghapus galeri ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<script>
    $(document).ready(function() {
        var table = $('#galeriTable').DataTable();
    });
    document.addEventListener('DOMContentLoaded', (event) => {
        // Edit button event
        document.querySelectorAll('.editBookButton').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                fetch(`get_gallery.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit_id_galeri').value = data.id_galeri;
                        document.getElementById('edit_judul_foto').value = data.judul_foto;
                        // Show the modal
                        new bootstrap.Modal(document.getElementById('editModal')).show();
                    });
            });
        });

        // Delete button event
        document.querySelectorAll('.deleteBookButton').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                document.getElementById('delete_id_galeri').value = id;
                // Show the modal
                new bootstrap.Modal(document.getElementById('deleteModal')).show();
            });
        });

        // Add button event
        document.getElementById('addBookButton').addEventListener('click', function() {
            // Show the modal
            new bootstrap.Modal(document.getElementById('addModal')).show();
        });
    });
</script>