<?php
include('../../koneksi/koneksi.php');

$nama_kategori = $_POST['nama_kategori'];
$query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";
if (mysqli_query($conn, $query)) {
    echo 'success';
} else {
    echo 'error';
}

mysqli_close($conn);
