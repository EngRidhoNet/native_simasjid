<?php
include('../../koneksi/koneksi.php');

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT * FROM buku WHERE id_buku = '$id'";
$result = mysqli_query($conn, $query);

if ($result) {
    $data = mysqli_fetch_assoc($result);
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Data not found']);
}
