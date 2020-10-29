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
	
	if (!$con){ //does it need here?
	die("Cannot connect to the database.".mysql_error());
	}
	
	if(!$db_selection){ //does it need here?
	die('cannot use table'.mysql_error() );
	}
	
	if(!$res){ //does it need here?
	die('cannot get data');
	}

echo"
<html>
	    <head>
            <link rel='stylesheet' href='css/style.css' type='text/css' >
        </head>
    <body>
        <div class='content' align='center'>
	    <div class='data'>
		    <form name='f3' method='POST' action='adminDeleteuser.php'>
		    <p>Delete employees' information here.</p>
		    <p>Choose employees that you want to delete.</p>
			<!--cannot add, modify, delete the userindex by us.-->
			    <table>
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
				echo "<td><input type='checkbox' name='deleteData[]' value=".$row['userIndex']."></td>";
				//echo "<td><input type='checkbox' name='deleteData[]' value=".$row['userIndex'].">".$row['username']."</td>"; 
				echo "</tr>";
				}

			$deleteE = $_POST['deleteData'];	
			if(isset($_POST['deleteData'])){
			    foreach($deleteE as $deleteData){
			        $res = mysql_query("DELETE FROM users WHERE userIndex = '$deleteData'");	
				    if (!$res) {
					    die("Cannot delete the account '$deleteData'");
					}else{
				        //$ress=mysql_query("UPDATE users WHERE userIndex = '$deleteData'");	
				        echo "<p>Sucessfully Delete!</p>";
				        header('Location:admin.php');
				        //update current page?
				    }
			    }
			}
	echo"
                </table>
                <input type='submit' value='Submit'/>
                <input type='reset' value='Reset' style='position: bottom'/>
			    <input type='button' value='Return' onClick=\"location.href='admin.php'\"/>
			    <input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/> 
			</form>
	        </div>
	        </div>
	    </body>
	</html>";
						
	mysql_close($con);
	ob_flush();	
	
?>	
		
		
		
		
		
		
		
		
