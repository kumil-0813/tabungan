<?php 
require_once 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: index.php");
	exit;
}

$id_user = $_GET['id_user'];

$hapus_siswa = mysqli_query($koneksi, "DELETE FROM user WHERE id_user = '$id_user'");

if ($hapus_siswa) {
	echo "
		<script>
			alert('User berhasil dihapus!')
			document.location.href='user.php'
		</script>
	";
} else {
	echo "
		<script>
			alert('User gagal dihapus!')
			document.location.href='user.php'
		</script>
	";
}

?>