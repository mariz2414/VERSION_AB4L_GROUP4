<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>UPLB ONLINE AUCTION</title>
	<link rel="stylesheet" type="text/css" href="includes/main.css" />
</head>
<body id = "body" style = "background-image:url('test.png');">
<?php
	session_start();
	require_once('includes/header.html');
	
	if(isset($_SESSION['username'])){
		header('Location: home.php');
	}else{
		echo "
		<div id = login_page>
			<div id='log_in'>
			<form name ='login_form' action='signin.php' method='post'>
			Username:<input type = 'text' name = 'username' id = 'username' required /> <br/>
			Password: <input type = 'password' name = 'password' id = 'password' required /> <br/>
			<input type = 'submit' value='Login'/>
			</form>
			<div id='register'>
				<a href='register.php'>Register</a>
			</div>
			</div>
		</div>";
	}
	require_once('includes/footer.html');
?>