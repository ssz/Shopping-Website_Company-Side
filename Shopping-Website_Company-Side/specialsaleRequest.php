 <?php
	
	$pricemin = $_GET['spriceMin'];
	$pricemax = $_GET['spriceMax'];
	$pcategoryID = $_GET['spcate'];
	$pname = $_GET['sname'];
	$sy=$_GET['syear'];
	$sm=$_GET['smonth'];
	$sd=$_GET['sday'];
	$ey=$_GET['eyear'];
	$em=$_GET['emonth'];
	$ed=$_GET['eday'];
	
	$con = mysql_connect('cs-server.usc.edu:61618', 'root','dalin100');
	$db_selection = mysql_select_db("sell",$con); //database
	
	if (!$con){
	die("Cannot connect to the database.".mysql_error());
	}
	if(!$db_selection){ 
	die('cannot use table'.mysql_error() );
	}
	
	if((!empty($pricemin)) && !is_numeric($pricemin)){ 
	    $priceminError="Min Price Invalid.";
	}else{
	    $priceminError="";
	}
	if((!empty($pricemax)) && !is_numeric($pricemax)){
	    $pricemaxError="Max Price Invalid.";
	}else{
	    $pricemaxError="";
	}
	if(strlen($pricemin)>0 && strlen($pricemax)>0 && ($pricemin > $pricemax)){
	    $pricerangError="Min price cannot be lager than Max price!";
	}else{
	    $pricerangError="";
	}
	
	echo "<p class='err'>$priceminError $pricemaxError $pricerangError";
	
	
	 if((!empty($sd)) && (!empty($sm)) && (!empty($sy)) && (checkdate($sm,$sd,$sy)==true)){
		    	//$startdateError='';
		        if((!empty($ed)) && (!empty($em)) && (!empty($ey)) && (checkdate($em,$ed,$ey)==true)){
		            //$enddateError = '';
		            if($sy > $ey){
		                $dateError = 'Start date shoule be before end date.';
                        echo "<p class='err'>$dateError</p>";
		                die();
		            }
		            if($sy == $ey && $sm > $em){
		                 $dateError = 'Start date shoule be before end date.';
                        echo "<p class='err'>$dateError</p>";
		                die();
		            }
		            if($sy == $ey && $sm == $em && $sd > $ed){
		                $dateError = 'Start date shoule be before end date.';
                        echo "<p class='err'>$dateError</p>";
		                die();
		            }
		        }elseif(empty($ed) && empty($em) && empty($ey)){
		                 $enddateError = '';
		        }else {
		                $enddateError = 'End Date Invalide';
		                echo "<p class='err'>$enddateError</p>";
		                die();
		        }
	}elseif(empty($sd) && empty($sm) && empty($sy)){
		    $startdateError='';
    }else{
		    $startdateError='Start Date Invalid';
		    echo"<p class='err'> $startdateError</p>";
		    die();
	}
	
	
	
	//$sql = "SELECT * FROM product WHERE productname LIKE '%$pname%'";
	$sql = "SELECT specialsale.specialID, specialsale.productID, product.productname, product.price, specialsale.discount, specialsale.startday, specialsale.startmon, specialsale.startyear, specialsale.endday, specialsale.endmon, specialsale.endyear FROM product, specialsale WHERE product.productID=specialsale.productID AND product.productname LIKE '%$pname%'";	
	$sDate = "$sy"."$sm"."$sd";
	$eDate = "$ey"."$em"."$ed";
if (!(!empty($pricemin) && !is_numeric($pricemin) || !empty($pricemax) && !is_numeric($pricemax))) {
	if (strlen($pricemin) != 0 || strlen($pricemax) != 0 || $pcategoryID != 'alls' || strlen($sDate) != 0 || strlen($eDate) != 0) {
		if ($pricemin != '') {
			$sql = $sql." AND product.price*(1-specialsale.discount/100) >= ".$pricemin;
		}
		if ($pricemax != '') {
			$sql = $sql." AND product.price*(1-specialsale.discount/100) <= ".$pricemax;
		}
		if ($pcategoryID != 'alls') {				
			$sql = $sql." AND product.productcategoryid = '".$pcategoryID."'";
		}
		if ($sDate != '') {
		    $sql = $sql." AND (specialsale.startyear>'".$sy."'";
		    $sql = $sql." OR (specialsale.startyear='".$sy."' AND specialsale.startmon>'".$sm."')";
			$sql = $sql." OR (specialsale.startyear='".$sy."' AND specialsale.startmon= '".$sm."' And specialsale.startday>= '".$sd."'))";
		
		}
		if ($eDate != '') {
		    $sql = $sql." AND (specialsale.endyear<'".$ey."'";
		    $sql = $sql." OR (specialsale.endyear='".$ey."' AND specialsale.endmon<'".$em."')";
			$sql = $sql." OR (specialsale.endyear='".$ey."' AND specialsale.endmon='".$em."' And specialsale.endday<= '".$ed."'))";
		}
	}
}
echo"<div class='data' align='center'>
	<p>If nothing input in fields, all of the informtion will be showed below.</p>
	<table>
		<tr>
			<th>Specialsale ID</th>
			<th>Product ID</th>
			<th>Product Name</th>
			<th>Original Price</th>
            <th>Discount</th>
			<th>Start Date</th>
			<th>End Date</th>
		</tr>";
	
	//echo $sql;
	$res = mysql_query($sql,$con);
	while($row = mysql_fetch_assoc($res)){
		echo "<tr>";
		echo "<td>".$row['specialID']."</td>";
		echo "<td>".$row['productID']."</td>";
		$temp=$row['productID'];
				    
		$tres = mysql_query("SELECT * FROM product WHERE productID='$temp'");
		if($rrow = mysql_fetch_assoc($tres)){
			echo "<td>".$rrow['productname']."</td>";
			echo "<td>".$rrow['price']."</td>";
		}
		echo"<td>".$row['discount']."</td>";
		echo "<td>".$row['startmon']."/".$row['startday']."/".$row['startyear']."</td>";
		echo "<td>".$row['endmon']."/".$row['endday']."/".$row['endyear']."</td>";
		echo "</tr>";
	}
	
echo"	</table></div>";	
	
	mysql_close($con);
 ?>