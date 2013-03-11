<?php
	require_once('includes/connect.php');
	
	$result = oci_parse($connect, "delete from ITEM where OWNER = '{$_POST['userName']}'");
	$result = oci_parse($connect, "delete from ACCOUNT where USERNAME = '{$_POST['userName']}'");
	$db = oci_execute($result);
	
	header('Location: admin_home.php');
?> 