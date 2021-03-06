<?php
	session_start();
	if(isset($_SESSION['username'])){
		require_once('includes/connect.php');
		require_once('includes/header.html');
	}
	else{
		header('Location:index.php');
	}
	
	function insert($query){	
		$connect = oci_connect(WORKSPACE,PASSWORD) or	die('Could not connect to Oracle: ' . var_dump(oci_error())); 
		$stid = oci_parse($connect, $query);
		$r = oci_execute($stid) or die ('error: ' . var_dump(oci_error()));
	}
	
	function view($query){
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


<body>
	<?php

	$stid = oci_parse($connect, "select BANNED from ACCOUNT where (username = '".$_SESSION['username']."')");
		$r = oci_execute($stid);
		
		$row = oci_fetch_row($stid);
		
		if($row[0] == 1){
			$_SESSION['flag'] = 1;
			header('Location:home.php');
		}
	

	if ((!isSet($_GET['page']) || $_GET['page'] == 'home') && !isset($_POST['submit'])){
	?>
	<form name="addItem" action = "add_item.php?page=success" onsubmit="return validateForm();" method="POST" enctype="multipart/form-data">
		<table>
			<th colspan="2" >Sell an Item Online!</th>
			<tr>
				<td colspan="2">Item Information</td>
			</tr>
			<tr>
				<td><label for="studnum">Item Name</label></td>
				<td class="alt"><input type="text" id="itemName" name="itemName" size="30" placeholder="name" required="required" autofocus></td>
			</tr>
			<tr>
				<td><label for="fname">Description</label> </td>
				<td class="alt"><input type="text" id="itemDescription" name="itemDescription" placeholder="description" required="required" size="30"></td>
			</tr>
			<tr>
				<td><label for="fname">Price</label> </td>
				<td class="alt"><input type="number" min="1" max="100000" id="itemPrice" name="itemPrice" placeholder="price" required="required" size="30"></td>
			</tr>
			<tr>
				<td>Category:</td>
				<td>
					<select name="category">
						<option value="apparel">Apparel</option>
						<option value="appliances">Appliances</option>
						<option value="art">Art</option>
						<option value="books_handouts">Books and Handouts</option>
						<option value="cars">Cars</option>
						<option value="furnitures">Furnitures</option>
						<option value="gadgets">Gadgets</option>
						<option value="memorabilia">Memorabilia</option>
						<option value="others">Others</option>
						<option value="pet">Pet</option>
						<option value="pet_care">Pet Care</option>
						<option value="school_supplies">School Supplies</option>
						<option value="toys">Toys</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Upload Photo</td>
				<td>	
					<div id="add_file">	
						<input type="file" name="the_file" id="file"/>
					</div>
				</td>
			</tr>
			<tr></tr><tr></tr><tr></tr><tr></tr>
			<tr>
				<td colspan="2"> Note: All Item Information are required.</td>
			</tr>
			<tr>
			<tr><td></td><td></td></tr>
			<tr><td></td></tr>
			<tr>
				<td colspan="2">By clicking Submit, you agree to the rules that this site has set and the equivalent consequences of violating them.</td>
			</tr>
			<tr>
				<td colspan="2"><center><input type="submit" name="create" value="Submit"></center></td>
			</tr>
		</table>
	</form>
	<?php } ?>
	<?php
	
	$user;
	
	//inserting into database
		if(isSet($_POST['create'])&&isSet($_POST['itemName'])&&isSet($_POST['itemPrice'])&&isSet($_POST['itemDescription'])&&!empty($_FILES['the_file']['name'])){
			$file_name = htmlspecialchars($_FILES['the_file']['name']);
			move_uploaded_file($_FILES['the_file']['tmp_name'],"itemImages/".$file_name);
			insert("Insert into ITEM (Name, Description, Price, ID, Photo, Category, Owner, Notification, boughtby,FINISHEDRATING) 
			values ('".$_POST['itemName']."','".$_POST['itemDescription']."','".$_POST['itemPrice']."', ITEM_NUM.nextval,'".$file_name."', '".$_POST['category']."', '".$_SESSION['username']."', 'false', '-', 0)");
		}

		//printing details item
		if (isSet($_GET['page']) && $_GET['page'] == 'success'){
			print 'Item Now in Sale!';
			
			print '<table border="1" id="db_table">';
				print '<tr>';
				print '<td colspan=1 >Item Name : </th>';
				//view("select username from account where (itemID = '".$user."')");
				
				// ndi ko alam kung anong itsura nito, kaya eto nalang ginawa ko. XD
			
				print $_POST['itemName'];
				print '</tr>';
				print '<tr>';
				print '<td colspan=1 >Price : </th>';
				//view("select lname||',', fname, mname from account where (itemID = '".$user."')");
				print $_POST['itemDescription'];
				print '</tr>';
				print '<tr>';
				print '<td colspan=1 >Description : </th>';
				//view("select email from account where (itemID = '".$user."')");
				print $_POST['itemPrice'];
				print '</tr>';
				print '<tr>';
			print '</table>';
			print '<a href="home.php"> Back to home </a>';
		}
		
			require_once('includes/footer.html');
	?>			
</body>
				
</html>