<link rel = "stylesheet" href = "includes/main.css">
<?php
	session_start();
	require_once('includes/connect.php');

	if(isset($_SESSION['userAdmin'])){
		echo "<div id = 'contents'>";
		echo "<br /><br /><p style = ''> <a href='admin_logout.php'>Logout</a></p></div>";
	}
	else{
		header('Location:admin.php');
	}
?>

<!-- printing of the users-->
	<div id = "image_gallery">
	<div id = "all_images">
	<?php
	$arr = array();
	$result = oci_parse($connect, "select * from ACCOUNT");
	$db = oci_execute($result);
	
	while($row = oci_fetch_array($result)){
		if (!in_array($row['USERNAME'],$arr)) {
			array_push($arr, $row['USERNAME']);
		}
		echo "
			<div id='image_container'>
				<div id = \"image_buttons\">
				<p id='item_name'>Name: {$row['FNAME']}&nbsp&nbsp{$row['LNAME']}</</p>
				";
				
				if($row['BANNED']==0){				
					echo " <form action='ban.php' method='post' id='image_button'>
						<input type = 'submit' value='Ban' name='{$row['USERNAME']}' id='button'/>
						</form>
					";
				}
				else{
					echo " <form action='remove_ban.php' method='post' id='image_button'>
						<input type = 'submit' value='Remove ban' name='{$row['USERNAME']}' id='button'/>
						</form>
					
					<form action='remove_user.php' method='post' id='image_button'>
						<input type = 'hidden' name = 'userName' value = '{$row['USERNAME']}' />
						<input type = 'submit' value='Remove User' name='{$row['USERNAME']}'id='button'/>
					</form>
					";
				}
				
				echo"
				<form action='viewuserdetails.php' method='post' id='image_button'>
					<input type = 'submit' value='View Details' name='{$row['USERNAME']}'id='button'/>
				</form>
				</div>
				<img src='images/{$row['PHOTO']}' height='200' width='200' id='image'/>
				
			</div>";
	}
	echo "</div> </div>";
	$_SESSION['user_array'] = $arr;
	
	require_once('includes/footer.html');
?>