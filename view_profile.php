<?php
	session_start();
	if(isset($_SESSION['username'])){
		require_once('includes/greeting.php');
		require_once('includes/header.html');
		require_once('includes/connect.php');
	}
	else{
		header('Location:index.php');
	}
?>
	
	<?php
		foreach($_SESSION['button_array'] as $str){
			if (isset($_POST[$str])) { 
				$result = oci_parse($connect, "select * from ACCOUNT where USERNAME='{$str}'");
				$db = oci_execute($result);
				while($row = oci_fetch_array($result))
				{
					echo "
					<div id = 'view_container'>
						<img src='images/{$row['PHOTO']}' height='400' width='320' id='view_image'/>
					<div id='view_desc'> 
					First Name: {$row['FNAME']} <br/>
					Middle Name: {$row['MNAME']} <br/>
					Last name: {$row['LNAME']} <br/>
					Email: {$row['EMAIL']} <br/>
					Mobile Number: {$row['MOBILE_NUM']} <br/>
					Home Number: {$row['HOME_NUM']} <br/>
					Address: {$row['ADDRESS']} <br/>
					Interests: {$row['INTERESTS']} <br/>
					Stars: {$row['STARS']} <br/>
					
					</div>
						<form action='report.php' method='post' id='image_button'>
							<input type = 'submit' value='Report' name='{$row['USERNAME']}' id='button'/>
						</form>
					</div>";
				}						
				oci_close($connect);
			}
		}
	?>
	
<?php	
	require_once "includes/footer.html";
?>