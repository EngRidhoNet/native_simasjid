<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../../koneksi/koneksi.php'); ?>

<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dana Masjid</h1>
                <button type="button" class="btn btn-primary" id="addBookButton" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data Dana</button>
            </div>
            <div class="table-responsive">
                <table id="danaTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID Dana</th>
                            <th>Kategori</th>
                            <th>Total Dana</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
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
            <form id="addForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Dana</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select id="kategori" name="kategori" class="form-select">
                            <!-- Options will be populated by JavaScript -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="total_dana" class="form-label">Total Dana</label>
                        <input type="text" class="form-control" id="total_dana" name="total_dana" required>
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

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Data Dana</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="update_id_dana" name="id_dana">
                    <div class="mb-3">
                        <label for="update_kategori" class="form-label">Kategori</label>
                        <select id="update_kategori" name="kategori" class="form-select">
                            <!-- Options will be populated by JavaScript -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="update_total_dana" class="form-label">Total Dana</label>
                        <input type="text" class="form-control" id="update_total_dana" name="total_dana" required>
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
            <form id="deleteForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Data Dana</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_id_dana" name="id_dana">
                    <p>Are you sure you want to delete this data?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#danaTable').DataTable({
            "ajax": {
                "url": "fetch_data.php",
                "dataSrc": "",
                "error": function(xhr, status, error) {
                    console.log("Error: " + error);
                }
            },
            "columns": [{
                    "data": "id_dana"
                },
                {
                    "data": "nama_kategori"
                },
                {
                    "data": "total_dana"
                },
                {
                    "data": null,
                    "defaultContent": '<button class="btn btn-warning btn-sm updateButton" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button> <button class="btn btn-danger btn-sm deleteButton" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>',
                    "orderable": false
                }
            ]
        });

        // Fetch categories for dropdown
        function fetchCategories(selectElement) {
            $.ajax({
                url: "fetch_categories.php",
                method: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data); // Debugging: log the received data
                    $(selectElement).empty(); // Clear existing options
                    $.each(data, function(key, value) {
                        $(selectElement).append('<option value="' + value.id_kategori + '">' + value.nama_kategori + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log("Error fetching categories: " + error);
                }
            });
        }

        fetchCategories('#kategori');
        fetchCategories('#update_kategori');

        // Handle Add Form Submission
        $('#addForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "add_data.php",
                method: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    $('#addModal').modal('hide');
                    table.ajax.reload();
                    location.reload(); // Refresh the page
                },
                error: function(xhr, status, error) {
                    console.log("Error adding data: " + error);
                }
            });
        });

        // Handle Update Button Click
        $('#danaTable tbody').on('click', '.updateButton', function() {
            var data = table.row($(this).parents('tr')).data();
            $('#update_id_dana').val(data.id_dana);
            $('#update_kategori').val(data.id_kategori);
            $('#update_total_dana').val(data.total_dana);
        });

        // Handle Update Form Submission
        $('#updateForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "update_data.php",
                method: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    $('#updateModal').modal('hide');
                    table.ajax.reload();
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log("Error updating data: " + error);
                }
            });
        });

        // Handle Delete Button Click
        $('#danaTable tbody').on('click', '.deleteButton', function() {
            var data = table.row($(this).parents('tr')).data();
            $('#delete_id_dana').val(data.id_dana);
        });

        // Handle Delete Form Submission
        $('#deleteForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "delete_data.php",
                method: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    $('#deleteModal').modal('hide');
                    table.ajax.reload();
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log("Error deleting data: " + error);
                }
            });
        });
    });
</script>