<?php
	require_once('includes/connect.php');
	
	$str = $_POST['id'];
	$result = oci_parse($connect, "select * from ITEM where ID='{$str}'");
	$db = oci_execute($result);
	while($row = oci_fetch_array($result))
	{
	echo "<div id = 'viewpad'>
			<form action='bid_item.php?id={$str}' method='post'>";
				if($row['HIGHEST_BID']==NULL){
					echo "<div id='bid_num'>Bid : <input type = 'text' name ='bid_price' value ={$row['PRICE']}> <br/></div>";
				}
				else{
					echo "<div id='bid_num'>Bid : <input type = 'text' name ='bid_price' value ={$row['HIGHEST_BID']}> <br/></div>";
				}
				echo"			
				<input type = 'submit' value='Bid'/>
					<a href='home.php'><input type='Submit' value='Cancel'></a>
			</form>
		</div>";	
	}
	
?>