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
                <h1 class="h2">Blog</h1>
                <button type="button" class="btn btn-primary" id="addBlogButton">Tambah Blog</button>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm" id="blogTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
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
                            $counter = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td><input type='checkbox' class='blogCheckbox' data-id='" . $row["id_blog"] . "'></td>
                                    <td>" . $counter . "</td>
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
                                $counter++;
                            }
                        } else {
                            echo "<tr><td colspan='9'>No blogs found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <button class='btn btn-sm btn-danger' id='deleteSelectedBlogsButton'>Delete Selected</button>
            </div>
        </main>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addBlogModal" tabindex="-1" aria-labelledby="addBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBlogModalLabel">Tambah Blog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBlogForm" enctype="multipart/form-data">
                    <div id="blogEntries">
                        <div class="blog-entry">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" name="judul[]" required>
                            </div>
                            <div class="mb-3">
                                <label for="isi" class="form-label">Isi</label>
                                <textarea class="form-control" name="isi[]" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" class="form-control" name="foto[]" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_pengguna" class="form-label">Penulis</label>
                                <select class="form-select" name="id_pengguna[]" required>
                                    <option value="" disabled selected>Pilih Penulis</option>
                                    <?php
                                    $sql = "SELECT id_pengguna, nama_pengguna FROM pengguna";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['id_pengguna'] . "'>" . $row['nama_pengguna'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="button" class="btn btn-danger removeBlogEntry">Remove</button>
                            <hr>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success" id="addBlogEntryButton">Add Another Blog</button>
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
                        <input type="file" class="form-control" id="edit_foto" name="foto">
                        <span id="edit_foto_info"></span>
                    </div>
                    <div class="mb-3">
                        <label for="edit_id_pengguna" class="form-label">Penulis</label>
                        <select class="form-select" id="edit_id_pengguna" name="id_pengguna" required>
                            <option value="" disabled selected>Pilih Penulis</option>
                            <?php
                            $sql = "SELECT id_pengguna, nama_pengguna FROM pengguna";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id_pengguna'] . "'>" . $row['nama_pengguna'] . "</option>";
                                }
                            }
                            ?>
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
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        $('#blogTable').DataTable();

        CKEDITOR.replace('isi');
        CKEDITOR.replace('edit_isi');

        // Add another blog entry
        $('#addBlogEntryButton').on('click', function() {
            var blogEntry = $('.blog-entry:first').clone();
            blogEntry.find('input').val('');
            blogEntry.find('textarea').val('');
            $('#blogEntries').append(blogEntry);
        });

        // Remove a blog entry
        $(document).on('click', '.removeBlogEntry', function() {
            if ($('.blog-entry').length > 1) {
                $(this).closest('.blog-entry').remove();
            }
        });

        $('#addBlogButton').on('click', function() {
            $('#addBlogModal').modal('show');
        });

        $('.editBlogButton').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'get_blog.php',
                type: 'GET',
                data: {
                    id_blog: id
                },
                success: function(response) {
                    var blog = JSON.parse(response);
                    $('#edit_id_blog').val(blog.id_blog);
                    $('#edit_judul').val(blog.judul);
                    CKEDITOR.instances.edit_isi.setData(blog.isi);
                    $('#edit_foto').val(blog.foto);
                    $('#edit_id_pengguna').val(blog.id_pengguna);
                    $('#editBlogModal').modal('show');
                }
            });
        });

        // Select all checkboxes
        $('#selectAll').on('click', function() {
            $('.blogCheckbox').prop('checked', this.checked);
        });

        $('.deleteBlogButton').on('click', function() {
            var id = $(this).data('id');
            $('#delete_id_blog').val(id);
            $('#deleteBlogModal').modal('show');
        });

        $('#deleteBlogForm').on('submit', function(e) {
            e.preventDefault();
            var id_blog = $('#delete_id_blog').val();
            $.ajax({
                url: 'delete_blog.php',
                type: 'POST',
                data: {
                    blog_ids: [id_blog] // Mengirimkan id_blog sebagai array
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        $('#deleteBlogModal').modal('hide');
                        location.reload();
                    } else {
                        alert(result.message);
                    }
                },
                error: function() {
                    alert('Failed to delete blog.');
                }
            });
        });

        $('#deleteSelectedBlogsButton').on('click', function() {
            var selectedBlogs = [];
            $('.blogCheckbox:checked').each(function() {
                selectedBlogs.push($(this).data('id'));
            });

            if (selectedBlogs.length > 0) {
                if (confirm('Are you sure you want to delete the selected blogs?')) {
                    $.ajax({
                        url: 'delete_blog.php',
                        type: 'POST',
                        data: {
                            blog_ids: selectedBlogs // Mengirimkan array id_blog
                        },
                        success: function(response) {
                            var result = JSON.parse(response);
                            if (result.status === 'success') {
                                location.reload();
                            } else {
                                alert(result.message);
                            }
                        },
                        error: function() {
                            alert('Failed to delete blogs.');
                        }
                    });
                }
            } else {
                alert('Please select at least one blog to delete.');
            }
        });

    });
</script>