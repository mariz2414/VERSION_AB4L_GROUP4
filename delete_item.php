<?php
		
	session_start();
	$connect = oci_connect('ONLINE AUCTION','uplbonlineauction') or	die('Could not connect to Oracle: ' . oci_error());
	
	
		$stid = oci_parse($connect, "select BANNED from ACCOUNT where (username = '".$_SESSION['username']."')");
		$r = oci_execute($stid);
		
		$row = oci_fetch_row($stid);
		
		if($row[0] == 1){
			$_SESSION['flag'] = 1;
			header('Location:home.php');
		}
	
	
	$strSQL = "DELETE FROM ITEM ";  
	$strSQL .="WHERE ID = '".$_POST["id"]."' ";  
	$objParse = oci_parse($connect, $strSQL);  
	$objExecute = oci_execute($objParse, OCI_DEFAULT);   
	oci_commit($connect);
	echo "Item Deleted.";  
	oci_close($connect);  
	
	require_once('includes/footer.html');
	
	print '<a href="home.php"> Back to home </a>';
	?>			
</body>
				
</html>