<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pengguna = $_POST['nama_pengguna'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $peran = $_POST['peran'];

    $query = "INSERT INTO pengguna (nama_pengguna, username, password, peran, dibuat_pada, diperbarui_pada)
              VALUES ('$nama_pengguna', '$username', '$password', '$peran', CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())";

    if (mysqli_query($conn, $query)) {
        header('Location: index.php?message=Pengguna berhasil ditambahkan');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
