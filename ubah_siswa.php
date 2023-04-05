<?php 
require_once 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: index.php");
	exit;
}

$id_user = $_SESSION['id_user'];

$user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
$data_user = mysqli_fetch_assoc($user);

$id_siswa = $_GET['id_siswa'];

$data_siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa = '$id_siswa'"));

if (isset($_POST['btnUbahSiswa'])) {
	$nama_siswa = htmlspecialchars(ucwords($_POST['nama_siswa']));
	$kelas_siswa = htmlspecialchars(strtoupper($_POST['kelas_siswa']));

	$ubah_siswa = mysqli_query($koneksi, "UPDATE siswa SET nama_siswa = '$nama_siswa', kelas_siswa = '$kelas_siswa' WHERE id_siswa = '$id_siswa'");

	if ($ubah_siswa) {
			echo "
				<script>
					alert('Siswa berhasil diubah!')
					document.location.href='siswa.php'
				</script>
			";
		} else {
			echo "
				<script>
					alert('Siswa gagal diubah!')
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
	<title>Ubah Siswa - <?= $data_siswa['nama_siswa']; ?></title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- memanggil topbar -->
  <?php include_once 'include/topbar.php'; ?>
  
  <!-- memanggil sidebar -->
  <?php include_once 'include/sidebar.php'; ?>

  <main>
  	<h1>Ubah Siswa - <?= $data_siswa['nama_siswa']; ?></h1>
  	<a href="siswa.php" class="button">Kembali</a>
  	<hr>
  	<div class="form">
  		<form method="POST">
				<div>
					<label for="nama_siswa">Nama Siswa</label>
					<input type="text" name="nama_siswa" id="nama_siswa" class="input-field" required value="<?= $data_siswa['nama_siswa']; ?>">
				</div>
				<div>
					<label for="kelas_siswa">Kelas Siswa</label>
					<input type="text" name="kelas_siswa" id="kelas_siswa" class="input-field" required value="<?= $data_siswa['kelas_siswa']; ?>">
				</div>
				<button type="submit" name="btnUbahSiswa" class="button">Ubah</button>
	  	</form>
  	</div>
  </main>
</body>
</html>