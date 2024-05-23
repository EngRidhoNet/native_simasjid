<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kegiatan = $_POST['id_kegiatan'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $lokasi = $_POST['lokasi'];

    // Handle file upload if a new file is provided
    if (!empty($_FILES["foto"]["name"])) {
        $target_dir = "uploads/";
        $file_extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
        $target_file = $target_dir . uniqid() . '.' . $file_extension;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
        $foto = $target_file;

        $query = "UPDATE kegiatan SET judul='$judul', deskripsi='$deskripsi', foto='$foto', tanggal='$tanggal', waktu='$waktu', lokasi='$lokasi' WHERE id_kegiatan='$id_kegiatan'";
    } else {
        $query = "UPDATE kegiatan SET judul='$judul', deskripsi='$deskripsi', tanggal='$tanggal', waktu='$waktu', lokasi='$lokasi' WHERE id_kegiatan='$id_kegiatan'";
    }

    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
