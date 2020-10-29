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
        <h1>Delete products' information here.</h1>
	    <div class='data'>
		    <form name='deleteproductC' method='POST' action='deleteProductcategory.php'>

		    <p>Choose products that you want to delete.</p>
			    <table border = '1'>
				    <tr>
					<th>Product Category ID</th>
					<th>Product Category Name</th>
					<th>Product Category Description</th>
					<th>Delete(by productcategoryID)</th>
				    </tr>";
				
				while($row = mysql_fetch_assoc($res)){
				echo "<tr>";
				echo "<td>".$row['productcategoryid']."</td>";
				echo "<td>".$row['productcategoryname']."</td>";
				echo "<td>".$row['productcategorydes']."</td>";
				echo "<td><input type='checkbox' name='deleteproC[]' value=".$row['productcategoryid']."></td>";
				echo "</tr>";
				}

			$deletePC = $_POST['deleteproC'];
			
			if(isset($_POST['deleteproC'])){
			    foreach($deletePC as $deleteproC){
                    $rest = mysql_query("DELETE FROM productcategory WHERE productcategoryid = '$deleteproC'");
				    if (!$rest) {
					    die("Cannot delete the account '$deleteproC'");
					}else{
				        //$ress=mysql_query("UPDATE users WHERE employeeID = '$deleteData'");	
				        echo "<p>Sucessfully Delete!</p>";
				        header('Location:productCategory.php');
				    }
			    }
			}
			
			
	echo"
                </table>
                <input type='submit' value='Submit'/>
                <input type='reset' value='Reset'/>
			    <input type='button' value='Return' onClick=\"location.href='saler.php'\"/>
			    <input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/><br><br>
			</form>
	        </div>
	        </div>
	    </body>
	</html>";
						
	mysql_close($con);
	ob_flush();	
	
?>	
		
		
		
		
		
		
		
		
