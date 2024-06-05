<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judulArray = $_POST['judul'];
    $penulisArray = $_POST['penulis'];
    $tahunTerbitArray = $_POST['tahun_terbit'];
    $isbnArray = $_POST['isbn'];

    foreach ($judulArray as $index => $judul) {
        $penulis = mysqli_real_escape_string($conn, $penulisArray[$index]);
        $tahun_terbit = mysqli_real_escape_string($conn, $tahunTerbitArray[$index]);
        $isbn = mysqli_real_escape_string($conn, $isbnArray[$index]);

        $query = "INSERT INTO buku (judul, penulis, tahun_terbit, isbn) VALUES ('$judul', '$penulis', '$tahun_terbit', '$isbn')";

        if (!mysqli_query($conn, $query)) {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }

    header('Location: index.php');
}
