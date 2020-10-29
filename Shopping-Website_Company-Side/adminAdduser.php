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
		    <form name='f2' method='POST' action='adminAdduser.php'>
		    <p>Add a new employee's information here. And all fields are required to fill</p>
		    <p>If you login without putting anything and click the submit button, the system treat it as nonthing happened.</p>
		    
		    <table>
			<!--cannot add, modify, delete the userindex by us.-->
            <!--    <tr>
				    <td>Emplyee ID:</td>
				    <td><input type='text' name='newemployeeID' placeholder='new employee ID'/></td>
			    </tr> -->
			    <tr>
				    <td>Username:</td>
				    <td><input type='text' name='newusername' placeholder='new user name'/></td>
			    </tr>
			    <tr>
				    <td>Password:</td>
				    <td><input type='password' name='newpassword' placeholder='new password'/></td>
			    </tr>
			    <tr>
				    <td>Usertype:</td>
				    <td><input type='radio' name='newusertype' value='0'/>Administrator
				        <input type='radio' name='newusertype' value='1'/>Manager
				        <input type='radio' name='newusertype' value='2'/>Employee
				    </td>
			    </tr>
			    <tr>
				    <td>Firstname:</td>
				    <td><input type='text' name='newfirstname' placeholder='new firstname'/></td>
			    </tr>
			    <tr>
				    <td>Lastname:</td>
				    <td><input type='text' name='newlastname' placeholder='new lastname'/></td>
			    </tr>
			    <tr>
				    <td>Age:</td>
				    <td><input type='text' name='newage' maxlength='2' placeholder='at most two digits'/></td>
			    </tr>
			    <tr>
				    <td>Payment:</td>
				    <td><input type='text' name='newpayment' maxlength='5' placeholder='at most five digits'/></td>
			    </tr>
			</table>
			<br>
			<input type='submit' value='Submit'/>
			<input type='reset' value='Reset'/>
			<input type='button' value='Return' onClick=\"location.href='admin.php'\"/>
			<input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/>
			</form>
";
			//store the input data.	
			//validation of input, then push them into database.
			//$newemployeeID = $_POST['newemployeeID'];
			$newusername = $_POST['newusername'];
			$newpassword = $_POST['newpassword'];
			$newusertype = $_POST['newusertype'];
			$newfirstname = $_POST['newfirstname'];
			$newlastname = $_POST['newlastname'];
			$newage = $_POST['newage'];
			$newpayment = $_POST['newpayment'];
			
			/*if (empty($newemployeeID) || !is_numeric($newemployeeID)){
		        $employeeIDError = "Employee ID Invalid. ";
	        }else{
		        $employeeIDError = "";
	        }*/
			if(empty($newusername)){
			    $usernameError = "Username Invalid.";
			}else{
			    $usernameError = "";
		    }
			if(empty($newpassword)){
				$passwordError = "Password Invalid.";
			}else{
			    $passwordError = "";
		    }
		    if($newusertype !="0" && $newusertype!="1" && $newusertype!="2"){
		        $usertypeError = "Usertype Invalid";
		    }else{
		        $usertypeError = "";
		    }
		    if(empty($newfirstname) || is_numeric($newfirstname)){
		        $firstnameError = "Firstname Invalid";
		    }else{
		        $firstnameError="";
		    }
		    if(empty($newlastname) || is_numeric($newlastname)){
		        $lastnameError = "Lastname Invalid";
		    }else{
		        $lastnameError="";
		    }
		    if ((strlen($newage) > 0 && (!is_numeric($newage))) || $newage < 0 || empty($newage)) {
		        $ageError = "Age Invalid. ";
	        }else{
		        $ageError = "";
	        }
	        if ((strlen($newpayment) > 0 && (!is_numeric($newpayment))) || $newpayment < 0 || empty($newpayment)) {
		        $payError = "Pay Invalid. ";
	        }else{
		        $payError = "";
		    }   
            
            //if (strlen($newemployeeID) == 0 && strlen($newusername) == 0 && strlen($newpassword) == 0 && strlen($newfirstname) == 0 && strlen($newlastname) == 0 && strlen($newage) == 0 && strlen($newusertype) == 0 && strlen($newpayment) == 0) {
		    if (strlen($newusername) == 0 && strlen($newpassword) == 0 && strlen($newfirstname) == 0 && strlen($newlastname) == 0 && strlen($newage) == 0 && strlen($newusertype) == 0 && strlen($newpayment) == 0) {   
		        //$employeeIDError = $usernameError = $passwordError = $usertypeError = $ageError = $payError = "";
		        $usernameError = $passwordError = $usertypeError = $ageError = $payError = "";
		        $ini = true;
		    }else{
		        $ini = false;
		    }

		    //if ($employeeIDError=="" && $usernameError == "" && $passwordError == "" && $usertypeError == "" && $ageError == "" && $payError == "" && $ini == false){
		    if ($usernameError == "" && $passwordError == "" && $usertypeError == "" && $ageError == "" && $payError == "" && $ini == false){	
		        $res = mysql_query("INSERT INTO users (username, password, usertype, firstname, lastname, age, payment) VALUES ('$newusername', password('$newpassword'), '$newusertype', '$newfirstname', '$newlastname', '$newage', '$newpayment')");
			    if(!$res){
				    die('Cannot add user information.');
			    }else{
			        echo"<p>Successfully add a new user account.</p>"; 
			        //header('Location:admin.php'); 
	            }            
	        }else{
	            //echo $employeeIDError;
	            echo "<br><br><p class='err'>$usernameError $passwordError $usertypeError $ageError $payError</p>";
	        }
	        
	echo "
		</div>
	</body>
<html>";	
		
	mysql_close($con);
	ob_flush();	
?>