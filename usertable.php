<?php 
    ob_start();
    session_start();
	
	require 'normalpage.html';
	
	$now = time();
	$con = mysql_connect('cs-server.usc.edu:61618', 'root','dalin100');
	$db_selection = mysql_select_db("sell",$con); //database
	//$res = mysql_query("SELECT * FROM users"); 

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
	
	if(!$db_selection){ //does it need here?
	die('cannot use table'.mysql_error() );
	}
	
	/*if(!$rest){ //does it need here?
	die('cannot get data');
	}*/
	
	
echo"
<html>
    <head>
        <link rel='stylesheet' href='css/style.css' type='text/css' >
    <script type='text/javascript'>
    function showuser(type){
        var payMin = document.usertable.employeePayMin.value;
	    var payMax = document.usertable.employeePayMax.value;
        if (window.XMLHttpRequest){
            xmlhttp=new XMLHttpRequest();
        }else{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		}
        xmlhttp.onreadystatechange=handleReply;
        function handleReply(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                document.getElementById('txtHint').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open('GET','userRequest.php?type='+type+'&payMin='+payMin+'&payMax='+payMax,true);
        xmlhttp.send();
    }
    </script>
    </head>
    
    <body>
        <div class='content' align='center'>
            <form name='usertable'>
                <table style='text-align:left'>
                <tr>
                <td>
                    <p>Select usertype here.</p>
                </td>
                <td>
                <p>
                    <select name='usertype'>
					<option value='all' selected='selected'>All User Types</option>
					<option value='admin'>Administrator</option>
					<option value='manager'>Manager</option>
					<option value='saler'>Sales Manager</option>
		            </select>
		        </p>
		        </td>
		        </tr>
		        <tr>
		        <td>
		            <p>Input pay range:<p>
		        </td>
		        </tr>
		        <tr>
		        <td>
				    <p>Minimum Pay:</p>
				</td>
				<td>
				    <input type='text' maxlength='5' name='employeePayMin' placeholder='at most 5 digits'/>
				</td>
				</tr>
				<tr>
				<td>
				    <p>Maximum Pay:</p>
				</td>
				<td>
				    <input type='text' maxlength='5' name='employeePayMax' placeholder='at most 5 digits'/>
				</td>
				</tr>
				</table>
					
			    <input type='reset' value='Reset'/>
	            <input type = 'button' value = 'search' name = 'send' onclick = 'showuser(usertype.value)'/>
	            <input type='button' value='Return' onClick=\"location.href='manager.php'\"/><br><br>
	        </form>
	        
		<p id='txtHint'>Emplyee information lists here.</p>		
		</div>
	</body>
</html>";

		
	mysql_close($con);
	ob_flush();
?>