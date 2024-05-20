<?php
include('../../koneksi/koneksi.php');

$query = "SELECT id_kategori, nama_kategori FROM kategori";
$result = mysqli_query($conn, $query);

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
