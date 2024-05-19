<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_blog = $_POST['id_blog'];

    $sql = "DELETE FROM blog WHERE id_blog = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_blog);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
