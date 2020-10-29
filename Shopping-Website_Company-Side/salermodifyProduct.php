<?php 
    ob_start();
    session_start();
	
	require 'normalpage.html';
	
	$now = time();
	$con = mysql_connect('cs-server.usc.edu:61618', 'root','dalin100');
	$db_selection = mysql_select_db("sell",$con); //database
	$res = mysql_query("SELECT * FROM product ORDER BY productID"); //users data 

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
	die('cannot use table'.mysql_error() );
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
		    <div class='content'>
		    		        <h1>Saler Modify Products Page</h1>
		    <div class='data' align='center'>
		    <form name='smodifyproduct' method='POST' action='salermodifyProduct.php'>

		        <p>You can only choose one of the following product to modify.</p>
		        <table>
				    <tr>
					<th>Product ID</th>
					<th>Product Name</th>
					<th>Product Category ID</th>
					<th>Product Description</th>
					<th>Product Price</th>
					<th>Modify</th>
				    </tr>";
				
				while($row = mysql_fetch_assoc($res)){
				    echo "<tr>";
				    echo "<td>".$row['productID']."</td>";
				    echo "<td>".$row['productname']."</td>";
				    echo "<td>".$row['productcategoryid']."</td>";
				    echo "<td>".$row['description']."</td>";
				    echo "<td>".$row['price']."</td>";
				    echo "<td><input type='submit' name='smodifyProduct' value=".$row['productID']."></td>";
				    echo "</tr>";
				}
echo"
			</table>
			<br>
			<input type='button' value='Return' onClick=\"location.href='saler.php'\"/>
			<input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/>
			</form>
	        </div>
	        </div>
	    </body>
	</html>";

		$modifyP = $_POST['smodifyProduct'];
		if (isset($_POST['smodifyProduct'])) {
				$_SESSION['mpID'] = $modifyP;
				header('Location: modifyProduct.php');
		}

	mysql_close($con);
	ob_flush();	
?>