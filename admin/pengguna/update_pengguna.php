<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pengguna = $_POST['id_pengguna'];
    $nama_pengguna = $_POST['nama_pengguna'];
    $username = $_POST['username'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : '';
    $peran = $_POST['peran'];

    $query = "UPDATE pengguna SET 
              nama_pengguna = '$nama_pengguna', 
              username = '$username', 
              peran = '$peran', 
              diperbarui_pada = CURRENT_TIMESTAMP()";

    if (!empty($password)) {
        $query .= ", password = '$password'";
    }

    $query .= " WHERE id_pengguna = '$id_pengguna'";

    if (mysqli_query($conn, $query)) {
        header('Location: index.php?message=Pengguna berhasil diperbarui');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
