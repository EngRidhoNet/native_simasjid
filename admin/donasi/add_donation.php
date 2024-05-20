<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pengguna = $_POST['id_pengguna'];
    $total_donasi = $_POST['total_donasi'];
    $tanggal = $_POST['tanggal'];

    // Masukkan data ke tabel donasi
    $insertQuery = "INSERT INTO donasi (id_pengguna, total_donasi, tanggal) VALUES ('$id_pengguna', '$total_donasi', '$tanggal')";
    if (mysqli_query($conn, $insertQuery)) {
        echo json_encode(['status' => 'success', 'message' => 'Donasi berhasil ditambahkan']);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Gagal menambah donasi: ' . mysqli_error($conn)]);
    }
}
