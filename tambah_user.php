<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: index.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
	$data_user = mysqli_fetch_assoc($user);

	if (isset($_POST['btnTambahUser'])) {
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		$verifikasi_password = htmlspecialchars($_POST['verifikasi_password']);
		$nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);

		// check username 
		$check_username = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
		if (mysqli_num_rows($check_username)) {
			echo "
				<script>
					alert('Username telah digunakan!')
					window.history.back();
				</script>
			";
			exit;
		}

		// check password with verify
		if ($password != $verifikasi_password) {
			echo "
				<script>
					alert('Password harus sama dengan verifikasi password!')
					window.history.back();
				</script>
			";
			exit;
		}

		$password = password_hash($password, PASSWORD_DEFAULT);

		$tambah_user = mysqli_query($koneksi, "INSERT INTO user VALUES('', '$username', '$password', '$nama_lengkap')");

		if ($tambah_user) {
			echo "
				<script>
					alert('User berhasil ditambahkan!')
					document.location.href='user.php'
				</script>
			";
		} else {
			echo "
				<script>
					alert('User gagal ditambahkan!')
					window.history.back()
				</script>
			";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tambah User</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- memanggil topbar -->
  <?php include_once 'include/topbar.php'; ?>
  
  <!-- memanggil sidebar -->
  <?php include_once 'include/sidebar.php'; ?>

  <main>
  	<h1>Tambah User</h1>
  	<a href="user.php" class="button">Kembali</a>
  	<hr>
  	<div class="form">
  		<form method="POST">
				<div>
					<label for="username">Username</label>
					<input type="text" name="username" id="username" class="input-field" required>
				</div>
				<div>
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="input-field" required>
				</div>
				<div>
					<label for="verifikasi_password">Verifikasi Password</label>
					<input type="password" name="verifikasi_password" id="verifikasi_password" class="input-field" required>
				</div>
				<div>
					<label for="nama_lengkap">Nama Lengkap</label>
					<input type="text" name="nama_lengkap" id="nama_lengkap" class="input-field" required>
				</div>
				<button type="submit" name="btnTambahUser" class="button">Tambah</button>
	  	</form>
  	</div>
  </main>
</body>
</html>