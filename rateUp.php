<?php
	require_once('includes/connect.php');
	
	$result = oci_parse($connect, "update account set stars = 1 where username= '{$_POST['toRate']}'");
	oci_execute($result);
	$result = oci_parse($connect, "update item set FINISHEDRATING = 1 where ID= '{$_POST['itemID']}'");
	oci_execute($result);
	echo $_POST['itemID'];
	header('Location:home.php');
	oci_close($connect);
?>