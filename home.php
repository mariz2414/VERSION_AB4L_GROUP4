<?php
	session_start();
	require_once('includes/header.html');
	require_once('includes/greeting.php');
	
	echo "<a href='edit_account.php'>Edit Account</a>&nbsp&nbsp&nbsp";
	echo "<a href='add_item.php'>Add Item</a>&nbsp&nbsp&nbsp";
	//echo "<a href='edit_item.php'>EditItem</a>&nbsp&nbsp&nbsp";
	
	if(isset($_SESSION['username'])){
		require_once('includes/greeting.php');
	}
	else{
		header('Location: index.php');
	}
	echo "<div id = home>
			</div>";
			
	require_once('includes/footer.html');
?>