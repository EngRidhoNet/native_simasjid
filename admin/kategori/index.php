<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../../koneksi/koneksi.php'); ?>

<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Kategori</h1>
                <button type="button" class="btn btn-primary" id="addBookButton" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Kategori</button>
            </div>
            <div class="table-responsive">
                <table id="kategoriTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID Kategori</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch data from the kategori table
                        $query = "SELECT * FROM kategori";
                        $result = mysqli_query($conn, $query);

                        // Check if there are any records
                        if (mysqli_num_rows($result) > 0) {
                            // Output data of each row
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id_kategori'] . "</td>";
                                echo "<td>" . $row['nama_kategori'] . "</td>";
                                echo "<td>
                                        <button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#updateModal' onclick='updateBook(" . $row['id_kategori'] . ")'>Edit</button>
                                        <button type='button' class='btn btn-danger btn-sm' onclick='deleteBook(" . $row['id_kategori'] . ")'>Hapus</button>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No data found...</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<!-- Modal for Add -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm">
                    <div class="mb-3">
                        <label for="add_nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="add_nama_kategori" name="nama_kategori" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Update -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm">
                    <input type="hidden" id="update_id_kategori" name="id_kategori">
                    <div class="mb-3">
                        <label for="update_nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="update_nama_kategori" name="nama_kategori" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="deleteForm">
                    <input type="hidden" id="delete_id_kategori" name="id_kategori">
                    <p>Anda yakin ingin menghapus kategori ini?</p>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

<script>
    $('#kategoriTable').DataTable();
    // Handle Add form submit
    $('#addForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'add_kategori.php', // Endpoint to add a new record
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response == 'success') {
                    $('#addModal').modal('hide');
                    location.reload();
                } else {
                    alert('Failed to add record.');
                }
            }
        });
    });

    // Handle Update form submit
    $('#updateForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'update_kategori.php', // Endpoint to update a record
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response == 'success') {
                    $('#updateModal').modal('hide');
                    location.reload();
                } else {
                    alert('Failed to update record.');
                }
            }
        });
    });

    // Handle Delete form submit
    $('#deleteForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'delete_kategori.php', // Endpoint to delete a record
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response == 'success') {
                    $('#deleteModal').modal('hide');
                    location.reload();
                } else {
                    alert('Failed to delete record.');
                }
            }
        });
    });

    function updateBook(id) {
        // Fetch data from the server
        $.ajax({
            url: 'get_kategori_by_id.php', // Endpoint to get single record by ID
            method: 'GET',
            data: {
                id_kategori: id
            },
            success: function(response) {
                var data = JSON.parse(response);
                $('#update_id_kategori').val(data.id_kategori);
                $('#update_nama_kategori').val(data.nama_kategori);
                $('#updateModal').modal('show');
            }
        });
    }

    function deleteBook(id) {
        $('#delete_id_kategori').val(id);
        $('#deleteModal').modal('show');
    }
</script>