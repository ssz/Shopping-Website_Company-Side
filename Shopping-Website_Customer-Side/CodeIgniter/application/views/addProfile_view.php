        <?php //echo validation_errors('<span class="err" align="center" style="color:red">', '</span>'); ?>
        <div class='wrap' align='center'>
		    <form name='f2' method='POST' action = "<?php echo site_url('account/addProfile'); ?>">
		    <p>Account Information</p>
		    <table>
                <!-- <tr>
				    <td>Emplyee ID:</td>
				    <td><input type='text' name='newemployeeID' placeholder='new employee ID'/></td>
			    </tr> -->
			    <tr>
				    <td>Username:</td>
				    <td><input type='text' name='newusername' placeholder='user name' value='<?php echo set_value('newusername'); ?>' />
				    <?php echo form_error('newusername', '<span style="color:red;font-size:small;left:0.5em">', '</span>'); ?></td>
			    </tr>
			    <tr>
				    <td>Password:</td>
				    <td><input type='password' name='newpassword' maxlength='12' placeholder='max length 12' value='<?php echo set_value('newpassword'); ?>'/>
				    <?php echo form_error('newpassword', '<span style="color:red;font-size:small;left:0.5em">', '</span>'); ?></td>
			    </tr>
			    <tr>
				    <td>Confirm Password:</td>
				    <td><input type='password' name='conpassword' maxlength='12' placeholder='confirm password' value='<?php echo set_value('conpassword'); ?>'/>
			    	<?php echo form_error('conpassword', '<span style="color:red;font-size:small;left:0.5em">', '</span>'); ?></td>
			    </tr>
			    <tr>
				    <td>Firstname:</td>
				    <td><input type='text' name='newfirstname' placeholder='firstname' value='<?php echo set_value('newfirstname'); ?>'/>
			    	<?php echo form_error('newfirstname', '<span style="color:red;font-size:small;left:0.5em">', '</span>'); ?></td>
			    </tr>
			    <tr>
				    <td>Lastname:</td>
				    <td><input type='text' name='newlastname' placeholder='lastname' value='<?php echo set_value('newlastname'); ?>'/>
			   		<?php echo form_error('newlastname', '<span style="color:red;font-size:small;left:0.5em">', '</span>'); ?></td>
			    </tr>
			    <!-- <tr>
				    <td>Gender:</td>
				    <td><input type='radio' name='gender' value='0'/>Female
				        <input type='radio' name='gender' value='1'/>Male
				    </td>
			    </tr> --> 
			    <!-- <tr>
				    <td>Age:</td>
				    <td><input type='text' name='newage' maxlength='2' placeholder='at most two digits'/></td>
			    </tr> -->
			    <tr>
				    <td>Birth:</td>
				    <td><input type='date' name='birth' placeholder='mm/dd/yyyy'/>
				    <?php echo form_error('birth', '<span style="color:red;font-size:small;left:0.5em">', '</span>'); ?></td>
			    </tr>
			
			    <tr><td>Payment Method</td></tr>
			    <tr>
				    <td>Card Number:</td>
				    <td><input type='text' name='cardnum' maxlength='16' placeholder='16 digits' value='<?php echo set_value('cardnum'); ?>'/>
			    	<?php echo form_error('cardnum', '<span style="color:red;font-size:small;left:0.5em">', '</span>'); ?></td>
			    </tr>
			    <tr>
				    <td>Card Type:</td>
				    <td>
				        <select name='cardtype'>
                            <option value='visa' selected>Visa</option>
                            <option value='master'>MasterCard</option>
                            <option value='discover'>Discover</option>
                            <option value='american'>American Express</option>
                        </select>
                    </td>
				    <!-- <td> 
				        <input type='radio' name='cardtype' value='0'/>Visa
				        <input type='radio' name='cardtype' value='1'/>MasterCard
				        <input type='radio' name='cardtype' value='2'/>Discover
				        <input type='radio' name='cardtype' value='3'/>American Express
				    </td> -->
			    </tr>  
			    <tr>
				    <td>Expire Date:</td>
				    <td><input type='date' name='expire'  placeholder='mm/dd/yyyy' />
			    	<?php echo form_error('expire', '<span style="color:red;font-size:small;left:0.5em">', '</span>'); ?></td>
			    </tr>
			
			    <tr><td>Delivery</td></tr>
			    <tr>
				    <td>Shipping Address:</td>
				    <td><input type='text' name='shipadd' value='<?php echo set_value('shipadd'); ?>'/>
			    	<?php echo form_error('shipadd', '<span style="color:red;font-size:small;left:0.5em">', '</span>'); ?></td>
			    </tr>
			    <!-- <tr>
				    <td>Zip:</td>
				    <td><input type='text' name='zip' maxlength='5' placeholder='5 digits'/></td>
			    </tr> -->
			    <!-- <tr>
				    <td>City:</td>
				    <td><input type='text' name='city'/></td>
			    </tr>
			    <tr>
				    <td>State:</td>
				    <td><input type='text' name='state'/></td>
			    </tr> -->
			    <tr>
				    <td>Billing Address:</td>
				    <td><input type='text' name='billadd' value='<?php echo set_value('billadd'); ?>'/>
			    	<?php echo form_error('billadd', '<span style="color:red;font-size:small;left:0.5em">', '</span>'); ?></td>
			    </tr>
			    
			    <tr>
				    <td>Email:</td>
				    <td><input type='email' name='email'   placeholder='xxx@example.com' value='<?php echo set_value('email'); ?>'/>
			    	<?php echo form_error('email', '<span style="color:red;font-size:small;left:0.5em">', '</span>'); ?></td>
			    </tr>
			    <tr>
				    <td>Phone:</td>
				    <td><input type='text' name='phone' maxlength='10' placeholder='10 digits' value='<?php echo set_value('phone'); ?>'/>
			    	<?php echo form_error('phone', '<span style="color:red;font-size:small;left:0.5em">', '</span>'); ?></td>
			    </tr>
			</table>
			<br>
			<input type='submit' value='Submit'/>
			<input type='reset' value='Reset'/>
			<input type='button' value='Return' onclick='javascript:history.back()'/>

		</form>

		</div>