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
    function showsale(){
	    var spriceMin = document.specialsaletable.productPriceMin.value;
	    var spriceMax = document.specialsaletable.productPriceMax.value;
	    var sname = document.specialsaletable.productname.value;
	    var spcate=document.specialsaletable.productCategoryID.value;
	    var smonth=document.specialsaletable.smon.value;
	    var sday=document.specialsaletable.sday.value;
	    var syear=document.specialsaletable.syear.value;
	    var emonth=document.specialsaletable.emon.value;
	    var eday=document.specialsaletable.eday.value;
	    var eyear=document.specialsaletable.eyear.value;
    
	    
	    if (window.XMLHttpRequest) {
		    xmlhttp = new XMLHttpRequest();
	    }else{
		    xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	    }
	    
	    xmlhttp.onreadystatechange=handleReply;
	    function handleReply() {
		    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			    document.getElementById('txtsale').innerHTML = xmlhttp.responseText;
		    }
	    }
	    xmlhttp.open('GET','specialsaleRequest.php?spriceMax='+spriceMax+'&spriceMin='+spriceMin+'&sname='+sname+'&spcate='+spcate+'&syear='+syear+'&smonth='+smonth+'&sday='+sday+'&eyear='+eyear+'&emonth='+emonth+'&eday='+eday,true);
	    xmlhttp.send();
    }
    </script>
    </head>
    
    <body>
        <div class='content' align='center'>
            <form name='specialsaletable'>
                <p>Input product name:</p>
				<p>Product Name:<input type='text' name='productname'/></p>
				
                <p>Input product price range (after discount):</p>
				<p>Minimum Price:<input type='text' name='productPriceMin'/>
					Maximum Price:<input type='text' name='productPriceMax'/>
				</p>
		        
		        <p>Choose product category:
				<select name='productCategoryID'>
				    <option value='alls' selected='selected'>All Product Categories</option>";
					while($row = mysql_fetch_assoc($res)){
						//echo "<option value='".$row['productcategoryid']."'>".$row['productcategoryname']."</option>";
						echo "<option value = ".$row['productcategoryid'].">".$row['productcategoryname']."</option>";
					}			
						
echo"			</select></p>
			    <p>Input date range here.(For Month and Day: 02=2 and at most 2 digits. For year: 2014=14 and at most 4 digits)</p>
			    <p>Start Date:
			        Month<input type='text' name='smon' maxlength=2 placeholder='mm'/>
			        Day<input type='text' name='sday' maxlength=2 placeholder='dd'/>
			        Year<input type='text' name='syear' maxlength=4 placeholder='yyyy'/>
			    </p>    
				<p>End Date:
			        Month<input type='text' name='emon' maxlength=2 placeholder='mm'/>
			        Day<input type='text' name='eday' maxlength=2 placeholder='dd'/>
			        Year<input type='text' name='eyear' maxlength=4 placeholder='yyyy'/>
			    </p>
			    
				<br>
			    <input type='reset' value='Reset'/>
	            <input type = 'button' value = 'Search' name = 'send' onclick = 'showsale()'/>
	            <input type='button' value='Return' onClick=\"location.href='manager.php'\"/><br><br>
	        </form>
		<p id='txtsale'>Searched information will list here.</p>		
		</div>
	</body>
</html>";

		
	mysql_close($con);
	ob_flush();
?>