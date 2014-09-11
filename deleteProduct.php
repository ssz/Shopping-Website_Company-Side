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
		    <form name='deleteproduct' method='POST' action='deleteProduct.php'>

		    <p>Choose products that you want to delete.</p>
		        <table>
				    <tr>
					<th>Product ID</th>
					<th>Product Name</th>
					<th>Product Category ID</th>
					<th>Product Description</th>
					<th>Product Price</th>
					<th>Delete(by ProductID)</th>
				    </tr>";
				
				while($row = mysql_fetch_assoc($res)){
				echo "<tr>";
				echo "<td>".$row['productID']."</td>";
				echo "<td>".$row['productname']."</td>";
				echo "<td>".$row['productcategoryid']."</td>";
				echo "<td>".$row['description']."</td>";
				echo "<td>".$row['price']."</td>";
				echo "<td><input type='checkbox' name='deletepro[]' value=".$row['productID']."></td>";
				//echo "<td><input type='checkbox' name='deleteData' value=".$row['userindex'].">".$row['username']."</td>"; 
				echo "</tr>";
				}


			$deleteP = $_POST['deletepro'];
			if(isset($_POST['deletepro'])){
				foreach($deleteP as $deletepro){	
				    $res = mysql_query("DELETE FROM product WHERE productID = '$deletepro'");		
				    if (!$res) {
					    die("Cannot delete the product '$deletepro'");
				    }else{
				        echo "<p>Sucessfully Delete the Product!</p>";
				        header('Location:product.php');
				    }
				    //After delete from product table, chech whether there are the same product in the 
				    //special sale table. If yes, delete it from special sale table.
				    $sres = mysql_query("SELECT * FROM specialsale WHERE productID = '$deletepro'"); 
					if(mysql_fetch_assoc($sres)){
					    $sres = mysql_query("DELETE FROM specialsale WHERE productID = '$deletepro'");	
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