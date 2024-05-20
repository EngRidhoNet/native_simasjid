<?php
include '../../koneksi/koneksi.php';
$query = "SELECT d.id_dana, k.nama_kategori, d.total_dana 
          FROM dana d
          LEFT JOIN kategori k ON d.id_kategori = k.id_kategori";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit;
}

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
