<?php
include('../../koneksi/koneksi.php');

// Periksa apakah permintaan POST memiliki parameter blog_ids
if (isset($_POST['blog_ids'])) {
    // Ambil ID blog dari permintaan POST
    $blog_ids = $_POST['blog_ids'];

    // Buat query SQL untuk menghapus blog berdasarkan ID
    $sql = "DELETE FROM blog WHERE id_blog IN (" . implode(',', array_fill(0, count($blog_ids), '?')) . ")";

    // Siapkan statement
    $stmt = $conn->prepare($sql);

    // Bind parameter
    $stmt->bind_param(str_repeat('i', count($blog_ids)), ...$blog_ids);

    // Eksekusi statement
    if ($stmt->execute()) {
        // Jika berhasil, kirim respons sukses
        echo json_encode(['status' => 'success', 'message' => 'Blog berhasil dihapus.']);
    } else {
        // Jika gagal, kirim respons gagal
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus blog.']);
    }

    // Tutup statement
    $stmt->close();
} else {
    // Jika tidak ada parameter blog_ids, kirim respons gagal
    echo json_encode(['status' => 'error', 'message' => 'ID blog tidak ditemukan.']);
}

// Tutup koneksi
$conn->close();
