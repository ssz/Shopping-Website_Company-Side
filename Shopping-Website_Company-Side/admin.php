<?php 
    ob_start();
    session_start();
	
	require 'normalpage.html';
	
	$now = time();
	$con = mysql_connect('cs-server.usc.edu:61618', 'root','dalin100');
	$db_selection = mysql_select_db("sell",$con); //database

	if($_SESSION['loginsuccess'] == false || $_SESSION['usertype']!=0){
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
		    <form name='f1' method='POST' action='admin.php' onSubmit='return submitCheck();'>
		        <h1>Administrator Home Page</h1>
		        <h2>Welcome Administrator: ".$_SESSION['username']."!</h2>
                <p>You can add, change and delete user data here.</p>
		        <input type='submit' name='addData' value='AddUser'/>
		        <input type='submit' name='modifyData' value='ModifyUser'/>
		        <input type='submit' name='deleteData' value='DeleteUser'/>
		        <input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/>
		        <br><br>
			</form>
	        </div>
	    </body>
	</html>";
	    
		// does it need a second validation of $POST???
		if((isset($_POST['changeData'])&&isset($_POST['deleteData'])) || (isset($_POST['deleteData'])&&isset($_POST['addData'])) ||(isset($_POST['addData'])&&isset($_POST['changeData']))){
		echo"You can only choose one action. Try again!";
		}else{
		    if (isset($_POST['addData'])){
		        header('Location: adminAdduser.php');
		    }
		    if (isset($_POST['modifyData'])){
		        //$_SESSION[muser]=$_POST['modifyData'];
		        header('Location: adminModifyuser.php');
		    }
		    if (isset($_POST['deleteData'])){
		        //$uid = $_POST['deleteData'];
		         header('Location:adminDeleteuser.php'); 
		    }
		}
      
	mysql_close($con);
	ob_flush();
	
?>