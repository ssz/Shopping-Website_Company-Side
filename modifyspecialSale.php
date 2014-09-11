<?php 
    ob_start();
    session_start();
	
	require 'normalpage.html';
	
	$now = time();
	$con = mysql_connect('cs-server.usc.edu:61618', 'root','dalin100');
	$db_selection = mysql_select_db("sell",$con); //database
	$res = mysql_query("SELECT * FROM specialsale ORDER BY specialID"); //users data 
	
	if($_SESSION['loginsuccess'] == false || $_SESSION['usertype']!=2){
		header('Location:login.php');
	}
	
	if($now > $_SESSION['expire']) {
		session_destroy();
		header('Location: logout.php');
	}
	
	if (!$con){ 
	die("Cannot connect to the database.".mysql_error());
	}
	
	if(!$db_selection){ 
	die('Cannot use table'.mysql_error() );
	}
	
	if(!$res){ 
	die('cannot get data');
	}


echo"
<html>
    <head>
        <link rel='stylesheet' href='css/style.css' type='text/css' >
    </head>
    <body>
	    <div class='content' align='center'>
		    <form name='modifyspecial' method='POST' action='modifyspecialSale.php'>
		    <h1>Modify special sale information here.</h1>
		    <p>Choose the special sale that you want to modify.</p> 
		    <div class='data'>
		    <table border = '1'>
				<tr>
				    <th>Specialsale ID</th>
					<th>Product ID</th>
					<th>Product Name</th>
					<th>Price</th>
					<th>Discount</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Delete</th>
				    </tr>
				</tr>";
				
				while($row = mysql_fetch_assoc($res)){
				    echo "<tr>";
				    echo "<td>".$row['specialID']."</td>";
				    echo "<td>".$row['productID']."</td>";
				    $temp=$row['productID'];
				    
				    $tres = mysql_query("SELECT * FROM product WHERE productID='$temp'");
				    if($rrow = mysql_fetch_assoc($tres)){
				        echo "<td>".$rrow['productname']."</td>";
				        echo "<td>".$rrow['price']."</td>";
				    }
				    
				    //echo "<td>".$row['productname']."</td>";
				    //echo "<td>".$row['price']."</td>";
				    echo "<td>".$row['discount']."</td>";
				    echo "<td>".$row['startmon']."/".$row['startday']."/".$row['startyear']."</td>";
				    echo "<td>".$row['endmon']."/".$row['endday']."/".$row['endyear']."</td>";
				    echo "<td><input type='submit' name='modifyspecial' value=".$row['specialID']."></td>";
				    echo "</tr>";
				}
echo"
			</table>
			</div>
			<br>
			<input type='button' value='Return' onClick=\"location.href='saler.php'\"/>
			<input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/><br><br>
			</form>
	        </div>
	    </body>
	</html>";

		$modifyP = $_POST['modifyspecial'];
		if (isset($_POST['modifyspecial'])) {
				$_SESSION['mpss'] = $modifyP;
				header('Location: modifysale.php');
		}

	mysql_close($con);
	ob_flush();	
?>