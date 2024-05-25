<?php
include('../../koneksi/koneksi.php');

$id_buku = $_POST['id_buku'];
$id_pengguna = $_POST['id_pengguna'];
$tanggal_pinjam = $_POST['tanggal_pinjam'];
$tanggal_kembali = $_POST['tanggal_kembali'];

$query = "INSERT INTO pinjamanbuku (id_buku, id_pengguna, tanggal_pinjam, tanggal_kembali) 
          VALUES ('$id_buku', '$id_pengguna', '$tanggal_pinjam', '$tanggal_kembali')";
if (mysqli_query($conn, $query)) {
    header('Location: index.php');
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
