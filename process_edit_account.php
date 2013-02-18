<html>
<head>
<title>Product Successfully Updated</title>
</head>

<body>
<?php
	echo "<a href='home.php'>HOME</a>&nbsp&nbsp&nbsp";
	echo "Account Successfully Updated";
	$connect1 = oci_connect("ONLINE AUCTION","uplbonlineauction");
	if(!$connect1){
		echo "NOT CONNECTED";
	}
	else{
		if(isSet($_POST['submit'])){
			$t_name = $_POST['studnum'];
			$t_lname = $_POST['lname'];
			$t_fname = $_POST['fname'];
			$t_mname = $_POST['mname'];
			$t_email = $_POST['emailadd'];
			$t_mnum = $_POST['mobile_no'];
			$t_hnum = $_POST['home_no'];
			$t_pwd = md5($_POST['pw']);
			$t_add = $_POST['address'];
			$t_int = $_POST['interests'];	
$file_name = htmlspecialchars($_FILES['the_file']['name']);
			move_uploaded_file($_FILES['the_file']['tmp_name'],"images/".$file_name);
			
			$z = oci_parse($connect1, "UPDATE ACCOUNT SET Lname = '$t_lname', Fname = '$t_fname', Mname = '$t_mname', Email = '$t_email', Mobile_num = '$t_mnum', Home_num = '$t_hnum', Password = '$t_pwd', Address = '$t_add', Interests = '$t_int', Photo= '$file_name' WHERE Username = '$t_name'");
			oci_execute($z, OCI_DEFAULT);
			oci_commit($connect1);
			oci_free_statement($z);
			
			oci_close($connect1);
		}
	}
	
?>


</body>
</html>

