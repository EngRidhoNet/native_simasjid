<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_donasi = $_POST['id_donasi'];
    $id_pengguna = $_POST['id_pengguna'];
    $total_donasi = $_POST['total_donasi'];
    $tanggal = $_POST['tanggal'];

    // Update data donasi
    $updateQuery = "UPDATE donasi SET id_pengguna='$id_pengguna', total_donasi='$total_donasi', tanggal='$tanggal' WHERE id_donasi='$id_donasi'";
    if (mysqli_query($conn, $updateQuery)) {
        echo json_encode(['status' => 'success', 'message' => 'Donasi berhasil diubah']);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengubah donasi: ' . mysqli_error($conn)]);
    }
}
