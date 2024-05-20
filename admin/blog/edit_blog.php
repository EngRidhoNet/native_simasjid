<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_blog = $_POST['id_blog'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $id_pengguna = $_POST['id_pengguna'];
    $foto = $_POST['foto_old']; // default to the old photo

    // Check if a new file has been uploaded
    if (!empty($_FILES["foto"]["name"])) {
        // Handle file upload
        $target_dir = "foto/";
        $file_name = $_FILES["foto"]["name"];
        $file_tmp = $_FILES["foto"]["tmp_name"];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $new_file_name = uniqid() . '.' . $file_extension; // Generate unique filename
        $target_file = $target_dir . $new_file_name;
        $uploadOk = 1;

        // Check if image file is an actual image or fake image
        $check = getimagesize($file_tmp);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["foto"]["size"] > 2000000) { // 2 mb limit
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow only certain file formats
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($file_extension, $allowed_extensions)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Attempt to move the uploaded file to the specified directory
            if (move_uploaded_file($file_tmp, $target_file)) {
                $foto = "foto/" . $new_file_name;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Prepare SQL and bind parameters
    $sql = "UPDATE blog SET judul = ?, isi = ?, foto = ?, id_pengguna = ? WHERE id_blog = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssii', $judul, $isi, $foto, $id_pengguna, $id_blog);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
