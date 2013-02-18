<?php
	session_start();
	require_once('includes/connect.php');
	$username = $_POST['username'];
	$password =  $_POST['password'];
	$found = false;
	
	$result = oci_parse($connect, "select * from ACCOUNT");
	$db = oci_execute($result);
	$all_user=array();
	while($rw=oci_fetch_assoc($result)){
		$all_user[]=$rw;
	}

	foreach($all_user as $user => $user_detail){
		if($user_detail['USERNAME']==htmlspecialchars($username)){
			if($user_detail['PASSWORD']==md5($password)){
				$_SESSION['fname'] = $user_detail['FNAME'];
				$_SESSION['lname'] = $user_detail['LNAME'];
				$found=true;
			}elseif($user_detail['PASSWORD']==$password){
				$found=true;
			}
		} 
	}
		
	if($found==false){
		echo "<script>alert('Username was not found or password did not match.'); window.location = 'index.php' </script>";
		//$errors[]="Username was not found or password did not match.";
		//$_SESSION['errors']=$errors;
		//session_write_close();
		//header('Location: index.php');
		exit();
	}elseif($found==true){
		$_SESSION['username'] = $username;
		header('Location: home.php');
		exit();
	}
	
	oci_close($conn);
?>

