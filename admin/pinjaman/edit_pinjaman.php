<?php
include('../../koneksi/koneksi.php');

$id_pinjaman = $_POST['id_pinjaman'];
$id_buku = $_POST['id_buku'];
$id_pengguna = $_POST['id_pengguna'];
$tanggal_pinjam = $_POST['tanggal_pinjam'];
$tanggal_kembali = $_POST['tanggal_kembali'];

$query = "UPDATE pinjamanbuku 
          SET id_buku='$id_buku', id_pengguna='$id_pengguna', tanggal_pinjam='$tanggal_pinjam', tanggal_kembali='$tanggal_kembali'
          WHERE id_pinjaman='$id_pinjaman'";
if (mysqli_query($conn, $query)) {
    header('Location: index.php');
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
