<?php 
    ob_start();
    session_start();
	
	require 'normalpage.html';
	
	$now = time();
	$con = mysql_connect('cs-server.usc.edu:61618', 'root','dalin100');
	$db_selection = mysql_select_db("sell",$con); //database
	
	if($_SESSION['loginsuccess'] == false && $_SESSION['usertype']!=0){
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
	    <div class='data'>
		    <form name='f3' method='POST' action='Modifyuser.php'>
		    <p>Modify employees' information here.</p>
		    <p>Current stored information: </p> 
		    <table>
				<tr>
					<th>userIndex</th>
					<th>Username</th>
					<th>Password</th>
					<th>Usertype</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Age</th>
					<th>Payment</th>
				</tr>";
				
				
				$modifyE = $_SESSION['meID'];
				$res = mysql_query("SELECT * FROM users WHERE userIndex = '$modifyE'");
				if (!$res){
				//echo"0000000";
				    die("Cannot get this user account ".$modifyE.".");
				}
				$row = mysql_fetch_assoc($res);
				if(!$row){
				    die("Cannot get data ");
				}else{
				echo "<tr>";
				echo "<td>".$row['userIndex']."</td>";
				echo "<td>".$row['username']."</td>";
				echo "<td>".$row['password']."</td>";
				echo "<td>".$row['usertype']."</td>";
				echo "<td>".$row['firstname']."</td>";
				echo "<td>".$row['lastname']."</td>";
				echo "<td>".$row['age']."</td>";
				echo "<td>".$row['payment']."</td>";
				echo "</tr>";
				}
echo"				
		    </table>
		    </div>";
echo"
                <p>Enter the fields and modify information.</p>
                <table border = '1'>
                <!-- <tr>
				    <td>Emplyee ID:</td>
				    <td><input type='text' name='newemployeeID' placeholder='new employee ID'/></td>
			    </tr> -->
                <tr>
				    <td>Username:</td>
				    <td><input type='text' name='newusername' placeholder='new user name'/></td>
			    </tr>
			    <tr>
				    <td>Password:</td>
				    <td><input type='text' name='newpassword' placeholder='new password'/></td>
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
				    <td><input type='text' name='newage' maxlength='2' placeholder='two digits'/></td>
			    </tr>
			    <tr>
				    <td>Payment:</td>
				    <td><input type='text' name='newpayment' maxlength='5' placeholder='five digits'/></td>
			    </tr>
			</table>
			<br>
			<input type='submit' value='Submit'/>
			<input type='reset' value='Reset'/>
			<input type='button' value='Return' onClick=\"location.href='admin.php'\"/>
			<input type='button' name='Logout' value='Logout' Onclick='location.href=\"logout.php\"'/><br><br>
		</form>";

			//store the input data.	
			//validation of input, then push them into database.
			//$memployeeID = $_POST['newemployeeID'];
			$musername = $_POST['newusername'];
			$mpassword = $_POST['newpassword'];
			$musertype = $_POST['newusertype'];
			$mfirstname = $_POST['newfirstname'];
			$mlastname = $_POST['newlastname'];
			$mage = $_POST['newage'];
			$mpayment = $_POST['newpayment'];
			
			/*if (empty($memployeeID) || !is_numeric($memployeeID)){
		        $employeeIDError = "Employee ID Invalid. ";
	        }else{
		        $employeeIDError = "";
	        }*/
			if(empty($musername)){
			    $usernameError = "Username Invalid.";
			}else{
			    $usernameError = "";
		    }
			if(empty($mpassword)){
				$passwordError = "Password Invalid.";
			}else{
			    $passwordError = "";
		    }
		    if($musertype !="0" && $musertype!="1" && $musertype!="2"){
		        $usertypeError = "Usertype Invalid";
		    }else{
		        $usertypeError = "";
		    }
		    if(empty($mfirstname) || is_numeric($mfirstname)){
		        $firstnameError = "Firstname Invalid";
		    }else{
		        $firstnameError="";
		    }
		    if(empty($mlastname) || is_numeric($mlastname)){
		        $lastnameError = "Lastname Invalid";
		    }else{
		        $lastnameError="";
		    }
		    if ((strlen($mage) > 0 && (!is_numeric($mage))) || $mage < 0 || empty($mage)) {
		        $ageError = "Age Invalid. ";
	        }else{
		        $ageError = "";
	        }
	        if ((strlen($mpayment) > 0 && (!is_numeric($mpayment))) || $mpayment < 0 || empty($mpayment)) {
		        $payError = "Pay Invalid. ";
	        }else{
		        $payError = "";
		    }   
            
           // if (strlen($memployeeID) == 0 && strlen($musername) == 0 && strlen($mpassword) == 0 && strlen($mfirstname) == 0 && strlen($mlastname) == 0 && strlen($mage) == 0 && strlen($musertype) == 0 && strlen($mpayment) == 0) {
		    if (strlen($musername) == 0 && strlen($mpassword) == 0 && strlen($mfirstname) == 0 && strlen($mlastname) == 0 && strlen($mage) == 0 && strlen($musertype) == 0 && strlen($mpayment) == 0) {
		        //$employeeIDError = $usernameError = $passwordError = $usertypeError = $ageError = $payError = "";
		        $usernameError = $passwordError = $usertypeError = $ageError = $payError = "";
		        $ini = true;
		    }else{
		        $ini = false;
		    }

		    //if ($employeeIDError=="" && $usernameError == "" && $passwordError == "" && $usertypeError == "" && $ageError == "" && $payError == "" && $ini == false){	
		    if ($usernameError == "" && $passwordError == "" && $usertypeError == "" && $ageError == "" && $payError == "" && $ini == false){	    
		        $res = mysql_query("UPDATE users SET username='$musername', password='$mpassword', usertype='$musertype', firstname='$mfirstname', lastName='$mlastname', age='$mage', payment='$mpayment' WHERE userIndex='$modifyE'");
			    if(!$res){
				    die('Cannot add user information.');
			    }else{
			        echo"<p>Successfully modify the user account.</p>";  
			        header("Location: adminModifyuser.php");  
	            }            
	        }else{
	            //echo $employeeIDError;
	            echo "<p class='err'>$usernameError $passwordError $usertypeError $ageError $payError</p>";
	        }
	        
	echo "
		</div>
	</body>
<html>";	
		
	mysql_close($con);
	ob_flush();	
?>