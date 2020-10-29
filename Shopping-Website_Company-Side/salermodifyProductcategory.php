<?php 
    ob_start();
    session_start();
	
	require 'normalpage.html';
	
	$now = time();
	$con = mysql_connect('cs-server.usc.edu:61618', 'root','dalin100');
	$db_selection = mysql_select_db("sell",$con); //database
	$res = mysql_query("SELECT * FROM productcategory ORDER BY productcategoryid"); //users data 

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
		    <div class='content' align='center'>
		    <form name='smodifyproductC' method='POST' action='salermodifyProductcategory.php'>
		        <h1>Saler Modify Products Category Page</h1>
		        <p>You can only choose one of the following product category to modify.</p>
		        <div class='data'>
		        <table border = '1'>
				    <tr>
					<th>Product Category ID</th>
					<th>Product Category Name</th>
					<th>Product Category Description</th>
					<th>Modify(by category ID)</th>
				    </tr>";
				
				while($row = mysql_fetch_assoc($res)){
				echo "<tr>";
				echo "<td>".$row['productcategoryid']."</td>";
				echo "<td>".$row['productcategoryname']."</td>";
				echo "<td>".$row['productcategorydes']."</td>";
				echo "<td><input type='submit' name='smodifyProductC' value=".$row['productcategoryid']."></td>";
				echo "</tr>";
				}
echo"
			</table>
			</div>
			<input type='button' value='Return' onClick=\"location.href='saler.php'\"/>
            <input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/>
			</form>
	        </div>
	    </body>
	</html>";

		$modifyPC = $_POST['smodifyProductC'];
		if (isset($_POST['smodifyProductC'])) {
				$_SESSION['mpcID'] = $modifyPC;
				header('Location: modifyProductcategory.php');
		}

	mysql_close($con);
	ob_flush();	
?>