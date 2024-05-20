<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_donasi = $_POST['id_donasi'];
    $query = "SELECT * FROM donasi WHERE id_donasi = '$id_donasi'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Gagal mengambil data: ' . mysqli_error($conn)]);
    }
}
