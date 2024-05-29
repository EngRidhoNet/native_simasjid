<?php
include 'includes/header.php';
include 'koneksi/koneksi.php';

// Check if id is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch the blog post from the database
    $sql = "SELECT * FROM blog WHERE id_blog = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the blog post exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo '<p>Blog post not found.</p>';
        exit;
    }
} else {
    echo '<p>No blog post ID specified.</p>';
    exit;
}

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    // Ensure the user is logged in
    if (isset($_SESSION['id_pengguna'])) {
        $id_pengguna = $_SESSION['id_pengguna'];
        $comment = htmlspecialchars($_POST['comment']);

        $sql = "INSERT INTO komentarblog (id_blog, id_pengguna, isi_komentar) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $id, $id_pengguna, $comment);
        if ($stmt->execute()) {
            echo '<p class="alert alert-success">Comment added successfully!</p>';
        } else {
            echo '<p class="alert alert-danger">Failed to add comment.</p>';
        }
    } else {
        echo '<p class="alert alert-danger">You must be logged in to comment.</p>';
    }
}

// Fetch comments for the blog post
$sql = "
    SELECT komentarblog.*, pengguna.nama_pengguna
    FROM komentarblog
    JOIN pengguna ON komentarblog.id_pengguna = pengguna.id_pengguna
    WHERE komentarblog.id_blog = ?
    ORDER BY komentarblog.dibuat_pada DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$comments = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row['judul']); ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
            overflow-y: scroll;
        }

        .footer {
            width: 100%;
            height: 70px;
            text-align: center;
            padding-top: 30px;
            background: #343a40;
            color: white;
        }
    </style>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container mt-5 content">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card mb-4">
                    <img src="admin/blog/<?php echo htmlspecialchars($row['foto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['judul']); ?>">
                    <div class="card-body">
                        <h1 class="card-title"><?php echo htmlspecialchars($row['judul']); ?></h1>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($row['isi'])); ?></p>
                        <p class="text-muted"><?php echo date("F j, Y, g:i a", strtotime($row['dibuat_pada'])); ?></p>
                        <a href="index.php" class="btn btn-primary">Back to Blog List</a>
                    </div>
                </div>

                <div class="comments-section mt-5">
                    <h3>Comments</h3>
                    <?php if (isset($_SESSION['id_pengguna'])) : ?>
                        <form action="view_blog.php?id=<?php echo $id; ?>" method="POST" class="mb-4">
                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <textarea name="comment" id="comment" class="form-control" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Comment</button>
                        </form>
                    <?php else : ?>
                        <p>You must be <a href="login.php">logged in</a> to comment.</p>
                    <?php endif; ?>

                    <?php
                    if ($comments->num_rows > 0) {
                        while ($comment = $comments->fetch_assoc()) {
                            echo '
                            <div class="comment mb-3">
                                <h5>' . htmlspecialchars($comment['nama_pengguna']) . '</h5>
                                <p>' . nl2br(htmlspecialchars($comment['isi_komentar'])) . '</p>
                                <small class="text-muted">' . date("F j, Y, g:i a", strtotime($comment['dibuat_pada'])) . '</small>
                            </div>
                            ';
                        }
                    } else {
                        echo '<p>No comments yet.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        &copy; 2024 Your Website Name. All Rights Reserved.
    </div>
</body>

</html>

<?php
$conn->close();
?>