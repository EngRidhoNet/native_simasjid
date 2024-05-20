<?php
include('../../koneksi/koneksi.php');
session_start(); // Start the session to access logged-in user info

if (!isset($_SESSION['id_pengguna'])) {
    die('User not logged in.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            error_log('Error uploading file.');
            die('Error uploading file.');
        }
    } else {
        error_log('No file uploaded or upload error.');
    }

    $diunggah_oleh = $_SESSION['id_pengguna']; // Get the user ID from the session
    $query = "INSERT INTO galeri (judul_foto, path_file, diunggah_pada, diunggah_oleh) VALUES ('$judul_foto', '$path_file', NOW(), '$diunggah_oleh')";

    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
    } else {
        error_log('Database error: ' . mysqli_error($conn));
        die('Error: ' . mysqli_error($conn));
    }
}
