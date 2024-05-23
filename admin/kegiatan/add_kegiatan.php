<?php

include('../../koneksi/koneksi.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kegiatan = $_POST['id_kegiatan'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $lokasi = $_POST['lokasi'];

    // Handle file uplaod
    $target_dir = "foto/";
    $file_extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $target_file = $target_dir . uniqid() . '.' . $file_extension;
    move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);

    $foto = $target_file;

    $sql = "INSERT INTO kegiatan (id_kegiatan, judul, deskripsi, tanggal, waktu, lokasi, foto)
            VALUES ('$id_kegiatan', '$judul', '$deskripsi', '$tanggal', '$waktu', '$lokasi', '$foto')"; 
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
}