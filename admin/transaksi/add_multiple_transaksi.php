<?php
include('../../koneksi/koneksi.php');

$id_pengguna = $_POST['id_pengguna'];
$id_kategori = $_POST['id_kategori'];
$type = $_POST['type'];
$tgl_transaksi = $_POST['tgl_transaksi'];
$nominal = $_POST['nominal'];
$keterangan = $_POST['keterangan'];

$values = [];

foreach ($id_pengguna as $index => $pengguna) {
    $values[] = "('$pengguna', '{$id_kategori[$index]}', '{$type[$index]}', '{$tgl_transaksi[$index]}', '{$nominal[$index]}', '{$keterangan[$index]}', NOW())";
}

$values_string = implode(',', $values);

$query = "INSERT INTO transaksi (id_pengguna, id_kategori, type, tgl_transaksi, nominal, keterangan, dibuat_pada) VALUES $values_string";

if (mysqli_query($conn, $query)) {
    echo json_encode(["message" => "Transaksi massal berhasil ditambahkan"]);
} else {
    echo json_encode(["message" => "Error: " . $query . "<br>" . mysqli_error($conn)]);
}

mysqli_close($conn);
