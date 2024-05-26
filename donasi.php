<?php
include 'includes/header.php';
include 'koneksi/koneksi.php';

// Start session to get user ID
$id_pengguna = $_SESSION['id_pengguna'];

// Initialize variables
$total_donasi = $tanggal = "";
$errors = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    if (isset($_POST['total_donasi']) && isset($_POST['tanggal'])) {
        $total_donasi = $_POST['total_donasi'];
        $tanggal = $_POST['tanggal'];

        // Check if inputs are not empty
        if (empty($total_donasi) || empty($tanggal)) {
            $errors[] = "All fields are required.";
        }

        // If no errors, insert data into database
        if (empty($errors)) {
            $query = "INSERT INTO donasi (id_pengguna, total_donasi, tanggal) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ids", $id_pengguna, $total_donasi, $tanggal);

            if ($stmt->execute()) {
                $success_message = "Donation successfully added!";
            } else {
                $errors[] = "Failed to add donation. Please try again.";
            }
        }
    } else {
        $errors[] = "Invalid form submission.";
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
    <?php
    include 'includes/navbar.php';
    ?>

    <div class="content">
        <div class="container mt-5">
            <h2 class="mb-4">Form Donasi</h2>

            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error) : ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($success_message)) : ?>
                <div class="alert alert-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="mb-3">
                    <label for="totalDonasi" class="form-label">Total Donasi</label>
                    <input type="number" step="0.01" class="form-control" id="totalDonasi" name="total_donasi" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                </div>
                <input type="hidden" name="id_pengguna" value="<?php echo $id_pengguna; ?>">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <?php
    include 'includes/footer.php';
    ?>
</body>

</html>