<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kegiatan = $_POST['id_kegiatan'];
    $ids = explode(',', $id_kegiatan);

    foreach ($ids as $id) {
        $query = "DELETE FROM kegiatan WHERE id_kegiatan='$id'";
        if (!mysqli_query($conn, $query)) {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
            exit;
        }
    }
    header('Location: index.php');
}

mysqli_close($conn);
