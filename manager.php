<?php
	ob_start();
	session_start();
	$now = time();
	
	if((!$_SESSION['loginsuccess']) || ($_SESSION['usertype'] != 1)) {
		header('Location: login.php');
	}
    if ($now > $_SESSION['expire']) {
		session_destroy();
		header('Location: logout.php');
	}
	require 'normalpage.html';
	
echo"
<html>
    <head>
        <link rel='stylesheet' href='css/style.css' type='text/css' >
    </head>
    <body>	
	<div class='content' align='center'>
	    <p>Welcome to Manager Home Page!</p>
		<p>Please select one of the tables to search and view.</b>
		<form name='Manager' method='POST' action='manager.php'>
			<input type='submit' name='Users' value='Users'/>
			<input type='submit' name='Products' value='Products'/>
			<input type='submit' name='Category' value='Category'/>
			<input type='submit' name='SpecialSales' value='SpecialSales'/>
			<input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/>
		</form>
	</div>
	</body>
</html>";
    
		    if (isset($_POST['Users'])){
		        header('Location: usertable.php');
		    }
		    if (isset($_POST['Products'])){
		        header('Location: producttable.php');
		    }
		    if (isset($_POST['SpecialSales'])){
		         header('Location:specialsalestable.php'); 
		    }
		    if (isset($_POST['Category'])){
		         header('Location:productcategorytable.php'); 
		    }      

	ob_flush();
?>