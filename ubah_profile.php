<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: index.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
	$data_user = mysqli_fetch_assoc($user);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ubah Profile</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- memanggil topbar -->
  <?php include_once 'include/topbar.php'; ?>
  
  <!-- memanggil sidebar -->
  <?php include_once 'include/sidebar.php'; ?>

  <main>
  	<h1>Ubah Profile</h1>
  	<div class="form">
  		<form method="POST">
				<div>
					<label for="username">Username</label>
					<input type="text" name="username" id="username" class="input-field" value="<?= $data_user['username']; ?>">
				</div>
				<div>
					<label for="nama_lengkap">Nama Lengkap</label>
					<input type="text" name="nama_lengkap" id="nama_lengkap" class="input-field" value="<?= $data_user['nama_lengkap']; ?>">
				</div>
				<button type="submit" name="btnUbahProfile" class="button">Ubah</button>
	  	</form>
  	</div>
  </main>
</body>
</html>