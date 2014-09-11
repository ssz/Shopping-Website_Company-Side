<?php 
    ob_start();
    session_start();
	
	require 'normalpage.html';
	
	$now = time();
	$con = mysql_connect('cs-server.usc.edu:61618', 'root','dalin100');
	$db_selection = mysql_select_db("sell",$con); //database
	$res = mysql_query("SELECT * FROM users"); //users data 

	if($_SESSION['loginsuccess'] == false || $_SESSION['usertype']!=0){
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
		    <div class='data' align='center'>
		    <form name='f4' method='POST' action='adminModifyuser.php'>
		        <h1>Administrator Modify Users Page</h1>
		        <p>You can only choose one of the following user to modify.</p>
		        <table style='text-align:center'>
				    <tr>
					<th>userIndex</th>
					<th>Username</th>
					<th>Usertype</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Age</th>
					<th>Payment</th>
					<th>Delete</th>
				    </tr>";
				
				while($row = mysql_fetch_assoc($res)){
				echo "<tr>";
				echo "<td>".$row['userIndex']."</td>";
				echo "<td>".$row['username']."</td>";
				echo "<td>".$row['usertype']."</td>";
				echo "<td>".$row['firstname']."</td>";
				echo "<td>".$row['lastname']."</td>";
				echo "<td>".$row['age']."</td>";
				echo "<td>".$row['payment']."</td>";
				echo "<td><input type='submit' name='modifyData' value=".$row['userIndex']."></td>";
				echo "</tr>";
				}
echo"
				</table>
			<input type='button' value='Return' onClick=\"location.href='admin.php'\"/> 
			<input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/>
			</form>
	        </div>
	        </div>
	    </body>
	</html>";

		$modifyE = $_POST['modifyData'];
		if (isset($_POST['modifyData'])) {
				$_SESSION['meID'] = $modifyE;
				header('Location: Modifyuser.php');
		}

	mysql_close($con);
	ob_flush();	
?>