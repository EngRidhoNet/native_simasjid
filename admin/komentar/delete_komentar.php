<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_komentar = $_POST['id_komentar'];

    $query = "DELETE FROM komentarblog WHERE id_komentar='$id_komentar'";

    if (mysqli_query($conn, $query)) {
        header('Location: index.php'); // Adjust the redirection URL as needed
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
