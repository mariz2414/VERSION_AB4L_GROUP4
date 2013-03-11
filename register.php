<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitionals.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>UPLB ONLINE AUCTION</title>
	<link rel="stylesheet" type="text/css" href="main.css"/>
	
</head>

<?php
	require_once('includes/connect.php');	
	
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
	//Function that checks if the string only contains the alphabet
	function checkAlpha(name){
		for(var i=0;i<name.length;i++){
			if((name.charCodeAt(i)>=97 && name.charCodeAt(i) <=122) || (name.charCodeAt(i)>=65 && name.charCodeAt(i) <=90) || name.charCodeAt(i)==32 || name.charCodeAt(i)==46){
				if(i==name.length - 1) return false;
			}
			else{
				return true;
				break;
			}
		}
	}
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
	//Function that checks if the student number has the correct format
	function checkStudnum(name){
		if(name.length!=10){
			return true;
			break;
		}
		else{
			for(var i=0;i<name.length;i++){
				if((i<4 && name.charCodeAt(i)>=48 && name.charCodeAt(i) <=57) || (i==4 && name.charCodeAt(i)==45) || (i>4 && name.charCodeAt(i)>=48 && name.charCodeAt(i) <=57)){
					if(i==name.length - 1) 
						return false;	
					}				
				else{
					return true;
					break;
				}
			}
		}
	}
	//Function that checks if the Mobile number has the correct format
	function checkMobile(name){
		if(name.length!=11){
			return true;
			break;
		}
		else{
			if((name.charCodeAt(0)==48 || name.charCodeAt(0)==32)){
				if((name.charCodeAt(1)==57 || name.charCodeAt(1)==32)){	
					for(var i=2; i<name.length; i++){
						if(name.charCodeAt(i)>=48 && name.charCodeAt(i) <=57){
							if(i == name.length - 1) return false;
						}
						else{
							return true;
							break;
						}
					}
				}
				else{
					return true;
					break;
				}
			}
			else{
				return true;
				break;
			}
		}
	}
	//Function that checks if the Home Phone number has the correct format
	function checkHome(name){
		if(name.length!=8){
			return true;
			break;
		}
		else{
			for(var i=0;i<name.length;i++){
				if((i<3 && name.charCodeAt(i)>=48 && name.charCodeAt(i) <=57) || (i==3 && name.charCodeAt(i)==45) || (i>3 && name.charCodeAt(i)>=48 && name.charCodeAt(i) <=57)){
					if(i==name.length - 1) return false;	
				}				
				else{
					return true;
					break;
				}
			}
		}
	}

	function validateForm(){
		//VARIABLES
		var form = document.createaccount;
		var flag = 0;
			//Student Number/ employee number
			if(!form.studnum.value){
				alert("Please enter your student number or employee number.");
				form.studnum.focus();
				return false;
			}
			else if(checkStudnum(form.studnum.value) && (checkNum(form.studnum.value) || (form.studnum.value).length!=9)){
				alert("Invalid student number or employee number.");
				form.studnum.focus();
				flag = 1;
				return false;
			}
			//Last, First, Middle Name
			if(!form.fname.value){
				alert("Please enter your first name.");
				form.fname.focus();
				return false;
			}
			else if(checkAlpha(form.fname.value)){
				alert("Invalid name.");
				form.fname.focus();
				return false;
			}
			if(!form.lname.value){
				alert("Please enter your last name.");
				form.lname.focus();
				return false;
			}
			else if(checkAlpha(form.lname.value)){
				alert("Invalid name.");
				form.lname.focus();
				return false;
			}
			if(!form.mname.value){
				alert("Please enter your middle name.");
				form.lname.focus();
				return false;
			}
			else if(checkAlpha(form.mname.value)){
				alert("Invalid name.");
				form.lname.focus();
				return false;
			}
			//Email
			if(!form.emailadd.value){
				alert("Please enter your email.");
				form.emailadd.focus();
				return false;
			}
			//Mobile Number
			if(!form.mobile_no.value && !form.home_no.value){
				alert("Please enter either your mobile or phone number.");
				form.mobile_no.focus();
				return false;
			}
			else if(form.mobile_no.value && checkMobile(form.mobile_no.value)){
				alert("Invalid mobile number.");
				form.mobile_no.focus();
				return false;
			}
			//Home Number
			if(!form.mobile_no.value && !form.home_no.value){
				alert("Please enter either your mobile or phone number.");
				form.home_no.focus();
				return false;
			}
			else if(form.home_no.value && checkHome(form.home_no.value)){
				alert("Invalid home number.");
				form.home_no.focus();
				return false;
			}
			//password
			if(!form.pw.value){
				alert("Please enter your password.");
				form.pw.focus();
				return false;
			}
			else if((form.pw.value).length < 6 || (form.pw.value).length > 30){
				alert("Invalid Password.");
				form.pw.focus();
				return false;
			}		
			//confirm password
			if(!form.pw2.value){
				alert("Please confirm your password.");
				form.pw2.focus();
				return false;
			}
			if(form.pw.value!=form.pw2.value){
				alert("Passwords do not match!");
				form.pw2.focus();
				return false;
			}
	}
		
