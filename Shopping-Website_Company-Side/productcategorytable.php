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
     function showproductC(){
	    var pcdes = document.producttable.productdescrip.value;
	    var pcname=document.producttable.productCatname.value;
	    
	    if (window.XMLHttpRequest) {
		    xmlhttp = new XMLHttpRequest();
	    }else{
		    xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	    }
	    
	    xmlhttp.onreadystatechange=handleReply;
	    function handleReply() {
		    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			    document.getElementById('txtproductC').innerHTML = xmlhttp.responseText;
		    }
	    }
	
	    xmlhttp.open('GET','productCateRequest.php?pcdes='+pcdes+'&pcname='+pcname,true);
	    xmlhttp.send();
    }
    </script>
    </head>
    
    <body>
        <div class='content' align='center'>
            <form name='producttable'>
            <table>  
                <tr>
                <td>
				    <p>Category Name:</p>
				</td>
				<td>
				    <input type='text' name='productCatname'/>
				</td>
				</tr>
				<tr>
				<td>
				    <p>Category Description:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
				</td>
				<td>
			        <p><input type='text' name='productdescrip'/></p>
				</td>
				</tr>
			</table>
				<br>
			    <input type='reset' value='Reset'/>
	            <input type = 'button' value = 'Search' name = 'send' onclick = 'showproductC()'/>
	            <input type='button' value='Return' onClick=\"location.href='manager.php'\"/><br><br>
	        </form>
		
		<p id='txtproductC'>Product Category information will list here.</p>
		</div>		
	</body>
</html>";

		
	mysql_close($con);
	ob_flush();
?>