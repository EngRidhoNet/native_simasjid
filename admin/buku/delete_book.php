<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_buku = mysqli_real_escape_string($conn, $_POST['id_buku']);

    $query = "DELETE FROM buku WHERE id_buku = '$id_buku'";

    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
