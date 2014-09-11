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
		    <form name='productC' method='POST' action='productCategory.php'>
		        <h1>Product Category Table Page</h1>
                <p>You can add, change and delete product category data here.</p>
		        <input type='submit' name='addProductC' value='Add'>
		        <input type='submit' name='modifyProductC' value='Modify'>
		        <input type='submit' name='deleteProductC' value='Delete'>
		        <br><br>
		        <input type='button' value='Return' onClick=\"location.href='saler.php'\"/>
		        <input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/><br><br>
			</form>
	        </div>
	    </body>
	</html>";
	    
		// does it need a second validation of $POST???
		if((isset($_POST['addProductC'])&&isset($_POST['modifyProductC'])) || (isset($_POST['addProductC'])&&isset($_POST['deleteProductC'])) ||(isset($_POST['modifyProductC'])&&isset($_POST['deleteProductC']))){
		echo"You can only choose one action. Try again!";
		}else{
		    if (isset($_POST['addProductC'])){
		        header('Location: addProductcategory.php');
		    }
		    if (isset($_POST['modifyProductC'])){
		        //$_SESSION[muser]=$_POST['modifyData'];
		        header('Location: salermodifyProductcategory.php');
		    }
		    if (isset($_POST['deleteProductC'])){
		        //$uid = $_POST['deleteData'];
		         header('Location:deleteProductcategory.php'); 
		    }
		}
      
	mysql_close($con);
	ob_flush();
	
?>