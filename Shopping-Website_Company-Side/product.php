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
		    <form name='product' method='POST' action='product.php'>
		        <h1>Product Table Page</h1>
                <p>You can add, change and delete product data here.</p>
		        <br>
		        <input type='submit' name='addProduct' value='Add'>
		        <input type='submit' name='modifyProduct' value='Modify'>
		        <input type='submit' name='deleteProduct' value='Delete'>
		        <br><br>
		        <input type='button' value='Return' onClick=\"location.href='saler.php'\"/>
		        <input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/>
			</form>
	        </div>
	    </body>
	</html>";
	    
		if((isset($_POST['addProduct'])&&isset($_POST['modifyProduct'])) || (isset($_POST['addProduct'])&&isset($_POST['deleteProduct'])) ||(isset($_POST['modifyProduct'])&&isset($_POST['deleteProduct']))){
		echo"You can only choose one action. Try again!";
		}else{
		    if (isset($_POST['addProduct'])){
		        header('Location: addProduct.php');
		    }
		    if (isset($_POST['modifyProduct'])){
		        header('Location: salermodifyProduct.php');
		    }
		    if (isset($_POST['deleteProduct'])){
		         header('Location:deleteProduct.php'); 
		    }
		}
      
	mysql_close($con);
	ob_flush();
	
?>