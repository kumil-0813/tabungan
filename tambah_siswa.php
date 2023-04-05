<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: index.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
	$data_user = mysqli_fetch_assoc($user);

	if (isset($_POST['btnTambahSiswa'])) {
		$nama_siswa = htmlspecialchars($_POST['nama_siswa']);
		$kelas_siswa = htmlspecialchars($_POST['kelas_siswa']);

		$tambah_siswa = mysqli_query($koneksi, "INSERT INTO siswa VALUES('', '$nama_siswa', '$kelas_siswa')");

		if ($tambah_siswa) {
			echo "
				<script>
					alert('Siswa berhasil ditambahkan!')
					document.location.href='siswa.php'
				</script>
			";
		} else {
			echo "
				<script>
					alert('Siswa gagal ditambahkan!')
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
	<title>Tambah Siswa</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- memanggil topbar -->
  <?php include_once 'include/topbar.php'; ?>
  
  <!-- memanggil sidebar -->
  <?php include_once 'include/sidebar.php'; ?>

  <main>
  	<h1>Tambah Siswa</h1>
  	<a href="siswa.php" class="button">Kembali</a>
  	<hr>
  	<div class="form">
  		<form method="POST">
				<div>
					<label for="nama_siswa">Nama Siswa</label>
					<input type="text" name="nama_siswa" id="nama_siswa" class="input-field" required>
				</div>
				<div>
					<label for="kelas_siswa">Kelas Siswa</label>
					<input type="text" name="kelas_siswa" id="kelas_siswa" class="input-field" required>
				</div>
				<button type="submit" name="btnTambahSiswa" class="button">Tambah</button>
	  	</form>
  	</div>
  </main>
</body>
</html>