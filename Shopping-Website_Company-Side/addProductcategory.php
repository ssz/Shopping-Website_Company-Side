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

echo"
<html>
    <head>
        <link rel='stylesheet' href='css/style.css' type='text/css' >
    </head>
    <body>
	    <div class='content' align='center'>
		    <form name='addproductC' method='POST' action='addProductcategory.php'>
		    <h1>Add a new product category information here.</h1>
		    <p>All fields are required to fill.</p>
		    <table border = '1'>
			    <tr>
				    <td>Product Category Name:</td>
				    <td><input type='text' name='newproCatename' placeholder='new category Name'/></td>
			    </tr>
			    <tr>
				    <td>Product Category Description:</td>
				    <td><input type='text' name='newCatedescrip' placeholder='new description'/></td>
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
			$newproCatename = $_POST['newproCatename'];
			$newCatedescrip = $_POST['newCatedescrip'];
			
			if(empty($newproCatename)){
			    $productCnameError = "Product Name Invalid.";
			}else{
			    $productCnameError = "";
		    }
		    if(empty($newCatedescrip)){
		        $descriptionCError = "Description Invalid";
		    }else{
		        $descriptionCError="";
		    }
            
            if (strlen($newproCatename) == 0 && strlen($newCatedescrip) == 0){
		        $productCnameError = $descriptionCError = "";
		        $ini = true;
		    }else{
		        $ini = false;
		    }

		    if ($productCnameError == "" && $descriptionCError == "" && $ini == false){	
		        $res = mysql_query("INSERT INTO productcategory (productcategoryname, productcategorydes) VALUES ('$newproCatename', '$newCatedescrip')");
			    if(!$res){
				    die('Cannot add user information.');
			    }else{
			        echo"<p>Successfully add a new product category!</p>";  
	            }            
	        }else{
	            echo "<p class='err'>$productCnameError $descriptionCError</p>";
	        }
	        
	echo "
		</div>
	</body>
<html>";	
		
	mysql_close($con);
	ob_flush();	
?>