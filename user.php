<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: index.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
	$data_user = mysqli_fetch_assoc($user);

	$user = mysqli_query($koneksi, "SELECT * FROM user ORDER BY username ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- memanggil topbar -->
  <?php include_once 'include/topbar.php'; ?>
  
  <!-- memanggil sidebar -->
  <?php include_once 'include/sidebar.php'; ?>

  <main>
  	<h1>User</h1>
  	<a href="tambah_user.php" class="button">+ Tambah User</a>
  	<hr>
  	<table border="1" cellspacing="0" cellpadding="10">
  		<thead>
  			<tr>
  				<th>No.</th>
  				<th>Username</th>
  				<th>Nama Lengkap</th>
  				<th>Aksi</th>
  			</tr>
  		</thead>
  		<tbody>
  			<?php $i = 1; ?>
  			<?php foreach ($user as $du): ?>
  				<tr>
  					<td><?= $i++; ?></td>
  					<td><?= ucwords($du['username']); ?></td>
  					<td><?= ucwords($du['nama_lengkap']); ?></td>
  					<td>
  						<a href="ubah_user.php?id_user=<?= $du['id_user']; ?>" class="button">Ubah</a>
  						<a href="hapus_user.php?id_user=<?= $du['id_user']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus user <?= $du['username']; ?>?')" class="button">Hapus</a>
  					</td>
  				</tr>
  			<?php endforeach ?>
  		</tbody>
  	</table>
  </main>
</body>
</html>