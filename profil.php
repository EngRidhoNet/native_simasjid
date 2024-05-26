<?php
include 'includes/header.php';
include 'koneksi/koneksi.php';
$id_pengguna = $_SESSION['id_pengguna'];
$errors = [];
$success_message = '';

// Fetch current user data
$query = "SELECT nama_pengguna, username FROM pengguna WHERE id_pengguna = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_pengguna);
$stmt->execute();
$stmt->bind_result($nama_pengguna, $username);
$stmt->fetch();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_nama_pengguna = $_POST['nama_pengguna'];
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate inputs
    if (empty($new_nama_pengguna) || empty($new_username)) {
        $errors[] = "Name and username are required.";
    }

    if (!empty($new_password) && $new_password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        // Update query
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE pengguna SET nama_pengguna = ?, username = ?, password = ? WHERE id_pengguna = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("sssi", $new_nama_pengguna, $new_username, $hashed_password, $id_pengguna);
        } else {
            $update_query = "UPDATE pengguna SET nama_pengguna = ?, username = ? WHERE id_pengguna = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ssi", $new_nama_pengguna, $new_username, $id_pengguna);
        }

        if ($stmt->execute()) {
            $success_message = "Profile updated successfully!";
        } else {
            $errors[] = "Failed to update profile. Please try again.";
        }
        $stmt->close();
    }
}
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
</style>

<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="content">
        <div class="container mt-5">
            <h2 class="mb-4">Update Profile</h2>

            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error) : ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success_message)) : ?>
                <div class="alert alert-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="mb-3">
                    <label for="nama_pengguna" class="form-label">Nama Pengguna</label>
                    <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" value="<?php echo htmlspecialchars($nama_pengguna); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>