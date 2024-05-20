<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../../koneksi/koneksi.php'); ?>

<style>
    textarea.form-control {
        height: 200px;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Daftar Buku</h1>
                <button type="button" class="btn btn-primary" id="addBookButton">Tambah Buku</button>
            </div>
            <div class="table-responsive">
                <table id="bukuTable" class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Tahun Terbit</th>
                            <th>ISBN</th>
                            <th>Dibuat Pada</th>
                            <th>Diperbarui Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM buku";
                        $result = mysqli_query($conn, $query);

                        if (!$result) {
                            echo "<tr><td colspan='8'>Gagal mengambil data: " . mysqli_error($conn) . "</td></tr>";
                        } else {
                            $no = 1;
                            while ($data = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?= htmlspecialchars($no++) ?></td>
                                    <td><?= htmlspecialchars($data['judul']) ?></td>
                                    <td><?= htmlspecialchars($data['penulis']) ?></td>
                                    <td><?= htmlspecialchars($data['tahun_terbit']) ?></td>
                                    <td><?= htmlspecialchars($data['isbn']) ?></td>
                                    <td><?= htmlspecialchars($data['dibuat_pada']) ?></td>
                                    <td><?= htmlspecialchars($data['diperbarui_pada']) ?></td>
                                    <td>
                                        <button class="btn btn-warning editBookButton" data-id="<?= htmlspecialchars($data['id_buku']) ?>">Edit</button>
                                        <button class="btn btn-danger deleteBookButton" data-id="<?= htmlspecialchars($data['id_buku']) ?>">Hapus</button>
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

<!-- Modal Tambah Buku -->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="add_book.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookModalLabel">Tambah Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="penulis" class="form-label">Penulis</label>
                        <input type="text" class="form-control" id="penulis" name="penulis" required>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                        <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" required>
                    </div>
                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="isbn" name="isbn">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Buku -->
<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="edit_book.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBookModalLabel">Edit Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id_buku" name="id_buku">
                    <div class="mb-3">
                        <label for="edit_judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="edit_judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_penulis" class="form-label">Penulis</label>
                        <input type="text" class="form-control" id="edit_penulis" name="penulis" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tahun_terbit" class="form-label">Tahun Terbit</label>
                        <input type="number" class="form-control" id="edit_tahun_terbit" name="tahun_terbit" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="edit_isbn" name="isbn">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus Buku -->
<div class="modal fade" id="deleteBookModal" tabindex="-1" aria-labelledby="deleteBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="delete_book.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBookModalLabel">Hapus Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_id_buku" name="id_buku">
                    <p>Apakah Anda yakin ingin menghapus buku ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#bukuTable').DataTable();

        // Tambah Buku
        $('#addBookButton').on('click', function() {
            $('#addBookModal').modal('show');
        });

        // Edit Buku
        $('#bukuTable tbody').on('click', '.editBookButton', function() {
            const id = $(this).data('id');

            $.ajax({
                url: 'get_book.php',
                type: 'GET',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    $('#edit_id_buku').val(data.id_buku);
                    $('#edit_judul').val(data.judul);
                    $('#edit_penulis').val(data.penulis);
                    $('#edit_tahun_terbit').val(data.tahun_terbit);
                    $('#edit_isbn').val(data.isbn);
                    $('#editBookModal').modal('show');
                }
            });
        });

        // Hapus Buku
        $('#bukuTable tbody').on('click', '.deleteBookButton', function() {
            const id = $(this).data('id');
            $('#delete_id_buku').val(id);
            $('#deleteBookModal').modal('show');
        });
    });
</script>