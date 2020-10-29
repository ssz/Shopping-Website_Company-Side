   <div class='wrap' align='center'>
		    <form name='fupdateProfile' method='POST' action = "<?php echo site_url('account/updateProfile'); ?>">
		    <p>Modify Profile information here.</p>
		    <p><?php if(isset($errmsg)) echo $errmsg?></p>
		    <table>
<?php
	        if(!$profile){
	            die('No Such Customer');
	        }else{
                $row=$profile; 	
				echo "<tr><td>Username:</td><td><input type='text' readonly name='newusername' value='".$row['username']."'>";
				echo form_error('newusername', '<span style="color:red;font-size:small;left:0.5em">', '</span>');
				echo "</td></tr>";
				
				echo "<tr><td>Password:</td><td><input type='password' name='newpassword' value='' placeholder='input new psw'>";
				echo form_error('newpassword', '<span style="color:red;font-size:small;left:0.5em">', '</span>');
				echo "</td></tr>";
				
				echo "<tr><td>Confirm Password:</td><td><input type='password' name='conpassword' value='' placeholder='confirm new psw'>";
				echo form_error('conpassword', '<span style="color:red;font-size:small;left:0.5em">', '</span>');
				echo "</td></tr>";
				
				
				
				echo "<tr><td>First Name:</td><td><input type='text' name='newfirstname' value='".$row['firstName']."'>";
				echo form_error('newfirstname', '<span style="color:red;font-size:small;left:0.5em">', '</span>');
				echo "</td></tr>";
				
				
				
				echo "<tr><td>Last Name:</td><td><input type='text' name='newlastname' value='".$row['lastName']."'>";
				echo form_error('newlastname', '<span style="color:red;font-size:small;left:0.5em">', '</span>');
				echo "</td></tr>";
				
				echo "<tr><td>Birth:</td><td><input type='date' name='birth' value='".$row['birth']."'>";
				echo form_error('birth', '<span style="color:red;font-size:small;left:0.5em">', '</span>');
				echo "</td></tr>";
				
					
				echo "<tr><td>Email:</td><td><input type='text' name='email' value='".$row['email']."'>";
				echo form_error('email', '<span style="color:red;font-size:small;left:0.5em">', '</span>');
				echo "</td></tr>";
				
				
				echo "<tr><td>Phone:</td><td><input type='text' name='phone' value='".$row['phone']."'>";
				echo form_error('phone', '<span style="color:red;font-size:small;left:0.5em">', '</span>');
				echo "</td></tr>";
				
				
				
				echo "<tr><td>Card Number:</td><td><input type='text' name='cardnum' value='".$row['cardNumber']."'>";
				echo form_error('cardnum', '<span style="color:red;font-size:small;left:0.5em">', '</span>');
				echo "</td></tr>";
				
				
				echo "<tr><td>Card Type:</td><td>
				            <select name='cardtype'>";
				            if($row['cardType']=='visa'){
				                echo"<option value='visa' selected>".$row['cardType']."</option>";
				                echo"<option value='master'>MasterCard</option>";
                                echo"<option value='discover'>Discover</option>";
                                echo"<option value='american'>American Express</option>";
				            }elseif($row['cardType']=='american'){
				                echo"<option value='american' selected>".$row['cardType']."</option>";
				                echo"<option value='master'>MasterCard</option>";
                                echo"<option value='discover'>Discover</option>";
                                echo"<option value='visa'>Visa</option>";
				            }elseif($row['cardType']=='master'){
				                echo"<option value='master' selected>".$row['cardType']."</option>";
				                echo"<option value='american'>American Express</option>";
                                echo"<option value='discover'>Discover</option>";
                                echo"<option value='visa'>Visa</option>";  
				            }else{
				                echo"<option value='discover' selected>".$row['cardType']."</option>";
				                echo"<option value='american'>American Express</option>";
                                echo"<option value='master'>MasterCard</option>";
                                echo"<option value='visa'>Visa</option>";                  
				            }
				        "</select>                
				</td></tr>";
				echo "<tr><td>Expire Date:</td><td><input type='date' name='expire' value='".$row['expireDate']."'>";
				echo form_error('expire', '<span style="color:red;font-size:small;left:0.5em">', '</span>');
				echo "</td></tr>";
				
				
				echo "<tr><td>Bill Address:</td><td><input type='text' name='billadd' value='".$row['billAdd']."'>";
				echo form_error('billadd', '<span style="color:red;font-size:small;left:0.5em">', '</span>');
				echo "</td></tr>";
				
				
				echo "<tr><td>Ship Address:</td><td><input type='text' name='shipadd' value='".$row['shipAdd']."'>";
				echo form_error('shipadd', '<span style="color:red;font-size:small;left:0.5em">', '</span>');
				echo "</td></tr>";
				//echo "</tr>";
			}
?>			

		    </table>
			<br>
			<input type='submit' value='Submit'/>
			<input type="button" onclick="javascript:history.back()" value="Back"/>
			<!-- <input type='button' name='Logout' value='Logout' Onclick="location.href=<?php echo site_url('account/clogout'); ?>"/> -->
			<br><br>
		</form>
		</div>

