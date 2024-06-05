<?php
include('../../koneksi/koneksi.php');

$id_pengguna = $_POST['id_pengguna'];
$id_kategori = $_POST['id_kategori'];
$type = $_POST['type'];
$tgl_transaksi = $_POST['tgl_transaksi'];
$nominal = $_POST['nominal'];
$keterangan = $_POST['keterangan'];

$query = "INSERT INTO transaksi (id_pengguna, id_kategori, type, tgl_transaksi, nominal, keterangan, dibuat_pada) 
          VALUES ('$id_pengguna', '$id_kategori', '$type', '$tgl_transaksi', '$nominal', '$keterangan', NOW())";

if (mysqli_query($conn, $query)) {
    echo json_encode(["message" => "Transaksi berhasil ditambahkan"]);
} else {
    echo json_encode(["message" => "Error: " . $query . "<br>" . mysqli_error($conn)]);
}

mysqli_close($conn);
