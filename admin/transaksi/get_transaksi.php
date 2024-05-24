<?php
include('../../koneksi/koneksi.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_transaksi = $_POST['id_transaksi'];

    $query = "SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $transaksi = mysqli_fetch_assoc($result);
        echo json_encode($transaksi);
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
