<?php
include('../../koneksi/koneksi.php');
session_start(); // Start the session to access logged-in user info

if (isset($_GET['id'])) {
    $id_galeri = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM galeri WHERE id_galeri='$id_galeri'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Gagal mengambil data: ' . mysqli_error($conn)]);
    }
}
