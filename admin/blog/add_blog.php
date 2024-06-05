<?php
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judulArray = $_POST['judul'];
    $isiArray = $_POST['isi'];
    $id_penggunaArray = $_POST['id_pengguna'];
    $fotoArray = $_FILES['foto'];

    $target_dir = "foto/";

    $errors = [];

    for ($i = 0; $i < count($judulArray); $i++) {
        $judul = $judulArray[$i];
        $isi = $isiArray[$i];
        $id_pengguna = $id_penggunaArray[$i];

        $file_name = $fotoArray['name'][$i];
        $file_tmp = $fotoArray['tmp_name'][$i];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $new_file_name = uniqid() . '.' . $file_extension; // Generate unique filename
        $target_file = $target_dir . $new_file_name;
        $uploadOk = 1;

        // Check if image file is an actual image or fake image
        $check = getimagesize($file_tmp);
        if ($check === false) {
            $errors[] = "File $file_name is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($fotoArray['size'][$i] > 2000000) { // 2 mb limit
            $errors[] = "Sorry, your file $file_name is too large.";
            $uploadOk = 0;
        }

        // Allow only certain file formats
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($file_extension, $allowed_extensions)) {
            $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed. $file_name is not allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            continue; // Skip this file
        }

        // Attempt to move the uploaded file to the specified directory
        if (move_uploaded_file($file_tmp, $target_file)) {
            $foto = "foto/" . $new_file_name;

            // Prepare SQL and bind parameters
            $sql = "INSERT INTO blog (judul, isi, foto, id_pengguna) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssi', $judul, $isi, $foto, $id_pengguna);

            if (!$stmt->execute()) {
                $errors[] = "Error inserting blog $judul: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $errors[] = "Sorry, there was an error uploading your file $file_name.";
        }
    }

    $conn->close();

    if (empty($errors)) {
        echo 'success';
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
