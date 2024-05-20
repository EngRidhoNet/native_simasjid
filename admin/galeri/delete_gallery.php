<?php
include('../../koneksi/koneksi.php');
session_start(); // Start the session to access logged-in user info

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_galeri = mysqli_real_escape_string($conn, $_POST['id_galeri']);

    // Optionally, delete the file from the server
    $query = "SELECT path_file FROM galeri WHERE id_galeri='$id_galeri'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $data = mysqli_fetch_assoc($result);
        $file_path = 'foto/' . $data['path_file'];
        if (file_exists($file_path)) {
            unlink($file_path); // Delete the file
        }
    }

    $query = "DELETE FROM galeri WHERE id_galeri='$id_galeri'";

    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
    } else {
        die('Error: ' . mysqli_error($conn));
    }
}
