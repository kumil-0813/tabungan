<?php 
require_once 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: index.php");
	exit;
}

$id_siswa = $_GET['id_siswa'];

$hapus_siswa = mysqli_query($koneksi, "DELETE FROM siswa WHERE id_siswa = '$id_siswa'");

if ($hapus_siswa) {
	echo "
		<script>
			alert('Siswa berhasil dihapus!')
			document.location.href='siswa.php'
		</script>
	";
} else {
	echo "
		<script>
			alert('Siswa gagal dihapus!')
			document.location.href='siswa.php'
		</script>
	";
}

?>