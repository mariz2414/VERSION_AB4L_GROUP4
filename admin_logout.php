<?php
	session_start();	
	unset($_SESSION['userAdmin']);	//Unset the variables stored in session
	session_destroy();
	header('Location:admin.php');
	//echo "<script> window.location = 'index.php' </script>";
?>