<?php 
    ob_start();
    session_start();
	
	require 'normalpage.html';
	
	$now = time();
	$con = mysql_connect('cs-server.usc.edu:61618', 'root','dalin100');
	$db_selection = mysql_select_db("sell",$con); //database
	
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
	    die('Cannot use table'.mysql_error());
	}

echo"
<html>
    <head>
        <link rel='stylesheet' href='css/style.css' type='text/css' >
    </head>
    <body>
	    <div class='content'  align='center'>
		    <form name='modifyproduct' method='POST' action='modifyProduct.php'>
		    <p>Modify products' information here.</p>
		    <p>Current stored information: </p> 
		    <div class='data'>
		    <table border = '1'>
				<tr>
					<th>Product ID</th>
					<th>Product Name</th>
					<th>Product Category ID</th>
					<th>Product Description</th>
					<th>Product Price</th>
				    </tr>
				</tr>";
				
				
				$modifyP = $_SESSION['mpID'];
				$res = mysql_query("SELECT * FROM product WHERE productID = '$modifyP'");
				if (!$res){
				    die("Cannot get this user account ".$modifyP.".");
				}
				$row = mysql_fetch_assoc($res);
				if(!$row){
				    die("Cannot get data ");
				}else{
				echo "<tr>";
				echo "<td>".$row['productID']."</td>";
				echo "<td>".$row['productname']."</td>";
				echo "<td>".$row['productcategoryid']."</td>";
				echo "<td>".$row['description']."</td>";
				echo "<td>".$row['price']."</td>";
				echo "</tr>";
				}
echo"				
		    </table>
		    </div>
            <p>Fill the blanks and modify information.</p>
            <table border = '1'>
			    <tr>
				    <td>Product Name:</td>
				    <td><input type='text' name='newproductname' placeholder='new product name'/></td>
			    </tr>
			    <tr>
				    <td>Product Category ID:</td>
				    <td>
				    <select name='newproductcategoryid'>";
				    $tempres= mysql_query("SELECT * FROM productcategory ORDER BY productcategoryid");// need productcategoryname?
	                if(!$tempres){
	                    die('cannot use data'.mysql_error() );
	                }
				    while($trow = mysql_fetch_assoc($tempres)){
                        echo"<option value=".$trow['productcategoryid'].">".$trow['productcategoryid'].": ".$trow['productcategoryname']."</option>";
				    }
echo"             
			        </select>
			        </td>
			    </tr>
			    <tr>
				    <td>Product Description:</td>
				    <td><input type='text' name='newdescription' placeholder='new description'/></td>
			    </tr>
			    <tr>
				    <td>Product Price:</td>
				    <td><input type='text' name='newprice' placeholder='new price'/></td>
			    </tr>
			</table>
			<input type='submit' value='Submit'/>
			<input type='reset' value='Reset'/>
			<input type='button' value='Return' onClick=\"location.href='saler.php'\"/>
			<input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/><br><br>
			
		</form>";

            //store the input data.	
			//validation of input, then push them into database.
			$newproductname = $_POST['newproductname'];
			$newproductcategoryid = $_POST['newproductcategoryid'];
			$newdescription = $_POST['newdescription'];
			$newprice = $_POST['newprice'];
			
			if(empty($newproductname)){
			    $productnameError = "Product Name Invalid.";
			}else{
			    $productnameError = "";
		    }
			if(empty($newproductcategoryid)){
				$productcategoryidError = "Product Category ID Invalid.";
			}else{
			    $productcategoryidError = "";
		    }
		    if(empty($newdescription)){
		        $descriptionError = "Description Invalid";
		    }else{
		        $descriptionError="";
		    }
		    if(empty($newprice) || !is_numeric($newprice)){
		        $newpriceError = "Price Invalid";
		    }else{
		        $newpriceError="";
		    }
            
            if (strlen($newproductname) == 0 && strlen($newproductcategoryid) == 0 && strlen($newdescription) == 0 && strlen($newprice) == 0 ) {
		        $productnameError = $productcategoryidError = $descriptionError = $newpriceError = "";
		        $ini = true;
		    }else{
		        $ini = false;
		    }

		    if ($productnameError == "" && $productcategoryidError == "" && $descriptionError == "" && $newpriceError == "" && $ini == false){	
		        $res = mysql_query("UPDATE product SET productname='$newproductname', productcategoryid='$newproductcategoryid', description='$newdescription', price='$newprice' WHERE productID='$modifyP' ");
			    if(!$res){
				    die('Cannot modify user information.');
			    }else{
			        echo"<p>Successfully modify a product!</p>";  
	            }            
	        }else{
	            echo "<p class='err'>$productnameError $productcategoryidError $descriptionError $newpriceError</p>";
	        }
	        
	echo "
		</div>
	</body>
<html>";	

	mysql_close($con);
	ob_flush();	
?>