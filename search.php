<?php
	if(isSet($_GET['page']) && ($_GET['page']=="name" || $_GET['page']=="id" || $_GET['page']=="owner" || $_GET['page']=="username")){
			echo "<div id = 'div_transparent'>";
				require_once('includes/connect.php');
			echo "</div>";
			
			echo "<div id = 'viewpad'>
					<form action='search.php?search_item={$_GET['page']}' method='post'>	
						<div id='bid_num'>Search : <input type = 'text' name ='searchTerm'/> <br/></div>			
						<input type = 'submit' value='Search' name ='a'/>
							<a href='home.php'><input type='Submit' value='Cancel'></a>
					</form>
				</div>";
	}
	elseif(isSet($_GET['page']) && $_GET['page']=="category"){
			echo "<div id = 'div_transparent'>";
				require_once('home.php');
				require_once('includes/header.html');
				require_once('includes/greeting.php');
				require_once('includes/connect.php');
			echo "</div>";
			
			echo "<div id = 'viewpad'>
					<form action='search.php' method='post'>	
						<select name='category'>
							<option value='apparel'>Apparel</option>
							<option value='appliances'>Appliances</option>
							<option value='books_handouts'>Books and Handouts</option>
							<option value='cars'>Cars</option>
							<option value='furnitures'>Furnitures</option>
							<option value='gadgets'>Gadgets</option>
							<option value='media'>Media</option>
							<option value='pet_care'>Pet Care</option>
							<option value='school_supplies'>School Supplies</option>
							<option value='toys'>Toys</option>
						</select>			
						<input type = 'submit' value='search' name ='a'/>
							<a href='home.php'><input type='Submit' value='Cancel'></a>
					</form>
				</div>";
	}
	else{
		session_start();	
		require_once('includes/header.html');
		require_once('includes/greeting.php');
		require_once('includes/connect.php');
		
		if(isset($_POST['searchTerm'])){
			$searchTerm = $_POST['searchTerm'];
			
			echo "<div id = 'image_gallery'>
			By {$_GET['search_item']}:			
			<div id = 'all_images'>";
			
			if($_GET['search_item']=="username"){
				$arr = array();
				$result = oci_parse($connect, "select * from ACCOUNT where USERNAME like '%" . $searchTerm . "%' ");
				oci_execute($result);
				while($row = oci_fetch_array($result)){
					if (!in_array($row['USERNAME'],$arr)) {
						array_push($arr, $row['USERNAME']);
					}
					echo "
						<div id='image_container'>
							<div id = 'image_buttons'>
							<p id='item_name'>Name: {$row['FNAME']}{$row['LNAME']}</p>
							";
							
							if($row['USERNAME']!=$_SESSION['username']){				
								echo " <form action='report.php' method='post' id='image_button'>
									<input type = 'submit' value='Report' name='{$row['USERNAME']}' id='button'/>
									</form>
								";
							}
							else{
								echo " <input type = 'submit' value='Report' name='{$row['USERNAME']}' id='button' disabled/>";
							}
							
							echo"
							<form action='view_profile.php' method='post' id='image_button'>
								<input type = 'submit' value='View Profile' name='{$row['USERNAME']}'id='button'/>
							</form>
							</div>
							<img src='images/{$row['PHOTO']}' height='200' width='200' id='image'/>
						</div>";
				}
				echo "</div> </div>";
				$_SESSION['button_array'] = $arr;
			}else{
				$arr = array();
				if($_GET['search_item']=="name")
					$result = oci_parse($connect, "select * from ITEM  where NAME like '%" . $searchTerm . "%' ");
				elseif($_GET['search_item']=="id")
					$result = oci_parse($connect, "select * from ITEM  where ID like '%" . $searchTerm . "%' ");
				elseif($_GET['search_item']=="owner")
					$result = oci_parse($connect, "select * from ITEM  where OWNER like '%" . $searchTerm . "%' ");
				
				oci_execute($result);
				while($row = oci_fetch_array($result)){
					if (!in_array($row['ID'],$arr)) {
						array_push($arr, $row['ID']);
					}
					echo "
						<div id='image_container'>
							<img src='itemImages/{$row['PHOTO']}' height='200' width='200' id='image'/>
							<p id='item_name'>Name: {$row['NAME']}</p>
							";
							
							if($row['OWNER']!=$_SESSION['username']){				
								echo " <form action='bid.php' method='post' id='image_button'>
									<input type = 'submit' value='Bid' name='{$row['ID']}' id='button'/>
									</form>
								";
							}
							else{
								echo " <input type = 'submit' value='Bid' name='{$row['ID']}' id='button' disabled/>";
							}
							
							echo"
							<form action='viewdetails.php' method='post' id='image_button'>
								<input type = 'submit' value='View Details' name='{$row['ID']}'id='button'/>
							</form>
						</div>";
				}
				echo "</div> </div>";
				$_SESSION['button_array'] = $arr;
			}
		}
		elseif(isset($_POST['category'])){
			echo "<div id = 'image_gallery'>
			{$_POST['category']}:
			
			<div id = 'all_images'>";
			$arr = array();
			$result = oci_parse($connect, "select * from ITEM where CATEGORY='{$_POST['category']}' ");
			oci_execute($result);
			while($row = oci_fetch_array($result)){
				if (!in_array($row['ID'],$arr)) {
					array_push($arr, $row['ID']);
				}
				echo "
					<div id='image_container'>
						<img src='itemImages/{$row['PHOTO']}' height='200' width='200' id='image'/>
						<p id='item_name'>Name: {$row['NAME']}</p>
						";
						
						if($row['OWNER']!=$_SESSION['username']){				
							echo " <form action='bid.php' method='post' id='image_button'>
								<input type = 'submit' value='Bid' name='{$row['ID']}' id='button'/>
								</form>
							";
						}
						else{
							echo " <input type = 'submit' value='Bid' name='{$row['ID']}' id='button' disabled/>";
						}
						
						echo"
						<form action='viewdetails.php' method='post' id='image_button'>
							<input type = 'submit' value='View Details' name='{$row['ID']}'id='button'/>
						</form>
					</div>";
			}
			echo "</div> </div>";
			$_SESSION['button_array'] = $arr;
		}
	}
?>