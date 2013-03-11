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
						
						<form action='report.php?toWhom={$row['USERNAME']}&confirm=null' method='post' id='image_button'>						
							Reason: <textarea rows='20' cols='30' id='itemfield_desc' name ='reason'></textarea><br/>
							<input type = 'submit' value='Report' id='button'/>
						</form>
					</div></div>";
				}						
				oci_close($connect);
			}
		}
	
		if(isset($_GET['toWhom'])){				
			$result = oci_parse($connect, "Insert into REPORT (Sender,Receiver, Message) 
			values ('{$_SESSION['username']}','{$_GET['toWhom']}','{$_POST['reason']}')");
			$db = oci_execute($result);		
			oci_close($connect);
			echo "<script language=javascript> alert('Report Sent!');</script>";
			header('Location:home.php');
		}
	?>
	
<?php	
	require_once "includes/footer.html";
?>