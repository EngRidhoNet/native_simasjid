<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_blog = $_POST['id_blog'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $foto = $_POST['foto'];
    $id_pengguna = $_POST['id_pengguna'];

    $sql = "UPDATE blog SET judul = ?, isi = ?, foto = ?, id_pengguna = ? WHERE id_blog = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssii', $judul, $isi, $foto, $id_pengguna, $id_blog);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
