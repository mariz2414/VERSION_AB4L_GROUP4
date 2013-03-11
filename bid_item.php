<?php
	session_start();
	require_once "includes/connect.php";
				
	$proposed_bid = htmlspecialchars($_POST['bid_price'],ENT_QUOTES);
	$str=$_GET['id'];	
	
	$result = oci_parse($connect, "select * from ITEM where ID={$str}");
	oci_execute($result);
	while($row = oci_fetch_array($result)){
		$highest_bid = $row['HIGHEST_BID'];
		$price = $row['PRICE'];
	}

	if(($highest_bid==NULL) || ($highest_bid<$proposed_bid && $price<$proposed_bid)){
		$stid = oci_parse($connect, "update ITEM set HIGHEST_BID = {$proposed_bid}, HIGHEST_BIDDER='{$_SESSION['username']}', NOTIFICATION='true' where ID = '{$str}'");
		oci_execute($stid) or die ('error: ' . var_dump(oci_error()));
	}
	header('Location:home.php');			
	oci_close($connect);
?>