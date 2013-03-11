 <?php
	echo "<div id = 'div_transparent'>";
		require_once('admin_home.php');
	echo "</div>";

	if(isset($_SESSION['userAdmin'])){
		foreach($_SESSION['user_array'] as $str){
			if (isset($_POST[$str])) {
				$result = oci_parse($connect, "select * from ACCOUNT where USERNAME='{$str}'");
				$db = oci_execute($result);
				while($row = oci_fetch_array($result))
				{
				echo "<div id = 'viewpad'>
						<form action='ban_user.php?user={$str}' method='post'>";
							echo "
							Are you sure you want to BAN user {$str}({$row['FNAME']}&nbsp&nbsp{$row['LNAME']})?
							<input type = 'submit' value='Ban'/>
							<a href='admin_home.php'><input type='Submit' value='Cancel'></a>
						</form>
					</div>";	
				}
			}
		}
	}
	else{
		header('Location:admin.php');
	}
?>