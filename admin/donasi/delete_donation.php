<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_donasi = $_POST['id_donasi'];

    $query = "DELETE FROM donasi WHERE id_donasi = '$id_donasi'";
    if (mysqli_query($conn, $query)) {
        header('Location: index.php'); // Redirect to appropriate page
    } else {
        echo "Gagal menghapus donasi: " . mysqli_error($conn);
    }
}
