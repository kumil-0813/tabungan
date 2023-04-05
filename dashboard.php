<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: index.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
	$data_user = mysqli_fetch_assoc($user);

	$total_tabungan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT *, sum(saldo) as total_tabungan FROM tabungan"));

	$total_penabung = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tabungan"));
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- memanggil topbar -->
  <?php include_once 'include/topbar.php'; ?>
  
  <!-- memanggil sidebar -->
  <?php include_once 'include/sidebar.php'; ?>

  <main>
  	<h1>Dashboard</h1>
  	<div class="card">
  		<h4>Total Tabungan</h4>
  		<h5>Rp. <?= number_format($total_tabungan['total_tabungan']); ?></h5>
  	</div>
  	<div class="card">
  		<h4>Total Penabung</h4>
  		<h5><?= number_format($total_penabung); ?></h5>
  	</div>
  </main>
</body>
</html>