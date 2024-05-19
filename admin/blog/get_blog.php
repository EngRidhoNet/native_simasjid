<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id_blog = $_GET['id'];

    $sql = "SELECT blog.*, pengguna.nama_pengguna 
            FROM blog 
            JOIN pengguna ON blog.id_pengguna = pengguna.id_pengguna 
            WHERE blog.id_blog = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_blog);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $blog = $result->fetch_assoc();
        echo json_encode($blog);
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
