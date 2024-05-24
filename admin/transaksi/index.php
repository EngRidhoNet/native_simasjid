<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../../koneksi/koneksi.php'); ?>

<?php
$id_pengguna = $_SESSION['id_pengguna']; // Ensure session is started and id_pengguna is set when user logs in

// Fetch categories for dropdown
$kategori_query = "SELECT id_kategori, nama_kategori FROM kategori";
$kategori_result = mysqli_query($conn, $kategori_query);
?>

<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Transaksi</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransaksiModal">
                    Tambah Transaksi
                </button>
            </div>
            <div class="table-responsive">
                <table id="transaksiTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Pengguna</th>
                            <th>Type</th>
                            <th>Tanggal Transaksi</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Dibuat Pada</th>
                            <th>Diperbarui Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT t.*, k.nama_kategori, p.username FROM transaksi t
                                  JOIN kategori k ON t.id_kategori = k.id_kategori
                                  JOIN pengguna p ON t.id_pengguna = p.id_pengguna";
                        $result = mysqli_query($conn, $query);
                        $no = 1;

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $row['nama_kategori'] . "</td>";
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['type'] . "</td>";
                            echo "<td>" . $row['tgl_transaksi'] . "</td>";
                            echo "<td>" . $row['nominal'] . "</td>";
                            echo "<td>" . $row['keterangan'] . "</td>";
                            echo "<td>" . $row['dibuat_pada'] . "</td>";
                            echo "<td>" . $row['diperbarui_pada'] . "</td>";
                            echo "<td>
                                    <button class='btn btn-primary btn-edit' data-id='" . $row['id_transaksi'] . "'>Edit</button>
                                    <button class='btn btn-danger btn-delete' data-id='" . $row['id_transaksi'] . "'>Delete</button>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<!-- Add Transaksi Modal -->
<div class="modal fade" id="addTransaksiModal" tabindex="-1" aria-labelledby="addTransaksiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="add_transaksi.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTransaksiModalLabel">Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" name="id_kategori" required>
                            <?php while ($kategori = mysqli_fetch_assoc($kategori_result)) { ?>
                                <option value="<?php echo $kategori['id_kategori']; ?>"><?php echo $kategori['nama_kategori']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" name="id_pengguna" value="<?php echo $id_pengguna; ?>">
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" name="type" required>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_transaksi" class="form-label">Tanggal Transaksi</label>
                        <input type="date" class="form-control" name="tgl_transaksi" required>
                    </div>
                    <div class="mb-3">
                        <label for="nominal" class="form-label">Nominal</label>
                        <input type="number" class="form-control" name="nominal" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan"></textarea>
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

<!-- Update Transaksi Modal -->
<div class="modal fade" id="editTransaksiModal" tabindex="-1" aria-labelledby="editTransaksiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editTransaksiForm" action="update_transaksi.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTransaksiModalLabel">Edit Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_transaksi" id="edit-id-transaksi">
                    <div class="mb-3">
                        <label for="edit-kategori" class="form-label">Kategori</label>
                        <select class="form-select" name="id_kategori" id="edit-kategori" required>
                            <?php
                            // Re-fetch categories for edit dropdown
                            $kategori_result_edit = mysqli_query($conn, $kategori_query);
                            while ($kategori = mysqli_fetch_assoc($kategori_result_edit)) { ?>
                                <option value="<?php echo $kategori['id_kategori']; ?>"><?php echo $kategori['nama_kategori']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-type" class="form-label">Type</label>
                        <select class="form-select" name="type" id="edit-type" required>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-tgl_transaksi" class="form-label">Tanggal Transaksi</label>
                        <input type="date" class="form-control" name="tgl_transaksi" id="edit-tgl_transaksi" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-nominal" class="form-label">Nominal</label>
                        <input type="number" class="form-control" name="nominal" id="edit-nominal" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="edit-keterangan"></textarea>
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

<!-- Delete Transaksi Modal -->
<div class="modal fade" id="deleteTransaksiModal" tabindex="-1" aria-labelledby="deleteTransaksiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteTransaksiForm" action="delete_transaksi.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTransaksiModalLabel">Hapus Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_transaksi" id="delete-id-transaksi">
                    <p>Apakah Anda yakin ingin menghapus transaksi ini?</p>
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
        $('#transaksiTable').DataTable();

        $('.btn-edit').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'get_transaksi.php',
                type: 'POST',
                data: {
                    id_transaksi: id
                },
                success: function(data) {
                    var transaksi = JSON.parse(data);
                    $('#edit-id-transaksi').val(transaksi.id_transaksi);
                    $('#edit-kategori').val(transaksi.id_kategori);
                    $('#edit-type').val(transaksi.type);
                    $('#edit-tgl_transaksi').val(transaksi.tgl_transaksi);
                    $('#edit-nominal').val(transaksi.nominal);
                    $('#edit-keterangan').val(transaksi.keterangan);
                    $('#editTransaksiModal').modal('show');
                }
            });
        });

        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            $('#delete-id-transaksi').val(id);
            $('#deleteTransaksiModal').modal('show');
        });
    });
</script>