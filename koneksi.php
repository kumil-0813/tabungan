<?php 
	session_start();
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$db	  = 'tabungan';
	$koneksi = mysqli_connect($host, $user, $pass, $db);

	if ($koneksi) {
		// echo "Koneksi berhasil!";
	}
 ?>