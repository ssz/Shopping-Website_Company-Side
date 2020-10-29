 <?php
	
	$pricemin = $_GET['ppriceMin'];
	$pricemax = $_GET['ppriceMax'];
	$pcategoryID = $_GET['ppcate'];
	$pname = $_GET['pname'];
	
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
	    $pricerangError="Min cannot be lager than Max";
	}else{
	    $pricerangError="";
	}
	
	echo "<p class='err'>$priceminError $pricemaxError $pricerangError</p>";
	if(!empty($priceminError) || !empty($pricemaxError) || !empty($pricerangError) ){
	    die();
	}
	
	$sql = "SELECT * FROM product WHERE productname LIKE '%$pname%'";
		
	if ( $pcategoryID != 'allp' || !empty($pricemin) || !empty($pricemax)){			
		if ($pricemin != ''){
			$sql = $sql." AND price >= ".$pricemin;
		}
		if ($pricemax != '') {
			$sql = $sql." AND price <= ".$pricemax;
		}
						
		if ($pcategoryID != 'allp'){				
			$sql = $sql." AND productcategoryid = '".$pcategoryID."'";
		}
	}

echo"
    <div class='data' align='center'>
	<table>
		<tr>
			<th>Product ID</th>
			<th>Product Name</th>
			<th>Product Category ID</th>
			<th>Product Description</th>
			<th>Product Price</th>
		</tr>";
	
	//echo $sql;
	$res = mysql_query($sql,$con);
	while($row = mysql_fetch_assoc($res)){
		echo "<tr>";
		echo "<td>".$row['productID']."</td>";
		echo "<td>".$row['productname']."</td>";
		echo "<td>".$row['productcategoryid']."</td>";
		echo "<td>".$row['description']."</td>";
		echo "<td>".$row['price']."</td>";
		echo "</tr>";
	}
	
echo"	</table></div>";	
	
	mysql_close($con);
 ?>