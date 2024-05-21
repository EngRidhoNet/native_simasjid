<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../../koneksi/koneksi.php'); ?>

<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Kegiatan</h1>
                <button type="button" class="btn btn-primary" id="addBookButton" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Kegiatan</button>
            </div>
            <div class="table-responsive">
                <table id="kegiatanTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch data from the kegiatan table
                        $query = "SELECT * FROM kegiatan";
                        $result = mysqli_query($conn, $query);

                        // Check if there are any records
                        if (mysqli_num_rows($result) > 0) {
                            // Output data of each row
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['judul'] . "</td>";
                                echo "<td><img src='" . $row['foto'] . "' alt='Gambar Kegiatan' width='100'></td>";
                                echo "<td>" . $row['deskripsi'] . "</td>";
                                echo "<td>" . $row['tanggal'] . "</td>";
                                echo "<td>" . $row['waktu'] . "</td>";
                                echo "<td>" . $row['lokasi'] . "</td>";
                                echo "<td>
                                        <button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#updateModal' onclick='updateBook(" . $row['id_kegiatan'] . ")'>Edit</button>
                                        <button type='button' class='btn btn-danger btn-sm' onclick='deleteBook(" . $row['id_kegiatan'] . ")'>Hapus</button>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No data found...</td></tr>";
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
            <form id="addKegiatanForm" action="add_kegiatan.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu" class="form-label">Waktu</label>
                        <input type="time" class="form-control" id="waktu" name="waktu" required>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateKegiatanForm" action="update_kegiatan.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Edit Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="update_id_kegiatan" name="id_kegiatan">
                    <div class="mb-3">
                        <label for="update_judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="update_judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="update_deskripsi" name="deskripsi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="update_foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="update_foto" name="foto">
                    </div>
                    <div class="mb-3">
                        <label for="update_tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="update_tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_waktu" class="form-label">Waktu</label>
                        <input type="time" class="form-control" id="update_waktu" name="waktu" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="update_lokasi" name="lokasi" required>
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteKegiatanForm" action="delete_kegiatan.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_id_kegiatan" name="id_kegiatan">
                    <p>Apakah Anda yakin ingin menghapus kegiatan ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
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
        $('#kegiatanTable').DataTable();
    });

    function updateBook(id) {
        $.ajax({
            url: 'get_kegiatan.php',
            type: 'GET',
            data: {
                id_kegiatan: id
            },
            success: function(response) {
                var kegiatan = JSON.parse(response);
                $('#update_id_kegiatan').val(kegiatan.id_kegiatan);
                $('#update_judul').val(kegiatan.judul);
                $('#update_deskripsi').val(kegiatan.deskripsi);
                $('#update_tanggal').val(kegiatan.tanggal);
                $('#update_waktu').val(kegiatan.waktu);
                $('#update_lokasi').val(kegiatan.lokasi);
                $('#updateModal').modal('show');
            }
        });
    }

    function deleteBook(id) {
        $('#delete_id_kegiatan').val(id);
        $('#deleteModal').modal('show');
    }
</script>