<?php
include 'includes/header.php';
include 'koneksi/koneksi.php';
?>
<style>
    /* Flexbox layout to ensure footer is at the bottom */
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
</style>

<body>
    <?php
    include 'includes/navbar.php';
    ?>

    <div class="container mt-5">
        <div class="row">
            <?php
            // Fetch the blog posts from the database
            $sql = "SELECT * FROM blog ORDER BY dibuat_pada DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img src="admin/blog/' . htmlspecialchars($row['foto']) . '" class="card-img-top" alt="' . htmlspecialchars($row['judul']) . '">
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($row['judul']) . '</h5>
                                <p class="card-text">' . substr(htmlspecialchars($row['isi']), 0, 100) . '...</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="view_blog.php?id=' . $row['id_blog'] . '" class="btn btn-sm btn-outline-secondary">View</a>
                                    </div>
                                    <small class="text-muted">' . date("F j, Y, g:i a", strtotime($row['dibuat_pada'])) . '</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                }
            } else {
                echo '<p>No blog posts found.</p>';
            }
            $conn->close();
            ?>
        </div>
    </div>

    <?php
    include 'includes/footer.php';
    ?>
</body>

</html>