<?php
include('../../koneksi/koneksi.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_transaksi = $_POST['id_transaksi'];

    $query = "DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'";

    if (mysqli_query($conn, $query)) {
        header('Location: index.php?message=Transaksi berhasil dihapus');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
