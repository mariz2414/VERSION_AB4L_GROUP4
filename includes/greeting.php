<?php
	echo "<div id = 'contents'>";
	echo "<br /><br /><p>You are logged in as <a href='profile.php'>".htmlspecialchars($_SESSION['fname'])."&nbsp".($_SESSION['lname'])."</a>";
	echo " | <a href='logout.php' >Logout</a></p></div>";	//target='_blank'
?>