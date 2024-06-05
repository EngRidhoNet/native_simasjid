<?php
include('../../koneksi/koneksi.php');
session_start(); // Start the session to access logged-in user info

if (!isset($_SESSION['id_pengguna'])) {
    die('User not logged in.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul_fotos = $_POST['judul_foto'];
    $path_files = $_FILES['path_file'];
    $diunggah_oleh = $_SESSION['id_pengguna']; // Get the user ID from the session

    $upload_dir = 'foto/';
    $errors = [];

    for ($i = 0; $i < count($judul_fotos); $i++) {
        $judul_foto = mysqli_real_escape_string($conn, $judul_fotos[$i]);
        $file_tmp = $path_files['tmp_name'][$i];
        $file_name = $path_files['name'][$i];
        $file_error = $path_files['error'][$i];

        if ($file_error === UPLOAD_ERR_OK) {
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $shortened_name = substr(md5(time() . $i), 0, 10) . '.' . $extension;
            $uploaded_file = $upload_dir . $shortened_name;

            if (move_uploaded_file($file_tmp, $uploaded_file)) {
                $path_file = $uploaded_file;

                $query = "INSERT INTO galeri (judul_foto, path_file, diunggah_pada, diunggah_oleh) VALUES (?, ?, NOW(), ?)";
                if ($stmt = mysqli_prepare($conn, $query)) {
                    mysqli_stmt_bind_param($stmt, "ssi", $judul_foto, $path_file, $diunggah_oleh);
                    if (!mysqli_stmt_execute($stmt)) {
                        $errors[] = "Gagal mengunggah $file_name: " . mysqli_stmt_error($stmt);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $errors[] = "Gagal menyiapkan pernyataan untuk $file_name: " . mysqli_error($conn);
                }
            } else {
                $errors[] = "Gagal memindahkan file $file_name.";
            }
        } else {
            $errors[] = "Upload error untuk file $file_name.";
        }
    }

    if (empty($errors)) {
        header('Location: index.php'); // Ganti dengan lokasi yang sesuai
        exit;
    } else {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}

mysqli_close($conn);
