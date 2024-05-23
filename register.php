<?php
session_start();
include 'koneksi/koneksi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$nama_pengguna = $conn->real_escape_string($_POST['nama_pengguna']);
	$username = $conn->real_escape_string($_POST['username']);
	$password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT);
	$peran = $conn->real_escape_string($_POST['peran']);

	$sql = "INSERT INTO pengguna (nama_pengguna, username, password, peran)
            VALUES ('$nama_pengguna', '$username', '$password', '$peran')";

	if ($conn->query($sql) === TRUE) {
		header("Location: index.php");
		exit();
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

$conn->close();
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
			/* Overlay to darken the image */
			/* filter: blur(8px); */
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
				<h2 class="text-center">Register</h2>
				<form action="" method="post" role="form">
					<div class="form-group">
						<label for="nama_pengguna">Nama Pengguna</label>
						<input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" required>
					</div>
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" id="username" name="username" required>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" required>
					</div>
					<div class="form-group">
						<label for="peran">Peran</label>
						<select class="form-control" id="peran" name="peran" required>
							<option value="admin">Admin</option>
							<option value="jamaah">Jamaah</option>
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Register</button>
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