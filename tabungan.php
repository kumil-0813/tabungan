<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: index.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
	$data_user = mysqli_fetch_assoc($user);

	$tabungan = mysqli_query($koneksi, "SELECT * FROM tabungan INNER JOIN siswa ON tabungan.id_siswa = siswa.id_siswa ORDER BY kelas_siswa ASC, nama_siswa ASC");
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tabungan</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- memanggil topbar -->
  <?php include_once 'include/topbar.php'; ?>
  
  <!-- memanggil sidebar -->
  <?php include_once 'include/sidebar.php'; ?>

  <main>
  	<h1>Tabungan</h1>
  	<a href="tambah_tabungan.php" class="button">+ Tambah Tabungan</a>
  	<hr>
  	<table border="1" cellspacing="0" cellpadding="10">
  		<thead>
  			<tr>
  				<th>No.</th>
  				<th>Nama Siswa</th>
  				<th>Kelas Siswa</th>
  				<th>Saldo</th>
  				<th>Tanggal Dibuka</th>
  				<th>Aksi</th>
  			</tr>
  		</thead>
  		<tbody>
  			<?php $i = 1; ?>
  			<?php foreach ($tabungan as $dt): ?>
  				<tr>
  					<td><?= $i++; ?></td>
  					<td><?= ucwords($dt['nama_siswa']); ?></td>
  					<td><?= strtoupper($dt['kelas_siswa']); ?></td>
  					<td>Rp. <?= number_format($dt['saldo']); ?></td>
  					<td><?= $dt['tanggal_dibuka']; ?></td>
  					<td>
  						<a href="riwayat_tabungan.php?id_tabungan=<?= $dt['id_tabungan']; ?>" class="button">Nabung</a>
  						<a href="hapus_tabungan.php?id_tabungan=<?= $dt['id_tabungan']; ?>" class="button" onclick="return confirm('Apakah Anda yakin ingin menghapus Tabungan <?= ucwords($dt['nama_siswa']); ?>?')">Hapus</a>
  					</td>
  				</tr>
  			<?php endforeach ?>
  		</tbody>
  	</table>
  </main>
</body>
</html>