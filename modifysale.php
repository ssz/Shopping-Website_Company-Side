<?php 
    ob_start();
    session_start();
	
	require 'normalpage.html';
	
	$now = time();
	$con = mysql_connect('cs-server.usc.edu:61618', 'root','dalin100');
	$db_selection = mysql_select_db("sell",$con); //database
	//$res = mysql_query("SELECT * FROM specialsale"); //users data 
	
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
	
	$tempresp= mysql_query("SELECT * FROM product");
	if(!$tempresp){
	die('cannot use data'.mysql_error() );
	}


echo"
<html>
    <head>
        <link rel='stylesheet' href='css/style.css' type='text/css' >
    </head>
    <body>
	    <div class='content' align='center'>
		    <form name='modifyspecial' method='POST' action='modifysale.php'>
		    <p>Current stored information: </p> 
		    <div class='data'>
		    <table border = '1'>
			   	<tr>
					<th>Special Sale ID</th>
					<th>Product ID</th>
					<th>Product Name</th>
					<th>Original Price</th>
					<th>Discount</th>
					<th>Start Date</th>
					<th>End Date</th>
				</tr>";
				
				$modifyS = $_SESSION['mpss'] ; 
				$res = mysql_query("SELECT * FROM specialsale WHERE specialID = '$modifyS'");
				if (!$res){
				    die("Cannot get this user account ".$modifyS.".");
				}
				$row = mysql_fetch_assoc($res);
				if(!$row){
				    die("Cannot get data ");
				}else{
				    echo "<tr>";
				    echo "<td>".$row['specialID']."</td>";
				    echo "<td>".$row['productID']."</td>";
				    $temp=$row['productID'];
				    
				    $tres = mysql_query("SELECT * FROM product WHERE productID='$temp'");
				    if($rrow = mysql_fetch_assoc($tres)){
				        echo "<td>".$rrow['productname']."</td>";
				        echo "<td>".$rrow['price']."</td>";
				    }
				    //echo "<td>".$row['productname']."</td>";
				    //echo "<td>".$row['price']."</td>";
				    echo "<td>".$row['discount']."</td>";
				    echo "<td>".$row['startmon']."/".$row['startday']."/".$row['startyear']."</td>";
				    echo "<td>".$row['endmon']."/".$row['endday']."/".$row['endyear']."</td>";
				    //echo "<td><input type='submit' name='modifyspecial' value=".$row['specialID']."></td>";
				    echo "</tr>";
				}
echo"				
		    </table>
		    </div>
            
            <p>Please Modify special sale information here.</p>
            <table>
			    <tr>
				    <td>Product Information:</td>
				    <td>
				    <select name='productID'>";
				    //echo"<option value='Choose' selected='selected'>".'Choose Product'."</option>";
				    while($trow = mysql_fetch_assoc($tempresp)){
				        echo "<option value=".$trow['productID'].">"."ID: ".$trow['productID']."/ Name: ".$trow['productname']."/ Price: ".$trow['price']."</option>";
                     // echo"<option value=".$trow['productID'].">".$trow['productID']."</option>";
				    }
echo"             
			        </select>
			        </td>
			    </tr>
			    
			    <tr>
				    <td>Product Discount:</td>
				    <td><input type='text' name='discount' maxlength='2' placeholder='2 digits'/>%</td>
			    </tr>
			    
			    <tr>
				    <td>Start Date:</td>
				    <td>
				        <input type='text' name='startday' maxlength='2' placeholder='dd'/>
				        <input type='text' name='startmon' maxlength='2' placeholder='mm'/>
				        <input type='text' name='startyear' maxlength='4' placeholder='yyyy'/>
				    </td>
			    </tr>
			    
			    <tr>
				    <td>End Date:</td>
				    <td>
				        <input type='text' name='endday' maxlength='2' placeholder='dd'/>
				        <input type='text' name='endmon' maxlength='2' placeholder='mm'/>
				        <input type='text' name='endyear' maxlength='4' placeholder='yyyy'/>
				    </td>
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
			$productID = $_POST['productID'];
			//echo "$productID";
			$discount = $_POST['discount'];
			$startday = $_POST['startday'];
			//echo "$startday";
			$startmon = $_POST['startmon'];
			$startyear = $_POST['startyear'];
			$endday = $_POST['endday'];
			$endmon = $_POST['endmon'];
			$endyear = $_POST['endyear'];			
			
			if(!strlen($productID)){
				$productidError = "Product ID Invalid.";
			}else{
			   // if($productID=)
			    $productidError = "";
		    }
		    if(empty($discount) || !is_numeric("$discount")){
		        $discountError = "Discount Invalid";
		    }else{
		        $discountError="";
		    }
		    if((!empty($startday)) && (!empty($startmon)) && (!empty($startyear)) && (checkdate("$startmon","$startday","$startyear")==true)){
		    	$startdateError="";
		        if((!empty($endday)) && (!empty($endmon)) && (!empty($endyear)) && (checkdate("$endmon","$endday","$endyear")==true)){
		            $enddateError = "";
		            if("$startyear" > "$endyear"){
		                $dateError = "Start date shoule be before end date.";
		            }
		            if("$startyear" == "$endyear" && "$startmon" > "$endmon"){
		                 $dateError = "Start date shoule be before end date.";
		            }
		            if("$startyear" == "$endyear" && "$startmon" == "$endmon" && "$startday" > "$endday"){
		                $dateError = "Start date shoule be before end date.";
		            }
		            if("$startyear" == "$endyear" && "$startmon" == "$endmon" && "$startday" <= "$endday"){
		                $dateError = "";
		            }
		              /*  if("$startmon" > "$endmon"){
		                    $startdateError = "Start Date Invalid";
		                }else{
		                    if("$startday" > "$endmon"){
		                        $startdateError = "Start Date Invalid";
		                    }*/   
		        }else{
		                 $enddateError = "End Date Invalide";
		        }
		    }else{
		            $startdateError="Start Date Invalid";
		    }
            
            if (strlen($productID) == 0 && strlen($discount) == 0 && strlen($startday) == 0 && strlen($startmon) == 0 && strlen($startyear) == 0 && strlen($endday) == 0 && strlen($endmon) == 0 && strlen($endyear) == 0) {
		        $productidError = $discountError = $startdateError = $enddateError = $dateError = "";
		        $ini = true;
		    }else{
		        $ini = false;
		    }

		    if ($productidError == "" && $discountError == "" && $startdateError == "" && $enddateError == ""  && $dateError=="" && $ini == false){	
		        $res = mysql_query("UPDATE specialsale SET productID='$productID', discount='$discount', startday='$startday', startmon='$startmon', startyear='$startyear', endday='$endday', endmon='$endmon', endyear='$endyear' WHERE specialID='$modifyS'");
			    if(!$res){
				    die('Cannot add special sale information.');
			    }else{
			        echo"<p>Successfully add a new special sale!</p>";
			        /*unset($_POST['productID']);
			        unset($_POST['discount']);
			        unset($_POST['startday']);
			        unset($_POST['startmon']);
			        unset($_POST['startyear']);
			        unset($_POST['endday']);
			        unset($_POST['endmon']);
			        unset($_POST['endyear']);*/		 
	            }            
	        }else{
	           
	            echo "<p class='err'>$productidError $discountError $startdateError $enddateError $dateError</p>";
	        }
	        
	echo "
		</div>
	</body>
<html>";	
		
	mysql_close($con);
	ob_flush();	
?>