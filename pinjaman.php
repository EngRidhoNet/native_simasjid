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
                
            </table>
        </div>
    </div>

 

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
    </script>
</body>

</html>