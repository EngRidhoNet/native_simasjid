<?php
session_start();
include 'koneksi/koneksi.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // $id = $_POST['id_pengguna'];

    // Prepared statement untuk mencegah SQL Injection
    $query = $conn->prepare("SELECT * FROM pengguna WHERE username = ?");

    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            if($row['peran'] == 'admin'){
                $_SESSION['peran'] = 'admin';
                $_SESSION['id_pengguna'] = $row['id_pengguna'];
                header('Location: admin/index.php');
            }else if($row['peran'] == 'jamaah'){
                $_SESSION['peran'] = 'jamaah';
                header('Location: home.php');
            exit;
            }
        } else {
            $error = 'Invalid username or password';
        }
    } else {
        $error = 'Invalid username or password';
    }
    $query->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Manajemen Masjid</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .container-fluid {
            display: flex;
            height: 100%;
            padding: 0;
        }

        .login-container {
            position: relative;
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('image/home/1.jpg') no-repeat center center;
            background-size: cover;
            overflow: hidden;
            height: 100%;
        }

        .login-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .form-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
        }

        .sidebar {
            flex: 0 0 300px;
            background-color: #343a40;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            height: 100%;
        }

        .sidebar h2 {
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .container-fluid {
                flex-direction: column-reverse;
            }

            .sidebar {
                flex: 0 0 200px;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="login-container">
            <div class="form-container">
                <h2 class="text-center">Login</h2>
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                <form role="form" method="post" action="">
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="Username" name="username" type="text" autofocus required autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Password" name="password" type="password" required autocomplete="off" />
                        </div>
                        <br>
                        <div class="text-center">
                            <button name="submit" type="submit" class="btn btn-md btn-primary"><i class="fa fa-sign-in"></i> Login</button>
                            <button name="reset" type="reset" class="btn btn-md btn-danger"><i class="fa fa-refresh"></i> Reset</button>
                        </div>
                    </fieldset>
                    <br>
                    <div class="text-center">
                        <span class="small">
                            Belum punya akun? Daftar <a href="register.php">disini.</a>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="sidebar">
            <div>
                <h2>Ahlan Wa Sahlan</h2>
                <p>Sistem Informasi Manajemen Masjid</p>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>