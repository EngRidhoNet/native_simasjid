<?php
include 'includes/header.php';
include 'koneksi/koneksi.php';
?>

<style>
    /* Flexbox layout to ensure footer is at the bottom */
    html {
        position: relative;
        min-height: 100%;
    }

    body {
        margin: 0;
        padding-bottom: 100px;
        /* Height of the footer */
        display: flex;
        flex-direction: column;
    }

    .content {
        flex: 1;
    }

    .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 70px;
        /* Set the height of your footer */
        text-align: center;
        padding-top: 30px;
        /* Adjust as needed */
    }

    .gallery-item {
        margin-bottom: 30px;
    }

    .gallery-item img {
        width: 100%;
        height: auto;
        display: block;
    }

    .gallery-item .caption {
        text-align: center;
        margin-top: 10px;
    }

    .gallery-item .caption h5 {
        font-size: 1.2em;
        margin: 0;
    }

    .gallery-item .caption p {
        margin: 0;
        color: #777;
    }

    .download-btn {
        display: inline-block;
        margin-top: 10px;
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }

    .download-btn:hover {
        background-color: #0056b3;
    }
</style>

<body>
    <?php
    include 'includes/navbar.php';

    // Fetch gallery data from the database
    $query = "SELECT g.judul_foto, g.path_file, p.nama_pengguna, g.diunggah_pada 
              FROM galeri g 
              LEFT JOIN pengguna p ON g.diunggah_oleh = p.id_pengguna 
              ORDER BY g.diunggah_pada DESC";
    $result = mysqli_query($conn, $query);
    ?>

    <div class="content">
        <div class="container mt-5">
            <h2 class="mb-4">Gallery</h2>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div class="col-lg-4 col-md-6 gallery-item">
                        <div class="card">
                            <img src="admin/galeri/<?php echo $row['path_file']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['judul_foto']); ?>">
                            <div class="card-body">
                                <div class="caption">
                                    <h5><?php echo htmlspecialchars($row['judul_foto']); ?></h5>
                                    <p>Uploaded by <?php echo htmlspecialchars($row['nama_pengguna']); ?> on <?php echo date('d M Y', strtotime($row['diunggah_pada'])); ?></p>
                                    <a href="admin/galeri/<?php echo $row['path_file']; ?>" class="download-btn" download>Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <?php
    include 'includes/footer.php';
    ?>
</body>

</html>