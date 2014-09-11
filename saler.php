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
		    <form name='saler' method='POST' action='saler.php'>
		        <h1>Sales Manager Home Page</h1>
		        <h2>Welcome Sales Manager:".$_SESSION['username']."</h2>
                <p>Choose One Table:</p>
		        <br>
		        <input type='submit' name='product' value='Product'>
		        <input type='submit' name='productCategory' value='Category'>
		        <input type='submit' name='specialSale' value='SpecialSale'>
		        <input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/>
		        <br><br>";
	    

		if((isset($_POST['product'])&&isset($_POST['productCategory'])) || (isset($_POST['product'])&&isset($_POST['specialSale'])) ||(isset($_POST['productCategory'])&&isset($_POST['specialSale']))){
		echo"You can only choose one Table!";
		}else{
		    if (isset($_POST['product'])){
		        header('Location: product.php');
		    }
		    if (isset($_POST['productCategory'])){
		        //$_SESSION[muser]=$_POST['modifyData'];
		        header('Location: productCategory.php');
		    }
		    if (isset($_POST['specialSale'])){
		        //$uid = $_POST['deleteData'];
		         header('Location:specialSale.php'); 
		    }
		}
  
echo"
			</form>
	        </div>
	    </body>
	</html>";  
  
      
	mysql_close($con);
	ob_flush();
	
	
?>