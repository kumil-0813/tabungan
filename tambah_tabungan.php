<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: index.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
	$data_user = mysqli_fetch_assoc($user);

	$siswa = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa NOT IN (SELECT id_siswa FROM tabungan) ORDER BY kelas_siswa ASC, nama_siswa ASC");

	if (isset($_POST['btnTambahTabungan'])) {
		$id_siswa = htmlspecialchars($_POST['id_siswa']);
		$saldo = 0;
		$tanggal_dibuka = date('Y-m-d H:i:s');

		if ($id_siswa == 0) {
			echo "
				<script>
					alert('Pilih siswa terlebih dahulu!')
					window.history.back()
				</script>
			";
			exit;
		}

		$tambah_tabungan = mysqli_query($koneksi, "INSERT INTO tabungan VALUES('', '$id_siswa', '$saldo', '$tanggal_dibuka')");

		if ($tambah_tabungan) {
			echo "
				<script>
					alert('Tabungan berhasil ditambahkan!')
					document.location.href='tabungan.php'
				</script>
			";
		} else {
			echo "
				<script>
					alert('Tabungan gagal ditambahkan!')
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
	<title>Tambah Tabungan</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- memanggil topbar -->
  <?php include_once 'include/topbar.php'; ?>
  
  <!-- memanggil sidebar -->
  <?php include_once 'include/sidebar.php'; ?>

  <main>
  	<h1>Tambah Tabungan</h1>
  	<a href="siswa.php" class="button">Kembali</a>
  	<hr>
  	<div class="form">
  		<form method="POST">
				<div>
					<label for="id_siswa">Siswa</label>
					<select name="id_siswa" id="id_siswa" class="input-field">
						<option value="0">--- Pilih Siswa ---</option>
						<?php foreach ($siswa as $ds): ?>
							<option value="<?= $ds['id_siswa'] ?>"><?= $ds['nama_siswa']; ?> | <?= $ds['kelas_siswa']; ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<button type="submit" name="btnTambahTabungan" class="button">Tambah</button>
	  	</form>
  	</div>
  </main>
</body>
</html>