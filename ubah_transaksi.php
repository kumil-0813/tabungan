<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: index.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
	$data_user = mysqli_fetch_assoc($user);

	$id_riwayat_tabungan = $_GET['id_riwayat_tabungan'];
	$data_riwayat_tabungan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM riwayat_tabungan WHERE id_riwayat_tabungan = '$id_riwayat_tabungan'"));
	
	$id_tabungan = $data_riwayat_tabungan['id_tabungan'];

	if (isset($_POST['btnUbahTransaksi'])) {
		$tanggal_transaksi = htmlspecialchars($_POST['tanggal_transaksi']);
		$jenis_transaksi = htmlspecialchars($_POST['jenis_transaksi']);
		$nominal = htmlspecialchars($_POST['nominal']);

		if ($jenis_transaksi == 'SETORAN') {
			$update_saldo = mysqli_query($koneksi, "UPDATE tabungan SET saldo = (saldo - $data_riwayat_tabungan['nominal']) + '$nominal' WHERE id_tabungan = '$id_tabungan'");
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

		$update_transaksi = mysqli_query($koneksi, "UPDATE riwayat_tabungan SET tanggal_transaksi = '$tanggal_transaksi', jenis_transaksi = '$jenis_transaksi', nominal = '$nominal' WHERE id_riwayat_tabungan = '$id_riwayat_tabungan'");


		if ($transaksi) {
			echo "
				<script>
					alert('Transaksi berhasil diubah!')
					document.location.href='riwayat_tabungan.php?id_tabungan=$id_tabungan'
				</script>
			";
		} else {
			echo "
				<script>
					alert('Transaksi gagal diubah!')
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
	<title>Ubah Transaksi</title>
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
					<label for="tanggal_transaksi">Tanggal Transaksi</label>
					<input type="datetime-local" name="tanggal_transaksi" id="tanggal_transaksi" class="input-field" required value="<?= $data_riwayat_tabungan['tanggal_transaksi'] ?>">
				</div>
				<div>
					<label for="jenis_transaksi">Jenis Transaksi</label>
					<select name="jenis_transaksi" id="jenis_transaksi" class="input-field">
						<?php if ($data_riwayat_tabungan['jenis_transaksi'] == 'SETORAN'): ?>
							<option value="SETORAN">SETORAN</option>
							<option value="TARIKAN">TARIKAN</option>
						<?php else: ?>
							<option value="TARIKAN">TARIKAN</option>
							<option value="SETORAN">SETORAN</option>
						<?php endif ?>
					</select>
				</div>
				<div>
					<label for="nominal">Nominal</label>
					<input type="number" name="nominal" id="nominal" class="input-field" required value="<?= $data_riwayat_tabungan['nominal'] ?>">
				</div>
				<button type="submit" name="btnUbahTransaksi" class="button">Ubah Transaksi</button>
	  	</form>
  	</div>
  </main>
</body>
</html>