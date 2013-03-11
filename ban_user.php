<?php
	session_start();
	require_once "includes/connect.php";
			
	$str=$_GET['user'];	

	$stid = oci_parse($connect, "update ACCOUNT set BANNED = 1 where USERNAME = '{$str}'");
	oci_execute($stid) or die ('error: ' . var_dump(oci_error()));
	
	/*$stid3 = oci_parse($connect, "select PRICE from ITEM where OWNER = '{$str}'");
	oci_execute($stid3) or die ('error: ' . var_dump(oci_error()));
	$row3 = oci_fetch_row($stid3); {$row3[0]}*/
	
	$stid2 = oci_parse($connect, "update ITEM set HIGHEST_BIDDER = null, HIGHEST_BID = null  where OWNER = '{$str}'");
	oci_execute($stid2) or die ('error: ' . var_dump(oci_error()));
	
	header('Location:admin_home.php');
	oci_commit($connect);
	oci_close($connect);
?>