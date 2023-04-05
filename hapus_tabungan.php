<?php 
require_once 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: index.php");
	exit;
}

$id_tabungan = $_GET['id_tabungan'];

// cek jika saldo tidak 0 maka tidak dapat dihapus
$cek_saldo = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tabungan WHERE id_tabungan = '$id_tabungan'"));
if ($cek_saldo['saldo'] > 0) {
	echo "
		<script>
			alert('Tabungan tidak dapat dihapus karena saldo tidak nol!')
			document.location.href='tabungan.php'
		</script>
	";
	exit;
}

$hapus_tabungan = mysqli_query($koneksi, "DELETE FROM tabungan WHERE id_tabungan = '$id_tabungan'");
$hapus_riwayat_tabungan = mysqli_query($koneksi, "DELETE FROM riwayat_tabungan WHERE id_tabungan = '$id_tabungan'");
if ($hapus_tabungan) {
	echo "
		<script>
			alert('tabungan berhasil dihapus!')
			document.location.href='tabungan.php'
		</script>
	";
	exit;
} else {
	echo "
		<script>
			alert('tabungan gagal dihapus!')
			document.location.href='tabungan.php'
		</script>
	";
	exit;
}

?>