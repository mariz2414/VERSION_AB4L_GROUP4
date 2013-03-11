<?php
	session_start();
	require_once('includes/connect.php');
	$username = $_POST['username'];
	$password =  $_POST['password'];
	$found = false;
	
	$result = oci_parse($connect, "select * from ADMIN");
	$db = oci_execute($result);
	$all_user=array();
	
	while($rw=oci_fetch_assoc($result)){
		$all_user[]=$rw;
	}
	
	
	foreach($all_user as $user => $user_detail){
		if($user_detail['USERNAME']==htmlspecialchars($username)){
			if($user_detail['PASSWORD']==md5($password)){
				$found=true;
			}elseif($user_detail['PASSWORD']==$password){
				$found=true;
			}
		} 
	}
		
	if($found==false){
		echo "<script>alert('Username was not found or password did not match.'); window.location = 'admin_home.php' </script>";
		exit();
	}elseif($found==true){
		$_SESSION['userAdmin'] = $username;
		header('Location: admin_home.php');
		exit();
	}
	
	oci_close($conn);
?>

