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
		header('Location:logout.php');
	}
	
	if (!$con){ //does it need here?
	die("Cannot connect to the database.".mysql_error());
	}
	
	if(!$db_selection){ //does it need here?
	die('cannot use table'.mysql_error() );
	}
	
	$tempres= mysql_query("SELECT * FROM productcategory ORDER BY productcategoryid");// need productcategoryname?
	if(!$tempres){
	die('cannot use data'.mysql_error() );
	}

echo"
<html>
    <head>
        <link rel='stylesheet' href='css/style.css' type='text/css' >
    </head>
    <body>
	    <div class='content' align='center'>
		    <form name='addproduct' method='POST' action='addProduct.php'>
		    <p>Add a new product's information here.</p>
		    <p>All fields are required to fill.</p>
		    <table border = '1'>
			    <tr>
				    <td>Product Name:</td>
				    <td><input type='text' name='newproductname' placeholder='new product name'/></td>
			    </tr>
			    <tr>
				    <td>Product Category ID:</td>
				    <td>
				    <select name='newproductcategoryid'>";
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
			<br>
			<input type='submit' value='Submit'/>
			<input type='reset' value='Reset'/>
			<input type='button' value='Return' onClick=\"location.href='saler.php'\"/>
			<input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/><br><br>
			</form>
";
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
		        $res = mysql_query("INSERT INTO product (productname, productcategoryid, description, price) VALUES ('$newproductname', '$newproductcategoryid', '$newdescription', '$newprice')");
			    if(!$res){
				    die('Cannot add user information.');
			    }else{
			        echo"<p>Successfully add a new product.</p>";  
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