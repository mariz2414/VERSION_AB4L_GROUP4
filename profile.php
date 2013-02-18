<?php
	session_start();
	require_once('includes/connect.php');
	require_once('includes/header.html');
	
	if(isset($_SESSION['username'])){
		require_once('includes/greeting.php');
	}
	else{
		header('Location:index.php');
	}
	
	$result = oci_parse($connect, "select * from ACCOUNT where Username = '".$_SESSION['username']."'");
	$db = oci_execute($result);
	$info=array();
	while($rw=oci_fetch_assoc($result)){
		$info[]=$rw;
	}

	echo "<a href='home.php'>HOME</a> <br/><br/><br/>";
	
	foreach($info as $user => $user_detail){
		if($user_detail['USERNAME']==htmlspecialchars($_SESSION['username'])){
			echo "
			<div id='image_container'>
				<img src='images/{$user_detail['PHOTO']}' height='200' width='170' id='image'/>
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
	}
		require_once('includes/footer.html');
?>