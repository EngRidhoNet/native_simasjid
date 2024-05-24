<?php
include('../../koneksi/koneksi.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_transaksi = $_POST['id_transaksi'];
    $id_kategori = $_POST['id_kategori'];
    $type = $_POST['type'];
    $tgl_transaksi = $_POST['tgl_transaksi'];
    $nominal = $_POST['nominal'];
    $keterangan = $_POST['keterangan'];

    $query = "UPDATE transaksi 
              SET id_kategori = '$id_kategori', type = '$type', tgl_transaksi = '$tgl_transaksi', nominal = '$nominal', keterangan = '$keterangan', diperbarui_pada = CURRENT_TIMESTAMP() 
              WHERE id_transaksi = '$id_transaksi'";

    if (mysqli_query($conn, $query)) {
        header('Location: index.php?message=Transaksi berhasil diperbarui');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
