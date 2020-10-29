 <?php
	$type = $_GET['type'];
	$payMin = $_GET['payMin'];
	$payMax = $_GET['payMax'];
	
	$con = mysql_connect('cs-server.usc.edu:61618', 'root','dalin100');
	$db_selection = mysql_select_db("sell",$con); //database
	$sql = "SELECT * FROM users";
	if (!$con){
	die("Cannot connect to the database.".mysql_error());
	}
	
	if(!$db_selection){ //does it need here?
	die('cannot use table'.mysql_error() );
	}
	
	if((!empty($payMin)) && !is_numeric($payMin)){ //need empty()?
	    $payminError="Min Pay Invalid.";
	}else{
	    $payminError="";
	}
	if((!empty($payMax)) && !is_numeric($payMax)){
	    $paymaxError="Max Pay Invalid.";
	}else{
	    $paymaxError="";
	}
	if(strlen($payMin)>0 && strlen($payMax)>0 &&($payMin > $payMax)){
	    $payrangError="Payment Rang Invalid";
	}else{
	    $payrangError="";
	}
	
	echo "<p class='err'>$payminError $paymaxError $payrangError</p>";
	
	if(!empty($payminError) || !empty($paymaxError) || !empty($payrangError) ){
	    die();
	}
	
	if($type != 'all'){
	    if ($type == 'admin'){
		    $usertype = 0;
	    }else if ($type == 'manager'){
	        $usertype = 1;
	    }else if ($type == 'saler'){
		    $usertype = 2;
	    }
	$sql = $sql." WHERE "."usertype = "."$usertype";
	}		

	if ($type != 'all' && ($payMin != '' || $payMax != '')) {
			$sql = $sql." AND";
		
		
		if ($payMin != '') {
			$sql = $sql." payment >= ".$payMin;
		}
		
		if ($payMin != '' && $payMax != '') {
			$sql = $sql." AND";
		}
			
		if ($payMax != '') {
			$sql = $sql." payment <= ".$payMax;
		}	
	}
	
	
	if ($type == 'all' && ($payMin != '' || $payMax != '')) {
		$sql = $sql." WHERE ";
		if ($payMin != '') {
			$sql = $sql." payment >= ".$payMin;
		}
		
		if ($payMin != '' && $payMax != '') {
			$sql = $sql." AND";
		}
			
		if ($payMax != '') {
			$sql = $sql." payment <= ".$payMax;
		}	
	}
	//echo "$sql";
	$res = mysql_query($sql,$con);

echo"   
        <div class='data'  align='center'>
	    <table>
			<tr>
				<th>User ID</th>
				<th>Username</th>
				<th>Usertype</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Age</th>
				<th>Payment</th>
			</tr>";
			
			//echo $usertype;
			//echo $sql;
				
				while($row = mysql_fetch_assoc($res)){
				echo "<tr>";
				echo "<td>".$row['userIndex']."</td>";
				echo "<td>".$row['username']."</td>";
				echo "<td>".$row['usertype']."</td>";
				echo "<td>".$row['firstname']."</td>";
				echo "<td>".$row['lastname']."</td>";
				echo "<td>".$row['age']."</td>";
				echo "<td>".$row['payment']."</td>";
				echo "</tr>";
				}	
echo"   </table></div>";	
	
	mysql_close($con);
 ?>