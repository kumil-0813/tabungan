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
	<title>Profile</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- memanggil topbar -->
  <?php include_once 'include/topbar.php'; ?>
  
  <!-- memanggil sidebar -->
  <?php include_once 'include/sidebar.php'; ?>

  <main>
  	<h1>Profile</h1>
  	<ul>
  		<li>Username: <?= $data_user['username']; ?></li>
  		<li>Nama Lengkap: <?= $data_user['nama_lengkap']; ?></li>
  	</ul>
  	<a class="button" href="ubah_profile.php">Ubah</a>
  	<a class="button" href="ganti_password.php">Ganti Password</a>
  </main>
</body>
</html>