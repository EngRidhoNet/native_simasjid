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

    .activity-item {
        margin-bottom: 30px;
    }

    .activity-item img {
        width: 100%;
        height: auto;
        display: block;
    }

    .activity-item .card-body {
        text-align: center;
    }

    .activity-item .card-body h5 {
        font-size: 1.5em;
        margin: 10px 0;
    }

    .activity-item .card-body p {
        margin: 5px 0;
        color: #555;
    }
</style>

<body>
    <?php
    include 'includes/navbar.php';

    // Fetch activities data from the database
    $query = "SELECT * FROM kegiatan ORDER BY tanggal DESC, waktu DESC";
    $result = mysqli_query($conn, $query);
    ?>

    <div class="content">
        <div class="container mt-5">
            <h2 class="mb-4">Kegiatan</h2>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div class="col-lg-4 col-md-6 activity-item">
                        <div class="card">
                            <img src=" admin/kegiatan/<?php echo $row['foto']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['judul']); ?>">
                            <div class="card-body">
                                <h5><?php echo htmlspecialchars($row['judul']); ?></h5>
                                <p><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                                <p><strong>Tanggal:</strong> <?php echo date('d M Y', strtotime($row['tanggal'])); ?></p>
                                <p><strong>Waktu:</strong> <?php echo date('H:i', strtotime($row['waktu'])); ?></p>
                                <p><strong>Lokasi:</strong> <?php echo htmlspecialchars($row['lokasi']); ?></p>
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