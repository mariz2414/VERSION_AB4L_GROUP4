<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitionals.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>UPLB ONLINE AUCTION</title>
	<link rel="stylesheet" type="text/css" href="main.css"/>
	
</head>

<?php
session_start();
$search = $_SESSION['username'];
$connect1 = oci_connect("ONLINE AUCTION","uplbonlineauction");
$query = "SELECT * FROM ACCOUNT where Username = '$search'";
		$whole = oci_parse($connect1, $query);
		oci_execute($whole, OCI_DEFAULT);
		$error1 = oci_error($whole);
		if($error1){
			echo $error1['message'];
			oci_rollback($connect1);
			
		}else{
			$row1 = oci_fetch_array($whole, OCI_DEFAULT);
            
			$t_name = $row1['USERNAME'];
            $t_lname = $row1['LNAME'];
            $t_fname = $row1['FNAME'];
			$t_mname = $row1['MNAME'];
			$t_email = $row1['EMAIL'];
			if(isSet($row1['MOBILE_NUM']))
				$t_mnum = $row1['MOBILE_NUM'];
			if(isSet($row1['HOME_NUM']))
				$t_hnum = $row1['HOME_NUM'];
            $t_pwd = $row1['PASSWORD'];
			if(isSet($row1['INTERESTS']))
				$t_int = $row1['INTERESTS'];
			if(isSet($row1['ADDRESS']))
				$t_add = $row1['ADDRESS'];
			
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
		var form = document.edit_account;
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
	<a href='home.php'>HOME</a>
	<center>
		<form name="edit_account" action="process_edit_account.php" onsubmit="return validateForm();" method="POST">
        	<table>
            <tr>
				<td colspan="2">Basic Information</td>
			</tr>
			<tr>
				<td><label for="studnum">Student No./ Employee No.</label></td>
				<td class="alt"><input type="text" id="studnum" name="studnum" size="30" value="<?php echo $t_name?>", readonly ="readonly" autofocus></td>
			</tr>
			<tr>
				<td><label for="fname">First Name</label> </td>
				<td class="alt"><input type="text" id="fname" name="fname" size="30" value="<?php echo $t_fname?>"></td>
			</tr>
			<tr>
				<td><label for="lname">Last Name</label> </td>
				<td><input type="text" id="lname" name="lname" size="30" value="<?php echo $t_lname?>"></td>
			</tr>
			<tr>
				<td><label for="mname">Middle Name</label></td>
				<td><input type="text" id="mname" name="mname" size="30" value="<?php echo $t_mname?>"></td>
			</tr>
			<tr>
				<td colspan="2">Contact Details:</td>
			</tr>
			<tr>
				<td><label for="emailadd">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Email Address</label></td>
				<td><input type="email" id="emailadd" name="emailadd" size="30" value="<?php echo $t_email?>"></td>
			</tr>
			<tr>
				<td><label for="mobile_no">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Mobile Phone No.</label></td>
				<td><input type="text" id="mobile_no" name="mobile_no" size="30" value="<?php if(isSet($t_mnum)) echo $t_mnum?>"></td>
			</tr>
			<tr>
				<td><label for="home_no">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Home Phone No.</label></td>
				<td><input type="text" id="home_no" name="home_no" size="30" value="<?php if(isSet($t_hnum))echo $t_hnum?>"></td>
			</tr>
			<!--<tr>
				<td><label for="pw">Old Password</label></td>
				<td><input type="password" id="oldpw" name="oldpw" size="30"></td>
			</tr>-->
			<tr>
				<td><label for="pw">New Password</label></td>
				<td><input type="password" id="pw" name="pw" size="30"></td>
			</tr>
			<tr>
				<td><label for="pw2">Confirm Password</label></td>
				<td><input type="password" id="pw2" name="pw2" size="30"></td>
			</tr>
			<tr>
				<td colspan="2">Other Details</td>
			</tr>
			<tr>
				<td><label for="address">Current Address</label></td>
				<td><input type="text" id="address" name="address" size="30" value="<?php if(isSet($t_add)) echo $t_add ?>"></td>
			</tr>
			<tr>
				<td>Update Photo</td>
				<td>	
					<div id="add_file">	
						<input type="file" name="the_file" id="file"/>
					</div>
				</td>
			</tr>
			<tr>
				<td><label for="interests">Interest List:</label></td>
				<td><textarea rows="6" cols="23" id="interests" name="interests" value="<?php if(isSet($t_int)) echo $t_int ?>" placeholder = "list of thing that you are interested in buying"></textarea></td>
			</tr>
			<tr>
				<td colspan="2"> Note: Basic Information are required. You have an option to fill up both mobile and home phone number or just one of them.</td>
			</tr>
			 <tr>
            	<td><input type="submit" value="Submit"/></td>
            </tr>
            </table>
		</form>
	</center>
</body>
</html>