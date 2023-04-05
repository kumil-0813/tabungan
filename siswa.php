<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: index.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
	$data_user = mysqli_fetch_assoc($user);

	$siswa = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY nama_siswa ASC");
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Siswa</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- memanggil topbar -->
  <?php include_once 'include/topbar.php'; ?>
  
  <!-- memanggil sidebar -->
  <?php include_once 'include/sidebar.php'; ?>

  <main>
  	<h1>Siswa</h1>
  	<a href="tambah_siswa.php" class="button">+ Tambah Siswa</a>
  	<hr>
  	<table border="1" cellspacing="0" cellpadding="10">
  		<thead>
  			<tr>
  				<th>No.</th>
  				<th>Nama Siswa</th>
  				<th>Kelas Siswa</th>
  				<th>Aksi</th>
  			</tr>
  		</thead>
  		<tbody>
  			<?php $i = 1; ?>
  			<?php foreach ($siswa as $ds): ?>
  				<tr>
  					<td><?= $i++; ?></td>
  					<td><?= ucwords($ds['nama_siswa']); ?></td>
  					<td><?= strtoupper($ds['kelas_siswa']); ?></td>
  					<td>
  						<a href="ubah_siswa.php?id_siswa=<?= $ds['id_siswa']; ?>" class="button">Ubah</a>
  						<a href="hapus_siswa.php?id_siswa=<?= $ds['id_siswa']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa <?= $ds['nama_siswa']; ?>?')" class="button">Hapus</a>
  					</td>
  				</tr>
  			<?php endforeach ?>
  		</tbody>
  	</table>
  </main>
</body>
</html>