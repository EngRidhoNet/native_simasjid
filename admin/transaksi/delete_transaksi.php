<?php
include('../../koneksi/koneksi.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_transaksi = $_POST['id_transaksi'];

    if (is_array($id_transaksi)) {
        // Multi delete
        $ids = implode(',', $id_transaksi);
        $query = "DELETE FROM transaksi WHERE id_transaksi IN ($ids)";
    } else {
        // Single delete
        $query = "DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'";
    }

    if (mysqli_query($conn, $query)) {
        echo json_encode(['message' => 'Transactions successfully deleted']);
    } else {
        echo json_encode(['message' => 'Error: ' . $query . '<br>' . mysqli_error($conn)]);
    }
}
