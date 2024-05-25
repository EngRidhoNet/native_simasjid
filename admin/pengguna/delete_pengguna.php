<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pengguna = $_POST['id_pengguna'];

    $query = "DELETE FROM pengguna WHERE id_pengguna = '$id_pengguna'";

    if (mysqli_query($conn, $query)) {
        header('Location: index.php?message=Pengguna berhasil dihapus');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
