<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: index.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
	$data_user = mysqli_fetch_assoc($user);

	$id_tabungan = $_GET['id_tabungan'];

	$data_tabungan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tabungan INNER JOIN siswa ON tabungan.id_siswa = siswa.id_siswa WHERE id_tabungan = '$id_tabungan'"));

	$riwayat_tabungan = mysqli_query($koneksi, "SELECT * FROM riwayat_tabungan WHERE id_tabungan = '$id_tabungan' ORDER BY tanggal_transaksi DESC");
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tabungan - <?= $data_tabungan['nama_siswa']; ?></title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- memanggil topbar -->
  <?php include_once 'include/topbar.php'; ?>
  
  <!-- memanggil sidebar -->
  <?php include_once 'include/sidebar.php'; ?>

  <main>
  	<h1>Tabungan - <?= $data_tabungan['nama_siswa']; ?></h1>
  	<ul>
	  	<li>Nama Siswa: <?= ucwords($data_tabungan['nama_siswa']); ?></li>
			<li>Kelas Siswa: <?= strtoupper($data_tabungan['kelas_siswa']); ?></li>
			<li>Saldo: Rp. <?= number_format($data_tabungan['saldo']); ?></li>
  	</ul>
  	<a href="tabungan.php" class="button">Kembali</a>
  	<a href="transaksi.php?id_tabungan=<?= $id_tabungan; ?>" class="button">Transaksi</a>
  	<hr>
  	<table border="1" cellspacing="0" cellpadding="10">
  		<thead>
  			<tr>
  				<th>No.</th>
  				<th>Tanggal Transaksi</th>
  				<th>Jenis Transaksi</th>
  				<th>Nominal</th>
  				<th>Aksi</th>
  			</tr>
  		</thead>
  		<tbody>
  			<?php $i = 1; ?>
  			<?php foreach ($riwayat_tabungan as $drt): ?>
  				<tr>
  					<td><?= $i++; ?></td>
  					<td><?= $drt['tanggal_transaksi']; ?></td>
  					<td><?= $drt['jenis_transaksi']; ?></td>
  					<td>Rp. <?= number_format($drt['nominal']); ?></td>
  					<td>
  						<a href="hapus_transaksi.php?id_riwayat_tabungan=<?= $drt['id_riwayat_tabungan']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus Transaksi?')" class="button">Hapus</a>
  					</td>
  				</tr>
  			<?php endforeach ?>
  		</tbody>
  	</table>
  </main>
</body>
</html>