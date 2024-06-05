<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $lokasi = $_POST['lokasi'];
    $foto = $_FILES['foto'];

    for ($i = 0; $i < count($judul); $i++) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($foto['name'][$i]);
        move_uploaded_file($foto['tmp_name'][$i], $target_file);

        $query = "INSERT INTO kegiatan (judul, deskripsi, foto, tanggal, waktu, lokasi) VALUES ('{$judul[$i]}', '{$deskripsi[$i]}', '{$target_file}', '{$tanggal[$i]}', '{$waktu[$i]}', '{$lokasi[$i]}')";
        if (!mysqli_query($conn, $query)) {
               echo "Error: " . $query . "<br>" . mysqli_error($conn);
               exit;
           }
       }
       header('Location: index.php');
   }

   mysqli_close($conn);

