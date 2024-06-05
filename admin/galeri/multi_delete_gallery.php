<?php
include('../../koneksi/koneksi.php');

if (isset($_POST['ids'])) {
    $ids = $_POST['ids'];
    $id_list = implode(',', array_map('intval', $ids));

    $query = "DELETE FROM galeri WHERE id_galeri IN ($id_list)";
    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No IDs received"]);
}
mysqli_close($conn);
