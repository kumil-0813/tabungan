<?php 
	require_once 'koneksi.php';
	session_destroy();
	header("Location: index.php");
	exit;
 ?>