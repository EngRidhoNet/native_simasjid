<?php
include('../../koneksi/koneksi.php');

$id_pinjaman = $_POST['id_pinjaman'];

$query = "DELETE FROM pinjamanbuku WHERE id_pinjaman='$id_pinjaman'";
if (mysqli_query($conn, $query)) {
    header('Location: index.php');
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
