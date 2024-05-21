<?php
include('../../koneksi/koneksi.php');

$id_kategori = $_GET['id_kategori'];
$query = "SELECT * FROM kategori WHERE id_kategori = $id_kategori";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

echo json_encode($row);

mysqli_close($conn);
