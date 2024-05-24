<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_komentar = $_POST['id_komentar'];
    $isi_komentar = $_POST['isi_komentar'];

    $query = "UPDATE komentarblog SET isi_komentar='$isi_komentar', diperbarui_pada=NOW() WHERE id_komentar='$id_komentar'";

    if (mysqli_query($conn, $query)) {
        header('Location: index.php'); // Adjust the redirection URL as needed
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
