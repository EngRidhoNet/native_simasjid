<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pengguna = $_POST['id_pengguna'];

    $query = "SELECT * FROM pengguna WHERE id_pengguna = '$id_pengguna'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $pengguna = mysqli_fetch_assoc($result);
        echo json_encode($pengguna);
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
