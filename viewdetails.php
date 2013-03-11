<?php
	session_start();
	if(isset($_SESSION['username'])){
		require_once('includes/connect.php');
	}
	else{
		header('Location:index.php');
	}
?>
	
	<?php
			if (isset($_POST['id'])) { 
				$str = $_POST['id'];
				$result = oci_parse($connect, "select * from ITEM where ID='{$str}'");
				$db = oci_execute($result);
				while($row = oci_fetch_array($result))
				{
					echo "
					<div id = 'view_container'>
						<img src='itemImages/{$row['PHOTO']}' height='400' width='320' id='view_image'/>
					<div id='view_desc'> Name: {$row['NAME']}<br/><hr/>
						Price: P{$row['PRICE']}<br/><hr/>
						Description: {$row['DESCRIPTION']}<br/><hr/>
						ID: {$row['ID']}<br/><hr/>
						Owner: {$row['OWNER']}<br/><hr/>
						Category: {$row['CATEGORY']}<br/><hr/>
						Highest Bidder: {$row['HIGHEST_BIDDER']}<br/><hr/>
						Highest Bid: {$row['HIGHEST_BID']}
												
					</div></div>";
				}						
				oci_close($connect);
			}
	?>