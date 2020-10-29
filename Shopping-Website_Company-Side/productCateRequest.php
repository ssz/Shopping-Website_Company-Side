 <?php

	//$pcategoryID = $_GET['pcate'];
	$pcname = $_GET['pcname'];
	$pcdes = $_GET['pcdes'];
	
	$con = mysql_connect('cs-server.usc.edu:61618', 'root','dalin100');
	$db_selection = mysql_select_db("sell",$con); //database
	
	if (!$con){
	die("Cannot connect to the database.".mysql_error());
	}
	if(!$db_selection){ 
	die('cannot use table'.mysql_error() );
	}
	
	
	//$sql = "SELECT * FROM productcategory WHERE productcategoryname LIKE '%$pcname%'";
	if(empty($pcname) && empty($pcdes)){
	    $sql = "SELECT * FROM productcategory";
	}
	if(!empty($pcname) && empty($pcdes)){
	    $sql = "SELECT * FROM productcategory WHERE productcategoryname LIKE '%$pcname%'";
	}
	if(empty($pcname) && !empty($pcdes)){
	    $sql = "SELECT * FROM productcategory WHERE productcategorydes LIKE '%$pcdes%'";
	}
    if(!empty($pcname) && !empty($pcdes)){
	    $sql = "SELECT * FROM productcategory WHERE productcategorydes LIKE '%$pcdes%' AND productcategoryname LIKE '%$pcname%'";
	}


echo"
    <div class='data' align='center'>
	<table>
		<tr>
			<th>Product Category ID</th>
			<th>Product Category Name</th>
			<th>Product Category Description</th>
		</tr>";
	
	//echo $sql;
	$res = mysql_query($sql,$con);
	while($row = mysql_fetch_assoc($res)){
		echo "<tr>";
		//echo "<td>".$row['productID']."</td>";
		echo "<td>".$row['productcategoryid']."</td>";
		echo "<td>".$row['productcategoryname']."</td>";
		echo "<td>".$row['productcategorydes']."</td>";
		echo "</tr>";
	}
	
echo"	</table></div>";	
	
	mysql_close($con);
 ?>