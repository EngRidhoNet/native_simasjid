<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../../koneksi/koneksi.php'); ?>

<style>
    textarea.form-control {
        height: 200px;
        /* You can adjust the height as needed */
    }
</style>

<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Blog</h1>
                <button type="button" class="btn btn-primary" id="addBlogButton">Tambah Blog</button>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm" id="blogTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Isi</th>
                            <th>Foto</th>
                            <th>Penulis</th>
                            <th>Dibuat Pada</th>
                            <th>Diperbarui Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT blog.id_blog, blog.judul, blog.isi, blog.foto, pengguna.nama_pengguna, blog.dibuat_pada, blog.diperbarui_pada 
                    FROM blog 
                    JOIN pengguna ON blog.id_pengguna = pengguna.id_pengguna";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $counter = 1; // Initialize the counter
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                        <td>" . $counter . "</td> <!-- Use the counter for the ID column -->
                        <td>" . $row["judul"] . "</td>
                        <td>" . substr($row["isi"], 0, 50) . "...</td>
                        <td><img src='" . $row["foto"] . "' alt='Foto' style='width: 100px; height: auto;'></td>
                        <td>" . $row["nama_pengguna"] . "</td>
                        <td>" . $row["dibuat_pada"] . "</td>
                        <td>" . $row["diperbarui_pada"] . "</td>
                        <td>
                            <button class='btn btn-sm btn-warning editBlogButton' data-id='" . $row["id_blog"] . "'>Edit</button>
                            <button class='btn btn-sm btn-danger deleteBlogButton' data-id='" . $row["id_blog"] . "'>Delete</button>
                        </td>
                    </tr>";
                                $counter++; // Increment the counter
                            }
                        } else {
                            echo "<tr><td colspan='8'>No blogs found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>


        </main>
    </div>
</div>

<!-- untuk memanggil nama pengguna -->
<?php
$sql = "SELECT id_pengguna, nama_pengguna FROM pengguna";
$result = $conn->query($sql);
$users = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
?>

<!-- Add Blog Modal -->
<div class="modal fade" id="addBlogModal" tabindex="-1" aria-labelledby="addBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBlogModalLabel">Tambah Blog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBlogForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="isi" class="form-label">Isi</label>
                        <textarea class="form-control" id="isi" name="isi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_pengguna" class="form-label">Penulis</label>
                        <select class="form-select" id="id_pengguna" name="id_pengguna" required>
                            <option value="" disabled selected>Pilih Penulis</option>
                            <?php foreach ($users as $user) : ?>
                                <option value="<?php echo $user['id_pengguna']; ?>">
                                    <?php echo $user['nama_pengguna']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Blog Modal -->
<div class="modal fade" id="editBlogModal" tabindex="-1" aria-labelledby="editBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBlogModalLabel">Edit Blog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBlogForm" enctype="multipart/form-data">
                    <input type="hidden" id="edit_id_blog" name="id_blog">
                    <div class="mb-3">
                        <label for="edit_judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="edit_judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_isi" class="form-label">Isi</label>
                        <textarea class="form-control" id="edit_isi" name="isi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="edit_foto" name="foto" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_pengguna" class="form-label">Penulis</label>
                        <select class="form-select" id="id_pengguna" name="id_pengguna" required>
                            <option value="" disabled selected>Pilih Penulis</option>
                            <?php foreach ($users as $user) : ?>
                                <option value="<?php echo $user['id_pengguna']; ?>">
                                    <?php echo $user['nama_pengguna']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Blog Modal -->
<div class="modal fade" id="deleteBlogModal" tabindex="-1" aria-labelledby="deleteBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBlogModalLabel">Delete Blog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this blog?</p>
                <form id="deleteBlogForm">
                    <input type="hidden" id="delete_id_blog" name="id_blog">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<script>
    $(document).ready(function() {
        // Initialize CKEditor for Add Blog Modal
        CKEDITOR.replace('isi');

        $('#addBlogButton').on('click', function() {
            $('#addBlogModal').modal('show');
        });

        $('#addBlogForm').on('submit', function(e) {
            e.preventDefault();
            for (instance in CKEDITOR.instances)
                CKEDITOR.instances[instance].updateElement();
            var formData = new FormData(this);
            $.ajax({
                url: 'add_blog.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#addBlogModal').modal('hide');
                    location.reload();
                }
            });
        });

        $('.editBlogButton').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'get_blog.php',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    var blog = JSON.parse(response);
                    $('#edit_id_blog').val(blog.id_blog);
                    $('#edit_judul').val(blog.judul);

                    // Set the value of the combobox to the selected nama_pengguna
                    $('#id_pengguna').val(blog.nama_pengguna);

                    // Check if CKEditor instance already exists and destroy it before creating a new one
                    if (CKEDITOR.instances['edit_isi']) {
                        CKEDITOR.instances['edit_isi'].destroy(true);
                    }

                    // Initialize the CKEditor instance for the edit_isi textarea
                    CKEDITOR.replace('edit_isi');
                    CKEDITOR.instances['edit_isi'].setData(blog.isi);

                    // Handle file input - Note: You can't set the file input value programmatically for security reasons.
                    // Instead, you can provide a way to inform the user that the existing file will remain unchanged unless they select a new file.
                    $('#edit_foto_info').text(blog.foto ? `Current file: ${blog.foto}` : 'No file uploaded');

                    $('#editBlogModal').modal('show');
                }
            });
        });

        $('#editBlogForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: 'edit_blog.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editBlogModal').modal('hide');
                    location.reload();
                }
            });
        });

        $('.deleteBlogButton').on('click', function() {
            var id = $(this).data('id');
            $('#delete_id_blog').val(id);
            $('#deleteBlogModal').modal('show');
        });

        $('#deleteBlogForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'delete_blog.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#deleteBlogModal').modal('hide');
                    location.reload();
                }
            });
        });

        feather.replace({
            'aria-hidden': 'true'
        });
    });
</script>