</script>

<body>
	<a href='index.php'>Log-in</a>
	<?php
		if ((!isSet($_GET['page']) || $_GET['page'] == 'home') && !isset($_POST['submit'])){
	?>
	<div id="create_container">
	<div id="left_content">
	
	<form id = 'account' name="createaccount" action = "register.php?page=success" onsubmit="return validateForm();" method="POST" enctype="multipart/form-data">

		<table id = 'catable'>
			<th colspan="2" >Create an Account</th>
			<tr class="label">
				<td colspan="2">Basic Information</td>
			</tr>
			<tr>
				<td><label for="studnum">Student No./ Employee No.</label></td>
				<td class="alt"><input type="text" id="studnum" name="studnum" size="30" autofocus></td>
			</tr>
			<tr>
				<td><label for="fname">First Name</label> </td>
				<td class="alt"><input type="text" id="fname" name="fname" size="30"></td>
			</tr>
			<tr>
				<td><label for="lname">Last Name</label> </td>
				<td><input type="text" id="lname" name="lname" size="30"></td>
			</tr>
			<tr>
				<td><label for="mname">Middle Name</label></td>
				<td><input type="text" id="mname" name="mname" size="30"></td>
			</tr>
			<tr>
				<td colspan="2">Contact Details:</td>
			</tr>
			<tr>
				<td><label for="emailadd">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Email Address</label></td>
				<td><input type="email" id="emailadd" name="emailadd" size="30"></td>
			</tr>
			<tr>
				<td><label for="mobile_no">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Mobile Phone No.</label></td>
				<td><input type="text" id="mobile_no" name="mobile_no" size="30" placeholder="09*********"></td>
			</tr>
			<tr>
				<td><label for="home_no">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Home Phone No.</label></td>
				<td><input type="text" id="home_no" name="home_no" size="30" placeholder="e.g. XXX-XXXX"></td>
			</tr>
			<tr>
				<td><label for="pw">Password</label></td>
				<td><input type="password" id="pw" name="pw" size="30" placeholder="(at least 6 characters)"></td>
			</tr>
			<tr>
				<td><label for="pw2">Confirm Password</label></td>
				<td><input type="password" id="pw2" name="pw2" size="30"></td>
			</tr>
			<tr class="label">
				<td colspan="2">Other Details</td>
			</tr>
			<tr>
				<td><label for="address">Current Address</label></td>
				<td><input type="text" id="address" name="address" size="30"></td>
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
				<td><label for="interests">Interest List:</label></td>
				<td><textarea rows="4" cols="23" id="interests" name="interests" placeholder="List of things that you are interested in buying"></textarea></td>
			</tr>
			<tr>
				<td colspan="2"><center><input type="submit" name="create" value="Submit"></center></td>
			</tr>
			<tr class = 'note'>
				<td colspan="2"> Note: Basic Information are required. You have an option to fill up both mobile and home phone number or just one of them.</td>
			</tr >
			<!--<tr >
			<tr><td></td><td></td></tr>
			<tr><td></td></tr>-->
			<tr class = 'note'>
				<td colspan="2">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspBy creating an account and clicking Submit, you agree to the rules that this site has set and the equivalent consequences of violating them.</td>
			</tr>
		</table>
	</form>
	</div>
	<div id = 'rules'>
		<h4>Rules and regulations:</h4>
		<li>
			<ul>A user should not auction an item he/she does not have.</ul>
		</li>
		<li>
			<ul>A user should not be bogus.</ul>
		</li>
		<li>
			<ul>A user should not upload inappropriate materials.</ul>
		</li>
		<li>
			<ul>A user should not bid an item if he/she does not have the sufficient money.</ul>
		</li>
		<li>
			<ul>A user must have his true information in his/her profile.</ul>
		</li>
		<li>
			<ul>A user must follow the transaction talked about by the two parties.</ul>
		</li>
		
		<br />
		
		<p>Any user who violate these rules may be reported by other users to the administrator via the report button. The administrator has the right to ban or remove the user from using this site.</p>
	

	<?php } ?>
	<?php
	
	$user;
		
	//inserting into database
		if(isSet($_POST['create'])&&isSet($_POST['studnum'])&&isSet($_POST['lname'])&&isSet($_POST['fname'])&&isSet($_POST['mname'])&&isSet($_POST['emailadd'])){
			$user = $_POST['studnum'];
			$file_name = htmlspecialchars($_FILES['the_file']['name']);
			move_uploaded_file($_FILES['the_file']['tmp_name'],"images/".$file_name);

			if(!checkExistencePK($_POST['studnum'],'ACCOUNT')){
				insert("Insert into ACCOUNT (Username, Lname, Fname, Mname, Email, Password, Stars, Reports, Banned) values ('".$_POST['studnum']."','".$_POST['lname']."','".$_POST['fname']."','".$_POST['mname']."','".$_POST['emailadd']."','".(md5($_POST['pw']))."',0,0,0)");
				
				if(isSet($_POST['mobile_no'])){	
					insert("update ACCOUNT set Mobile_num = '".$_POST['mobile_no']."' where Username = '".$_POST['studnum']."'");
				}
				if(isSet($_POST['home_no'])){
					insert("update ACCOUNT set Home_num = '".$_POST['home_no']."' where Username = '".$_POST['studnum']."'");
				}
				if(isSet($_POST['address'])){
					insert("update ACCOUNT set Address = '".$_POST['address']."' where Username = '".$_POST['studnum']."'");
				}
				if(isSet($_POST['interests'])){
					insert("update ACCOUNT set Interests = '".$_POST['interests']."' where Username = '".$_POST['studnum']."'");
				}
				if(!empty($_FILES['the_file']['name'])){
					insert("update ACCOUNT set Photo = '".$file_name."' where Username = '".$_POST['studnum']."'");
				}
				else{
					insert("update ACCOUNT set Photo = 'default.jpeg' where Username = '".$_POST['studnum']."'");			
				}
			}
			else{
				echo "<script>alert('Account creation unsuccessful. The student number you entered already has an account!'); window.location = 'register.php' </script>";
			}
		}
		echo "<br /> <br />";
		
		//printing details of newly made account
		if (isSet($_GET['page']) && $_GET['page'] == 'success'){
			print '<h1><center>Account Succesfully Created</center></h1>';
			$user = $_POST['studnum'];
			//$photo = view("select PHOTO from account where (username = '".$user."')");.
		
			/*echo "<div id='image_container'>
				<img src='images/{$photo}' height='200' width='170' id='image'/>
			</div>";*/
			
			print '<table border="1" id="db_table">';
				print '<tr>';
				print '<td colspan=1 >Username</th>';
				view("select username from account where (username = '".$user."')");
				print '</tr>';
				print '<tr>';
				print '<td colspan=1 >Name</th>';
				view("select lname||',', fname, mname from account where (username = '".$user."')");
				print '</tr>';
				print '<tr>';
				print '<td colspan=1 >Email Address</th>';
				view("select email from account where (username = '".$user."')");
				print '</tr>';
				print '<tr>';
				print '<td colspan=1 >Mobile Phone No.</th>';
				view("select mobile_num from account where (username = '".$user."')");
				print '</tr>';
				print '<tr>';
				print '<td colspan=1 >Home Phone Number</th>';
				view("select home_num from account where (username = '".$user."')");
				print '</tr>';
				print '<tr>';
				/*print '<td colspan=1 >Password</th>';
				view("select password from account where (username = '".$user."')");
				print '</tr>';*/
				print '<tr>';
				print '<td colspan=1 >Address</th>';
				view("select address from account where (username = '".$user."')");
				print '</tr>';
				print '<tr>';
				print '<td colspan=1 >Interest List</th>';
				view("select interests from account where (username = '".$user."')");
				print '</tr>';
				
			print '</table>';
			
		}
		
	?>		
		</div>
		<?php require_once('includes/footer.html');?>
</body>
				
</html>