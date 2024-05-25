<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../../koneksi/koneksi.php'); ?>

<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Pengguna</h1>
                <button type="button" class="btn btn-primary" id="addPenggunaButton" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Pengguna</button>
            </div>
            <div class="table-responsive">
                <table id="penggunaTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengguna</th>
                            <th>Username</th>
                            <th>Peran</th>
                            <th>Dibuat Pada</th>
                            <th>Diperbarui Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM pengguna";
                        $result = mysqli_query($conn, $query);
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['nama_pengguna']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['peran']}</td>
                                    <td>{$row['dibuat_pada']}</td>
                                    <td>{$row['diperbarui_pada']}</td>
                                    <td>
                                        <button class='btn btn-warning btn-edit' data-id='{$row['id_pengguna']}'>Edit</button>
                                        <button class='btn btn-danger btn-delete' data-id='{$row['id_pengguna']}'>Delete</button>
                                    </td>
                                  </tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<!-- Add Pengguna Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addPenggunaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="add_pengguna.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPenggunaModalLabel">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_pengguna" class="form-label">Nama Pengguna</label>
                        <input type="text" class="form-control" name="nama_pengguna" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="peran" class="form-label">Peran</label>
                        <select class="form-control" name="peran" required>
                            <option value="admin">Admin</option>
                            <option value="jamaah">Jamaah</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Pengguna Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editPenggunaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="update_pengguna.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPenggunaModalLabel">Edit Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_pengguna" id="edit-id-pengguna">
                    <div class="mb-3">
                        <label for="edit-nama_pengguna" class="form-label">Nama Pengguna</label>
                        <input type="text" class="form-control" name="nama_pengguna" id="edit-nama_pengguna" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="edit-username" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="edit-password">
                    </div>
                    <div class="mb-3">
                        <label for="edit-peran" class="form-label">Peran</label>
                        <select class="form-control" name="peran" id="edit-peran" required>
                            <option value="admin">Admin</option>
                            <option value="jamaah">Jamaah</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Pengguna Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deletePenggunaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="delete_pengguna.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePenggunaModalLabel">Hapus Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_pengguna" id="delete-id-pengguna">
                    <p>Apakah Anda yakin ingin menghapus pengguna ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        $('#penggunaTable').DataTable();

        $('.btn-edit').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'get_pengguna.php',
                type: 'POST',
                data: {
                    id_pengguna: id
                },
                success: function(data) {
                    var pengguna = JSON.parse(data);
                    $('#edit-id-pengguna').val(pengguna.id_pengguna);
                    $('#edit-nama_pengguna').val(pengguna.nama_pengguna);
                    $('#edit-username').val(pengguna.username);
                    $('#edit-password').val('');
                    $('#edit-peran').val(pengguna.peran);
                    $('#editModal').modal('show');
                }
            });
        });

        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            $('#delete-id-pengguna').val(id);
            $('#deleteModal').modal('show');
        });
    });
</script>