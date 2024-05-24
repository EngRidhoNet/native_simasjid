<?php
include('../../koneksi/koneksi.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kategori = $_POST['id_kategori'];
    $id_pengguna = $_POST['id_pengguna'];
    $type = $_POST['type'];
    $tgl_transaksi = $_POST['tgl_transaksi'];
    $nominal = $_POST['nominal'];
    $keterangan = $_POST['keterangan'];

    $query = "INSERT INTO transaksi (id_kategori, id_pengguna, type, tgl_transaksi, nominal, keterangan, dibuat_pada, diperbarui_pada)
              VALUES ('$id_kategori', '$id_pengguna', '$type', '$tgl_transaksi', '$nominal', '$keterangan', CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())";

    if (mysqli_query($conn, $query)) {
        header('Location: index.php?message=Transaksi berhasil ditambahkan');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
