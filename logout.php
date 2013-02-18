<?php
	session_start();	
	unset($_SESSION['username']);	//Unset the variables stored in session
	session_destroy();
	header('Location:index.php');
	//echo "<script> window.location = 'index.php' </script>";
?>