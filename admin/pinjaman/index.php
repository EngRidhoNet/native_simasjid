<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../../koneksi/koneksi.php'); ?>

<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Pinjaman Buku</h1>
                <button type="button" class="btn btn-primary" id="addPinjamanButton" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>
            </div>
            <div class="table-responsive">
                <table id="pinjamanTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Buku</th>
                            <th>Nama Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT pb.id_pinjaman, b.judul, p.nama_pengguna, pb.tanggal_pinjam, pb.tanggal_kembali 
                                  FROM pinjamanbuku pb
                                  JOIN buku b ON pb.id_buku = b.id_buku
                                  JOIN pengguna p ON pb.id_pengguna = p.id_pengguna";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $no . "</td>";
                                echo "<td>" . $row['judul'] . "</td>";
                                echo "<td>" . $row['nama_pengguna'] . "</td>";
                                echo "<td>" . $row['tanggal_pinjam'] . "</td>";
                                echo "<td>" . ($row['tanggal_kembali'] ? $row['tanggal_kembali'] : 'Belum Kembali') . "</td>";
                                echo "<td>";
                                echo "<button class='btn btn-sm btn-warning editButton' data-id='" . $row['id_pinjaman'] . "' data-bs-toggle='modal' data-bs-target='#editModal'>Edit</button> ";
                                echo "<button class='btn btn-sm btn-danger deleteButton' data-id='" . $row['id_pinjaman'] . "' data-bs-toggle='modal' data-bs-target='#deleteModal'>Delete</button>";
                                echo "</td>";
                                echo "</tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='6'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addForm" method="post" action="add_pinjaman.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Pinjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_buku" class="form-label">Buku</label>
                        <select class="form-select" id="id_buku" name="id_buku" required>
                            <?php
                            $bukuQuery = "SELECT id_buku, judul FROM buku";
                            $bukuResult = mysqli_query($conn, $bukuQuery);
                            while ($buku = mysqli_fetch_assoc($bukuResult)) {
                                echo "<option value='" . $buku['id_buku'] . "'>" . $buku['judul'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_pengguna" class="form-label">Peminjam</label>
                        <select class="form-select" id="id_pengguna" name="id_pengguna" required>
                            <?php
                            $penggunaQuery = "SELECT id_pengguna, nama_pengguna FROM pengguna";
                            $penggunaResult = mysqli_query($conn, $penggunaQuery);
                            while ($pengguna = mysqli_fetch_assoc($penggunaResult)) {
                                echo "<option value='" . $pengguna['id_pengguna'] . "'>" . $pengguna['nama_pengguna'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali">
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="post" action="edit_pinjaman.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Pinjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id_pinjaman" name="id_pinjaman">
                    <div class="mb-3">
                        <label for="edit_id_buku" class="form-label">Buku</label>
                        <select class="form-select" id="edit_id_buku" name="id_buku" required>
                            <?php
                            $bukuQuery = "SELECT id_buku, judul FROM buku";
                            $bukuResult = mysqli_query($conn, $bukuQuery);
                            while ($buku = mysqli_fetch_assoc($bukuResult)) {
                                echo "<option value='" . $buku['id_buku'] . "'>" . $buku['judul'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_id_pengguna" class="form-label">Peminjam</label>
                        <select class="form-select" id="edit_id_pengguna" name="id_pengguna" required>
                            <?php
                            $penggunaQuery = "SELECT id_pengguna, nama_pengguna FROM pengguna";
                            $penggunaResult = mysqli_query($conn, $penggunaQuery);
                            while ($pengguna = mysqli_fetch_assoc($penggunaResult)) {
                                echo "<option value='" . $pengguna['id_pengguna'] . "'>" . $pengguna['nama_pengguna'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control" id="edit_tanggal_pinjam" name="tanggal_pinjam" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control" id="edit_tanggal_kembali" name="tanggal_kembali">
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
            <form id="deleteForm" method="post" action="delete_pinjaman.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Pinjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_id_pinjaman" name="id_pinjaman">
                    <p>Are you sure you want to delete this record?</p>
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
        $('#pinjamanTable').DataTable();

        $('.editButton').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'get_pinjaman.php',
                type: 'POST',
                data: {
                    id_pinjaman: id
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $('#edit_id_pinjaman').val(data.id_pinjaman);
                    $('#edit_id_buku').val(data.id_buku);
                    $('#edit_id_pengguna').val(data.id_pengguna);
                    $('#edit_tanggal_pinjam').val(data.tanggal_pinjam);
                    $('#edit_tanggal_kembali').val(data.tanggal_kembali);
                }
            });
        });

        $('.deleteButton').on('click', function() {
            var id = $(this).data('id');
            $('#delete_id_pinjaman').val(id);
        });
    });
</script>