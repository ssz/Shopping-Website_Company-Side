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
	die('Cannot use table'.mysql_error() );
	}

echo"
<html>
    <head>
        <link rel='stylesheet' href='css/style.css' type='text/css' >
    </head>
    <body>
	    <div class='content' align='center'>
		    <form name='modifyproductC' method='POST' action='modifyProductcategory.php'>
		    <h1>Modify product categorys' information here.</h1>
		    <p>Current stored information: </p> 
		    <div class='data'>
		    <table>
				<tr>
					<th>Product Category ID</th>
					<th>Product Category Name</th>
					<th>Product Category Description</th>
				</tr>";
				
		
				$modifyPC = $_SESSION['mpcID'];
				$res = mysql_query("SELECT * FROM productcategory WHERE productcategoryid = '$modifyPC'");
				if (!$res){
				    die("Cannot get this product category ".$modifyPC.".");
				}
				$row = mysql_fetch_assoc($res);
				if(!$row){
				    die("Cannot get data ");
				}else{
				echo "<tr>";
				echo "<td>".$row['productcategoryid']."</td>";
				echo "<td>".$row['productcategoryname']."</td>";
				echo "<td>".$row['productcategorydes']."</td>";
				echo "</tr>";
				}
echo"				
		    </table>
		    </div>
            <p>Fill the blanks and modify information.</p>
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
		</form>";

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
		        $res = mysql_query("UPDATE productcategory SET productcategoryname='$newproCatename', productcategorydes='$newCatedescrip' WHERE productcategoryid='$modifyPC' ");
			    if(!$res){
				    die('Cannot modify product category information.');
			    }else{
			        echo"<p>Successfully modify the product category!</p>";  
	            }            
	        }else{
	            echo "<p class='err'>$productCnameError $escriptionCError</p>";
	        }
	        
	        
	echo "
		</div>
	</body>
<html>";	

	mysql_close($con);
	ob_flush();	
?>