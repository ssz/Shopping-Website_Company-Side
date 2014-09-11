<?php 
    ob_start();
    session_start();
	
	require 'normalpage.html';
	
	$now = time();
	$con = mysql_connect('cs-server.usc.edu:61618', 'root','dalin100');
	$db_selection = mysql_select_db("sell",$con); //database
	$res = mysql_query("SELECT * FROM specialsale"); //users data 

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
		    <form name='deletespecial' method='POST' action='deletespecialSale.php'>
		    <h1>Delete information of special sales here.</h1>
		    <p>Choose special sales that you want to delete.</p>
            <div class='data'>
            <table>
			   	<tr>
					<th>Special Sale ID</th>
					<th>Product ID</th>
					<th>Product Name</th>
					<th>Original Price</th>
					<th>Discount</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Delete</th>
				</tr>";

				//$row = mysql_fetch_assoc($res);
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
				    echo "<td>".$row['discount']."%"."</td>";
				    echo "<td>".$row['startmon'].'/'.$row['startday'].'/'.$row['startyear']."</td>";
				    echo "<td>".$row['endmon'].'/'.$row['endday'].'/'.$row['endyear']."</td>";
				    echo "<td><input type='checkbox' name='deletespecial[]' value=".$row['specialID']."></td>";
				    echo "</tr>";
				}

			$deleteS = $_POST['deletespecial'];
			if (isset($_POST['deletespecial'])){
			    foreach($deleteS as $deletespecial){
			    	$res = mysql_query("DELETE FROM specialsale WHERE specialID = '$deletespecial'");		
				    if (!$res) {
					    die("Cannot delete the product '$deleteS'");
				    }else{
				        echo "<p>Sucessfully Delete the special sale!</p>";
				        header('Location:specialSale.php');
			        }
			    }
			}
				
			
	echo"
                </table>
                </div>
                <br><br>
                <input type='submit' value='Submit'/>
                <input type='reset' value='Reset'/>
			    <input type='button' value='Return' onClick=\"location.href='saler.php'\"/>
			    <input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/><br><br>
			</form>
	        </div>
	    </body>
	</html>";
						
	mysql_close($con);
	ob_flush();	
	
?>	
		
		
		
		
		
		
		
		
