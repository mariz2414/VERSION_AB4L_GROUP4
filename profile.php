<?php
	session_start();
	
	if(isset($_SESSION['username'])){
		require_once('includes/connect.php');
		require_once('includes/header.html');
		require_once('includes/greeting.php');
	
		$result = oci_parse($connect, "select * from ACCOUNT where Username = '".$_SESSION['username']."'");
		$db = oci_execute($result);
		$info=array();
		while($rw=oci_fetch_assoc($result)){
			$info[]=$rw;
		}
		foreach($info as $user => $user_detail){
				echo "
				<div id='image_container'>
					<img src='images/{$user_detail['PHOTO']}' id='image'/>
				</div>
				<div id='info_div'>
					First Name: {$user_detail['FNAME']} <br/>
					Middle Name: {$user_detail['MNAME']} <br/>
					Last name: {$user_detail['LNAME']} <br/>
					Email: {$user_detail['EMAIL']} <br/>
					Mobile Number: {$user_detail['MOBILE_NUM']} <br/>
					Home Number: {$user_detail['HOME_NUM']} <br/>
					Address: {$user_detail['ADDRESS']} <br/>
					Interests: {$user_detail['INTERESTS']} <br/>
					Stars: {$user_detail['STARS']} <br/>
				</div>
				";
			}
			
			echo "Bought Items";
			
		$result = oci_parse($connect, "select * from ITEM where BOUGHTBY = '{$_GET['username']}'");
		$db = oci_execute($result);
		while($row = oci_fetch_array($result)){
			echo "
				<div id='image_container'>
					<a href = 'profile.php?username={$row['OWNER']}' id= 'username_link'>{$row['OWNER']}</a>
					<div id = 'image_buttons'>
						<p id='item_name'>{$row['NAME']}</p>
						";
								
					echo "
					<form>
						<input type = 'button' value='View Details' name='{$row['ID']}'id='button' onclick = 'floater(\"floater\", \"viewdetails.php\", \"id={$row['ID']}\")'/>
					</form>
					";
					
					if($row['FINISHEDRATING'] == 0){
						echo "Rate this user: ";
						echo "<form action = 'rateDown.php' method = 'post'>
								<input type = 'hidden' name = 'toRate' value = '{$row['OWNER']}'>
								<input type = 'hidden' name = 'item' value = '{$row['ID']}'>
								<input type = 'submit' value = '-' />
							</form>";
						echo "<form action = 'rateUp.php' method = 'post'>
							<input type = 'hidden' name = 'toRate' value = '{$row['OWNER']}'>
							<input type = 'hidden' name = 'itemID' value = '{$row['ID']}'>
							<input type = 'submit' value = '+' />
						</form>";
				}
					
				echo "
				</div>
					
				<img src='itemImages/{$row['PHOTO']}' id='image'/>
			</div>";
	}
		require_once('includes/footer.html');
	}
	else{
		header('Location:index.php');
	}
?>