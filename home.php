<?php
	session_start();
	require_once('includes/header.html');
	require_once('includes/connect.php');

?>
	<!-- printing of the images-->
	<div id = "image_gallery">
	<div id = "all_images">
	<?php
	$arr = array();
	$result = oci_parse($connect, "select * from ITEM where BOUGHTBY = '-'");
	$db = oci_execute($result);
	
	
	
	$temp = 0;
	$result2 = oci_parse($connect, "select BANNED from ACCOUNT");
	$db2 = oci_execute($result2); 
	$row2 = oci_fetch_row($result2);
	
	$stid = oci_parse($connect, "select BANNED from ACCOUNT where (username = '".$_SESSION['username']."')");
	$r = oci_execute($stid);
	$row3 = oci_fetch_row($stid);
	
	if($row3[0] == 1 && isSet($_SESSION['flag'])){
		echo "
			<p>You have been banned by the Administrator. Some functionalities of this site has been disabled.
			<a href='home.php'><input type='Submit' value='OK'></a></p>
		";
		unset($_SESSION['flag']);
	}
	
	
	
	while($row = oci_fetch_array($result)){
		if (!in_array($row['ID'],$arr)) {
			array_push($arr, $row['ID']);
		}
		echo "
			<div id='image_container'>
				<a href = 'profile.php?username={$row['OWNER']}' id= 'username_link'>{$row['OWNER']}</a>
				<div id = 'image_buttons'>
					<p id='item_name'>{$row['NAME']}</p>
					";
				if($row2[0] == 1){
					echo 'banned';
				}else{	
					if($row['OWNER']!=$_SESSION['username']){				
				echo "<input type = 'button' value='Bid' name='{$row['ID']}' id='button' onclick = 'floater(\"floater\", \"bid.php\", \"id={$row['ID']}\")'/>";
					}
					else{
						echo " <input type = 'submit' value='Yours' name='{$row['ID']}' id='button' disabled/>";
					}
				}	
					echo"
					<form>
					<input type = 'button' value='View Details' name='{$row['ID']}'id='button' onclick = 'floater(\"floater\", \"viewdetails.php\", \"id={$row['ID']}\")'/>
					</form>
					<form action='edit_item.php' method='post' id='image_button'>
						<input type = 'hidden' name = 'id' value = '{$row['ID']}'/>
						<input type = 'submit' value='Edit' id='button'/>
					</form>
				</div>
				<img src='itemImages/{$row['PHOTO']}' id='image'/>
			</div>";
	}
	echo "</div> </div>";
	$_SESSION['button_array'] = $arr;
	require_once('includes/footer.html');
?>