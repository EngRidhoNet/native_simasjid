<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_buku = mysqli_real_escape_string($conn, $_POST['id_buku']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $tahun_terbit = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);

    $query = "UPDATE buku SET judul='$judul', penulis='$penulis', tahun_terbit='$tahun_terbit', isbn='$isbn', diperbarui_pada=current_timestamp() WHERE id_buku='$id_buku'";

    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
