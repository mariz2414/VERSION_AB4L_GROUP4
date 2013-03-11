<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>UPLB ONLINE AUCTION</title>
	<link rel="stylesheet" type="text/css" href="includes/main.css" />
<?php
	session_start();
	
	if(isset($_SESSION['userAdmin'])){
		header('Location: admin_home.php');
	}else{
		echo "
		<div id = login_page>
			<div id='log_in'>
				<form name ='login_form' action='signin_admin.php' method='post'>
				Username:<input type = 'text' name = 'username' id = 'username' required /> <br/>
				Password: <input type = 'password' name = 'password' id = 'password' required /> <br/>
				<input type = 'submit' value='Login'/>
				</form>
			</div>
		</div>";
	}
	require_once('includes/footer.html');
?>