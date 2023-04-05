<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: index.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
	$data_user = mysqli_fetch_assoc($user);

	if (isset($_POST['btuUbahUser'])) {
		$username = htmlspecialchars($_POST['username']);
		$nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);

		// check username 
		$old_username = $data_user['username'];
		if ($username != $old_username) {
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
		}

		$ubah_user = mysqli_query($koneksi, "UPDATE user SET username = '$username', nama_lengkap = '$nama_lengkap' WHERE id_user = '$id_user'");

		if ($ubah_user) {
			echo "
				<script>
					alert('User berhasil diubah!')
					document.location.href='user.php'
				</script>
			";
		} else {
			echo "
				<script>
					alert('User gagal diubah!')
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
	<title>Ubah User</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- memanggil topbar -->
  <?php include_once 'include/topbar.php'; ?>
  
  <!-- memanggil sidebar -->
  <?php include_once 'include/sidebar.php'; ?>

  <main>
  	<h1>Ubah User</h1>
  	<a href="user.php" class="button">Kembali</a>
  	<hr>
  	<div class="form">
  		<form method="POST">
				<div>
					<label for="username">Username</label>
					<input type="text" name="username" id="username" class="input-field" required value="<?= $data_user['username']; ?>">
				</div>
				<div>
					<label for="nama_lengkap">Nama Lengkap</label>
					<input type="text" name="nama_lengkap" id="nama_lengkap" class="input-field" required value="<?= $data_user['nama_lengkap']; ?>">
				</div>
				<button type="submit" name="btuUbahUser" class="button">Ubah</button>
	  	</form>
  	</div>
  </main>
</body>
</html>