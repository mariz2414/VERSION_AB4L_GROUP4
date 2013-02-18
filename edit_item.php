<?php
	session_start();
	require_once('includes/connect.php');
	require_once('includes/header.html');
	
	function insert($query){	
		$connect = oci_connect('ONLINE AUCTION','uplbonlineauction') or	die('Could not connect to Oracle: ' . oci_error());
		$stid = oci_parse($connect, $query);
		$r = oci_execute($stid);
	}

	//function that checks if the student number entered is already in the database
	function checkExistencePK($uniqueKey,$table){
		$connect = oci_connect('ONLINE AUCTION','uplbonlineauction') or	die('Could not connect to Oracle: ' . oci_error());
		$stid = oci_parse($connect, "select * from ".$table);
		$r = oci_execute($stid);

		// Fetch each row in an associative array
		while ($row = oci_fetch_row($stid)) {
			if(!strcmp($row[0],$uniqueKey)){		
				return true;
				break;
			}else{
				continue;
			}
		}
	}
	
	function view($query){
		$connect = oci_connect('ONLINE AUCTION','uplbonlineauction') or	die('Could not connect to Oracle: ' . oci_error());
		$stid = oci_parse($connect, $query);
		$r = oci_execute($stid);

		// Fetch each row in an associative array
		while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
				
			$i=0;
			foreach ($row as $item) {
				print '<td colspan = 3>'.($item !== null ? htmlentities($item, ENT_QUOTES) : '&nbsp').'</td>';
				$i++;
			}
		}
	}
?>

<script type="text/javascript">
	
	//Function that checks if the string only contains numbers
	function checkNum(name){
		for(var i=0;i<name.length;i++){
			if((name.charCodeAt(i)>=48 && name.charCodeAt(i) <=57) || name.charCodeAt(i)==32){
				if(i==name.length - 1) return false;
			}
			else{
				return true;
				break;
			}
		
		}
	}
	
	function validateForm(){
		//VARIABLES
		var form = document.edititem;
		var flag = 0;
			//id and Price
			/*if((checkNum(form.id.value) || (form.id.value).length!=5)){
				alert("Invalid ID number.");
				form.id.focus();
				flag = 1;
				return false;
			}*/
			
			if((checkNum(form.price.value) || (form.price.value).length>6)){
				alert("Invalid Price");
				form.price.focus();
				flag = 1;
				return false;
			}
	}
		
</script>

<body>
	<?php
		if ((!isSet($_GET['page']) || $_GET['page'] == 'home') && !isset($_POST['submit'])){
		
		$search = $_POST['id'];
		$connect1 = oci_connect("ONLINE AUCTION","uplbonlineauction");
		$query = "SELECT * FROM ITEM where Id = '$search'";
		$whole = oci_parse($connect1, $query);
		oci_execute($whole, OCI_DEFAULT);
		$error1 = oci_error($whole);
		if($error1){
			echo $error1['message'];
			oci_rollback($connect1);
		}else{
			$row1 = oci_fetch_array($whole, OCI_DEFAULT);
			$t_name = $row1['NAME'];
            $t_desc = $row1['DESCRIPTION'];
            $t_price = $row1['PRICE'];
			$t_id = $row1['ID'];
            //$t_photo = $row1['PHOTO'];
         }
	?>
	<form name="edititem" action = "edit_item.php?page=success" onsubmit="return validateForm();" method="POST" enctype="multipart/form-data">
		<table>
			<th colspan="2" >Edit Item Info</th>
			<tr>
				<td colspan="2">Basic Information</td>
			</tr>
			<tr>
				<td><label for="name">Name </label></td>
				<td class="alt"><input type="text" id="name" name="name" size="30" placeholder="<?php echo $t_name?>"></td>
			</tr>
			<tr>
				<td><label for="description">Description</label></td>
				<td><textarea rows="6" cols="23" id="description" name="description" placeholder="<?php echo $t_desc?>"></textarea></td>
			</tr>
			<tr>
				<td><label for="price">Price</label> </td>
				<td><input type="text" id="price" name="price" size="30" placeholder="<?php echo $t_price?>"></td>
			</tr>
			<tr>
				<td><label for="id">ID</label> </td>
				<td><input type="text" id="id" name="id" size="30" value="<?php echo $t_id?>" readonly='readonly'></td>
			</tr>
			<tr>
				<td>Upload Photo</td>
				<td>	
					<div id="add_file">	
						<input type="file" name="the_file" id="file"/>
					</div>
				</td>
			</tr>
			<tr>
			<tr><td></td><td></td></tr>
			<tr><td></td></tr>
			<tr>
				<td colspan="2"><center><input type="submit" name="edit" value="Submit"></center></td>
			</tr>
		</table>
	</form>
	
	<?php } ?>
	<?php
	
	$user;
		
	//inserting into database
		if(isSet($_POST['edit'])&&isSet($_POST['id'])&&isSet($_POST['name'])&&isSet($_POST['description'])&&isSet($_POST['price'])){
			$user = $_POST['id'];
			$file_name = htmlspecialchars($_FILES['the_file']['name']);
			move_uploaded_file($_FILES['the_file']['tmp_name'],"images/".$file_name);

			if(!checkExistencePK($_POST['id'],'ITEM')){
				
				if(!empty($_POST['name'])){
					insert("update ITEM set Name = '".$_POST['name']."' where Id = '".$_POST['id']."'");
				}
				
				if(!empty($_POST['description'])){
					insert("update ITEM set Description = '".$_POST['description']."' where Id = '".$_POST['id']."'");
				}
				
				if(!empty($_POST['price'])){
					insert("update ITEM set Price = '".$_POST['price']."' where Id = '".$_POST['id']."'");
				}
				
				if(!empty($_FILES['the_file']['name'])){
					insert("update ITEM set Photo = '".$file_name."' where Id = '".$_POST['id']."'");
				}
			}
			else{
				echo "<script>alert('Item Update Unsuccessful.'); window.location = 'edit_item.php#' </script>";
			}
		}
		
		//printing details of newly made account
		if (isSet($_GET['page']) && $_GET['page'] == 'success'){
			print 'Item Information:';
			
			print '<table border="1" id="db_table">';
				print '<tr>';
				print '<td colspan=1 >Id</th>';
				view("select id from item where (id = '".$user."')");
				print '</tr>';
				print '<tr>';
				print '<td colspan=1 >Name</th>';
				view("select name from item where (id = '".$user."')");
				print '</tr>';
				print '<tr>';
				print '<td colspan=1 >Description</th>';
				view("select description from item where (id = '".$user."')");
				print '</tr>';
				print '<tr>';
				print '<td colspan=1 >Price</th>';
				view("select price from item where (id = '".$user."')");
				print '</tr>';
				
			print '</table>';
			
		}
		require_once('includes/footer.html');
	?>			
</body>
				
</html>