<?php
include 'koneksi/koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookId = $_POST['book_id'];
    $userId = $_POST['user_id'];
    $tanggalPinjam = date('Y-m-d');
    $tanggalKembali = date('Y-m-d', strtotime($tanggalPinjam . ' + 3 days'));

    $sql = "INSERT INTO pinjamanbuku (id_buku, id_pengguna, tanggal_pinjam, tanggal_kembali) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $bookId, $userId, $tanggalPinjam, $tanggalKembali);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: buku.php?status=success");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        $stmt->close();
        $conn->close();
    }
}
