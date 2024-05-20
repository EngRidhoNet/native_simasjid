<?php
include('../../koneksi/koneksi.php');

$id_kategori = $_POST['kategori'];
$total_dana = $_POST['total_dana'];

$query = "INSERT INTO dana (id_kategori, total_dana) VALUES ('$id_kategori', '$total_dana')";
$result = mysqli_query($conn, $query);

if ($result) {
    // Jika query berhasil, lakukan reload halaman menggunakan JavaScript
    echo '<script>window.location.href = "index.php";</script>';
    exit();
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
