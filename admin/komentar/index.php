<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../../koneksi/koneksi.php'); ?>

<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Komentar</h1>
            </div>
            <div class="table-responsive">
                <table id="komentarTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Judul Blog</th>
                            <th>Nama Pengguna</th>
                            <th>Isi Komentar</th>
                            <th>Dibuat Pada</th>
                            <th>Diperbarui Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query to fetch the comments with blog title and user name
                        $query = "SELECT komentarblog.id_komentar, komentarblog.isi_komentar, komentarblog.dibuat_pada, komentarblog.diperbarui_pada, 
                                  blog.judul, pengguna.nama_pengguna 
                                  FROM komentarblog 
                                  JOIN blog ON komentarblog.id_blog = blog.id_blog 
                                  JOIN pengguna ON komentarblog.id_pengguna = pengguna.id_pengguna";

                        $result = mysqli_query($conn, $query);

                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['judul']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_pengguna']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['isi_komentar']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['dibuat_pada']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['diperbarui_pada']) . "</td>";
                                echo "<td>
                                        <button class='btn btn-warning edit-btn' data-id='" . $row['id_komentar'] . "' data-bs-toggle='modal' data-bs-target='#editModal'>Edit</button>
                                        <button class='btn btn-danger delete-btn' data-id='" . $row['id_komentar'] . "' data-bs-toggle='modal' data-bs-target='#deleteModal'>Delete</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No comments found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="post" action="edit_komentar.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Komentar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_komentar" id="edit-id-komentar">
                    <div class="mb-3">
                        <label for="edit-isi-komentar" class="form-label">Isi Komentar</label>
                        <textarea class="form-control" id="edit-isi-komentar" name="isi_komentar" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="post" action="delete_komentar.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Komentar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_komentar" id="delete-id-komentar">
                    <p>Are you sure you want to delete this comment?</p>
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
        $('#komentarTable').DataTable();

        // Edit button click
        $('.edit-btn').on('click', function() {
            var id = $(this).data('id');
            $('#edit-id-komentar').val(id);

            // Fetch comment data based on id and fill the form (you need to implement fetch logic)
            $.ajax({
                url: 'get_komentar.php', // This should be the URL to fetch comment data
                method: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    $('#edit-isi-komentar').val(response.isi_komentar);
                }
            });
        });

        // Delete button click
        $('.delete-btn').on('click', function() {
            var id = $(this).data('id');
            $('#delete-id-komentar').val(id);
        });
    });
</script>