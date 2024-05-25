<?php
include('../../koneksi/koneksi.php');

$id_pinjaman = $_POST['id_pinjaman'];

$query = "SELECT * FROM pinjamanbuku WHERE id_pinjaman='$id_pinjaman'";
$result = mysqli_query($conn, $query);

$data = mysqli_fetch_assoc($result);

echo json_encode($data);

mysqli_close($conn);
