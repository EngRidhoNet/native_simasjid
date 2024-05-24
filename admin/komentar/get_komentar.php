<?php
include('../../koneksi/koneksi.php');

if (isset($_GET['id'])) {
    $id_komentar = $_GET['id'];

    $query = "SELECT isi_komentar FROM komentarblog WHERE id_komentar='$id_komentar'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No comment found']);
    }
}
