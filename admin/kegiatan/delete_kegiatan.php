<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kegiatan = $_POST['id_kegiatan'];

    $query = "DELETE FROM kegiatan WHERE id_kegiatan='$id_kegiatan'";
    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
