<?php
	session_start();
	require_once "includes/connect.php";
			
	$str=$_GET['user'];	

	$stid = oci_parse($connect, "update ACCOUNT set BANNED = 0 where USERNAME='{$str}'");
	oci_execute($stid) or die ('error: ' . var_dump(oci_error()));
	
	header('Location:admin_home.php');
	oci_commit($connect);	
	oci_close($connect);
?>