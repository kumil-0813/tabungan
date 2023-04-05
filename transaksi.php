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
	
	if (isset($_POST['btnTransaksi'])) {
		$jenis_transaksi = htmlspecialchars($_POST['jenis_transaksi']);
		$nominal = htmlspecialchars($_POST['nominal']);

		$tanggal_transaksi = date('Y-m-d H:i:s');

		if ($jenis_transaksi == 'SETORAN') {
			$update_saldo = mysqli_query($koneksi, "UPDATE tabungan SET saldo = saldo + '$nominal' WHERE id_tabungan = '$id_tabungan'");
		} else if ($jenis_transaksi == 'TARIKAN') {
			// cek saldo jika kurang dari nominal
			if ($data_tabungan['saldo'] < $nominal) {
				echo "
					<script>
						alert('Saldo Anda tidak mencukupi untuk melakukan penarikan!')
						window.history.back()
					</script>
				";
				exit;
			}

			$update_saldo = mysqli_query($koneksi, "UPDATE tabungan SET saldo = saldo - '$nominal' WHERE id_tabungan = '$id_tabungan'");
		}

		$transaksi = mysqli_query($koneksi, "INSERT INTO riwayat_tabungan VALUES('', '$id_tabungan', '$tanggal_transaksi', '$jenis_transaksi', '$nominal')");


		if ($transaksi) {
			echo "
				<script>
					alert('Transaksi berhasil!')
					document.location.href='riwayat_tabungan.php?id_tabungan=$id_tabungan'
				</script>
			";
		} else {
			echo "
				<script>
					alert('Transaksi gagal!')
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
	<title>Transaksi</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- memanggil topbar -->
  <?php include_once 'include/topbar.php'; ?>
  
  <!-- memanggil sidebar -->
  <?php include_once 'include/sidebar.php'; ?>

  <main>
  	<h1>Transaksi</h1>
  	<a href="riwayat_tabungan.php?id_tabungan=<?= $id_tabungan; ?>" class="button">Kembali</a>
  	<hr>
  	<div class="form">
  		<form method="POST">
				<div>
					<label for="jenis_transaksi">Jenis Transaksi</label>
					<select name="jenis_transaksi" id="jenis_transaksi" class="input-field">
						<option value="SETORAN">SETORAN</option>
						<option value="TARIKAN">TARIKAN</option>
					</select>
				</div>
				<div>
					<label for="nominal">Nominal</label>
					<input type="number" name="nominal" id="nominal" class="input-field" required>
				</div>
				<button type="submit" name="btnTransaksi" class="button">Transaksi</button>
	  	</form>
  	</div>
  </main>
</body>
</html>