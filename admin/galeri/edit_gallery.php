<?php
include('../../koneksi/koneksi.php');
session_start(); // Start the session to access logged-in user info

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_galeri = mysqli_real_escape_string($conn, $_POST['id_galeri']);
    $judul_foto = mysqli_real_escape_string($conn, $_POST['judul_foto']);
    $path_file = '';

    if (isset($_FILES['path_file']) && $_FILES['path_file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'foto/';
        $extension = pathinfo($_FILES['path_file']['name'], PATHINFO_EXTENSION);
        $shortened_name = substr(md5(time()), 0, 10) . '.' . $extension;
        $uploaded_file = $upload_dir . $shortened_name;

        if (move_uploaded_file($_FILES['path_file']['tmp_name'], $uploaded_file)) {
            $path_file = 'foto/' . $shortened_name;
        } else {
            die('Error uploading file.');
        }
    }

    $query = "UPDATE galeri SET judul_foto='$judul_foto'";
    if ($path_file) {
        $query .= ", path_file='$path_file'";
    }
    $query .= " WHERE id_galeri='$id_galeri'";

    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
    } else {
        die('Error: ' . mysqli_error($conn));
    }
}
