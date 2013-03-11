<?php
	session_start();
	require_once "includes/connect.php";
	
	foreach($_SESSION['radio_array'] as $str){
		$result = oci_parse($connect, "select * from ITEM where ID={$str}");
		oci_execute($result);
		while($row = oci_fetch_array($result)){
		var_dump($row);
			$stid= oci_parse($connect, "update ITEM set BOUGHTBY = '" . $row['HIGHEST_BIDDER'] . "' WHERE ID={$str}");
			oci_execute($stid) or die ('error: ' . var_dump(oci_error()));
		}
		header('Location:home.php');
		oci_close($connect);
	}
?>