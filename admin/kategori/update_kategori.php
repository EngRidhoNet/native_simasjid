<?php
include('../../koneksi/koneksi.php');

$id_kategori = $_POST['id_kategori'];
$nama_kategori = $_POST['nama_kategori'];

$query = "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id_kategori = $id_kategori";
if (mysqli_query($conn, $query)) {
    echo 'success';
} else {
    echo 'error';
}

mysqli_close($conn);
