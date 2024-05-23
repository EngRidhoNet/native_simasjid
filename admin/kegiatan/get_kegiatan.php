<?php
include('../../koneksi/koneksi.php');

if (isset($_GET['id_kegiatan'])) {
    $id_kegiatan = $_GET['id_kegiatan'];

    $query = "SELECT * FROM kegiatan WHERE id_kegiatan='$id_kegiatan'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }
}

mysqli_close($conn);
