<?php
include 'includes/header.php';
include 'koneksi/koneksi.php';

$id_pengguna = $_SESSION['id_pengguna'];
?>

<style>
    /* Flexbox layout to ensure footer is at the bottom */
    html {
        position: relative;
        min-height: 100%;
    }

    body {
        margin: 0;
        padding-bottom: 100px;
        /* Height of the footer */
        display: flex;
        flex-direction: column;
    }

    .content {
        flex: 1;
    }

    .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 70px;
        /* Set the height of your footer */
        text-align: center;
        padding-top: 30px;
        /* Adjust as needed */
    }
</style>

<body>
    <?php
    include 'includes/navbar.php';
    ?>

    <div class="content">
        <div class="container mt-5">
            <?php if (isset($_GET['status']) && $_GET['status'] == 'success') : ?>
                <div class="alert alert-success" role="alert">
                    Buku berhasil dipinjam.
                </div>
            <?php endif; ?>
            <ul class="nav nav-tabs">
                <li class="nav-item"></li>
                <a class="nav-link active" href="buku.php">Daftar Buku</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pinjaman.php">Daftar Pinjaman Buku</a>
                </li>
            </ul>
            </li>
            <table id="bookTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Year of Publication</th>
                        <th>ISBN</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch book data from the database
                    $sql = "SELECT * FROM buku";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row["judul"] . "</td>
                                <td>" . $row["penulis"] . "</td>
                                <td>" . $row["tahun_terbit"] . "</td>
                                <td>" . $row["isbn"] . "</td>
                                <td><button class='btn btn-primary borrow-btn' data-book-id='" . $row["id_buku"] . "'>Pinjam</button></td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No books found.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Hidden form to borrow a book -->
    <form id="borrowForm" method="POST" action="borrow_book.php" style="display: none;">
        <input type="hidden" name="book_id" id="book_id">
        <input type="hidden" name="user_id" id="user_id" value="<?php echo $id_pengguna; ?>"> <!-- Assuming a logged-in user with ID 1 -->
    </form>

    <?php
    include 'includes/footer.php';
    ?>

    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Include DataTables CSS and JavaScript -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#bookTable').DataTable();
        });

        // Action to borrow a book
        $(document).on('click', '.borrow-btn', function() {
            var bookId = $(this).data('book-id');
            $('#book_id').val(bookId);
            $('#borrowForm').submit();
        });
    </script>
</body>

</html>