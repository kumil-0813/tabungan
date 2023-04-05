<?php 
require_once 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: index.php");
	exit;
}

$id_riwayat_tabungan = $_GET['id_riwayat_tabungan'];

$data_riwayat_tabungan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM riwayat_tabungan WHERE id_riwayat_tabungan = '$id_riwayat_tabungan'"));
$nominal = $data_riwayat_tabungan['nominal'];

if ($data_riwayat_tabungan['jenis_transaksi'] == 'SETORAN') {
	$update_saldo = mysqli_query($koneksi, "UPDATE tabungan SET saldo = saldo - '$nominal'");
} else {
	$update_saldo = mysqli_query($koneksi, "UPDATE tabungan SET saldo = saldo + '$nominal'");
}

$hapus_riwayat_tabungan = mysqli_query($koneksi, "DELETE FROM riwayat_tabungan WHERE id_riwayat_tabungan = '$id_riwayat_tabungan'");
if ($hapus_riwayat_tabungan) {
	echo "
		<script>
			alert('tabungan berhasil dihapus!')
			document.location.href='riwayat_tabungan.php?id_riwayat_tabungan=$id_riwayat_tabungan'
		</script>
	";
	exit;
} else {
	echo "
		<script>
			alert('tabungan gagal dihapus!')
			document.location.href='riwayat_tabungan.php?id_riwayat_tabungan=$id_riwayat_tabungan'
		</script>
	";
	exit;
}

?>