<?php	
	echo "<div id='div_transparent'>";
		require_once('home.php');
	echo "</div>";
	
	if(!isset($_SESSION['username'])){
		header('Location:index.php');
	}
		

	echo "<div id = 'notif_pad'>
			<table border='1' cellpadding='27'>
				<tr>
					<td>&nbsp&nbsp&nbspItem</td>
					<td>Highest Bid</td>
					<td>Highest Bidder</td>
				</tr>";
	$arr = array();
	
	
	$stmt = oci_parse($connect, "select * from REPORT where RECEIVER='{$_SESSION['username']}'");
					oci_execute($stmt);
					$count = 0;
					while($row = oci_fetch_array($stmt)){
						++$count;
					}
	$restrt = oci_parse($connect, "select * from ITEM where NOTIFICATION='true' and OWNER='{$_SESSION['username']}'");
	oci_execute($restrt);
	
	while($row = oci_fetch_array($restrt)){
		if (!in_array($row['ID'],$arr)) {
			array_push($arr, $row['ID']);
		}
		echo "
				<form action='notification_process.php' method='POST'>";
					
		echo"
					
						<td><input type='radio' name='{$row['ID']}' value='{$row['NAME']}'/> {$row['NAME']}</td>
						<td>P{$row['HIGHEST_BID']}</td>
						<td>{$row['HIGHEST_BIDDER']}";
						$restrt2 = oci_parse($connect, "select * from ACCOUNT where USERNAME='{$row['HIGHEST_BIDDER']}'");
						oci_execute($restrt2);
						while($row = oci_fetch_array($restrt2)){
							echo"<a href='mailto:{$row['EMAIL']}?subject=I will accept your bid
							&body=Please send me the details of where our transaction will occur. Thank you!'> (Email)</a></td>
					</tr>";
						}		
						
	}
	$_SESSION['radio_array'] = $arr;
	if(oci_num_rows($restrt)== 0){
		echo "<input type='submit' value='Submit' id='notif_button' disabled>";
	}
	else{
		echo "<input type='submit' value='Submit' id='notif_button'>";
	}
	
echo"	<a href='home.php'><input type='Submit' value='Cancel' id='notif_button2'></a>
				</form></table>
			reports: {$count}
		</div>";

?>