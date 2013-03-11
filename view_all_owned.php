<?php
	session_start();
	require_once('includes/header.html');
	require_once('includes/connect.php');
	if(isset($_SESSION['username'])){
		require_once('includes/greeting.php');
	}
	else{
		header('Location:index.php');
	}
?>
	<!-- printing of the images-->
	<div id = "image_gallery">
	<div id = "all_images">
	<?php
	$arr = array();
	$result = oci_parse($connect, "select * from ITEM where OWNER='{$_SESSION['username']}'");
	$db = oci_execute($result);
	while($row = oci_fetch_array($result)){
		if (!in_array($row['ID'],$arr)) {
			array_push($arr, $row['ID']);
		}
		echo "
			<div id='image_container'>
				<img src='itemImages/{$row['PHOTO']}' height='200' width='200' id='image'/>
				<p id='item_name'>Name: {$row['NAME']}</p>
				";
				
				if($row['OWNER']!=$_SESSION['username']){				
					echo " <form action='bid.php' method='post' id='image_button'>
						<input type = 'submit' value='Bid' name='{$row['ID']}' id='button'/>
						</form>
					";
				}
				else{
					echo " <input type = 'submit' value='Yours' name='{$row['ID']}' id='button' disabled/>";
				}
				
				echo"
				<form action='viewdetails.php' method='post' id='image_button'>
					<input type = 'submit' value='View Details' name='{$row['ID']}'id='button'/>
				</form>
			</div>";
	}
	echo "</div> </div>";
	$_SESSION['button_array'] = $arr;
	
	require_once('includes/footer.html');
?>