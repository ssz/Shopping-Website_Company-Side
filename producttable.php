<?php 
    ob_start();
    session_start();
	
	require 'normalpage.html';
	
	$now = time();
	$con = mysql_connect('cs-server.usc.edu:61618', 'root','dalin100');
	$db_selection = mysql_select_db("sell",$con); //database
	$res = mysql_query('SELECT * FROM productcategory');

	if($_SESSION['loginsuccess'] == false || $_SESSION['usertype']!=1){
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
	    die('cannot use table'.mysql_error() );
	}
	
	if (!$res){
		die("Cannot get the data.");
	}
	
	
echo"
<html>
    <head>
            <link rel='stylesheet' href='css/style.css' type='text/css' >
    <script type='text/javascript'>
    function showproduct(){
	    var ppriceMin = document.producttable.productPriceMin.value;
	    var ppriceMax = document.producttable.productPriceMax.value;
	    var pname = document.producttable.productname.value;
	    var ppcate=document.producttable.productCategoryID.value;
	    
	    
	    if (window.XMLHttpRequest) {
		    xmlhttp = new XMLHttpRequest();
	    }else{
		    xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	    }
	    
	    xmlhttp.onreadystatechange=handleReply;
	    function handleReply() {
		    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			    document.getElementById('txtproduct').innerHTML = xmlhttp.responseText;
		    }
	    }
	
	    xmlhttp.open('GET','productRequest.php?ppriceMin='+ppriceMin+'&ppriceMax='+ppriceMax+'&pname='+pname+'&ppcate='+ppcate,true);
	    xmlhttp.send();
    }
    </script>
    </head>
    
    <body>
        <div class='content' align='center'>
            <form name='producttable'>
            <table style='text-align:left'>
                <tr>
                    <td><p>Choose category:</p></td>
                <td>
                <select name='productCategoryID'>
				    <option value='allp' selected='selected'>All Product Categories</option>";
				    while($row = mysql_fetch_assoc($res)){
						//echo "<option value='".$row['productcategoryid']."'>".$row['productcategoryname']."</option>";
						echo "<option value = ".$row['productcategoryid'].">".$row['productcategoryname']."</option>";
					}
			echo"
				    </select>	   
                    </td>
                </tr>
                <tr>
                    <td><p>Input product name:</p></td>
                </tr>
                <tr>
					<td><p>Product Name:</p></td>
					<td><input type='text' name='productname'/></td>
				</tr>
				<tr>
				    <td><p>Input product price range:</td>
				</tr>
				<tr>
					<td><p>Minimum Price:</p>
					<td><input type='text' name='productPriceMin'/></td>
				</tr>
				<tr>
					<td><p>Maximum Price:</p></td>
					<td><input type='text' name='productPriceMax'/></td>
				</tr>
				</table>	
			    <input type='reset' value='Reset'/>
	            <input type = 'button' value = 'Search' name = 'send' onclick = 'showproduct()'/>
	            <input type='button' value='Return' onClick=\"location.href='manager.php'\"/><br><br>
	        </form>		
		    <p id='txtproduct'>Emplyee information lists here.</p>	
		</div>	
	</body>
</html>";

		
	mysql_close($con);
	ob_flush();
?>