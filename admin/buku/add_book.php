<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $tahun_terbit = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);

    $query = "INSERT INTO buku (judul, penulis, tahun_terbit, isbn) VALUES ('$judul', '$penulis', '$tahun_terbit', '$isbn')";

    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
