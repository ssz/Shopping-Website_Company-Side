<?php

        if(!$product_cart){
			echo "<p align='center' style='color:red'>No items in your cart.</p>";
		}else{
			$totalPrice = 0;
			
?>
            <div class='wrap' align ='center'>
            <form name='fcheckout' method='POST' action="<?php echo site_url('account/order'); ?>">
                <table style="text-align:center">
                    <tr>
                        <th>ProductName</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
<?php            
		    foreach($product_cart as $pc){
			    $pc_pid=$pc['productID'];
			    $row2=$this->my_model->get_specialsale_bypid($pc_pid);	   
			    if($row2){
				    $unitPrice = round($pc['price']*(1-$row2['discount']*0.01),2);
			    }else{
				    $unitPrice = $pc['price'];
			    }
			    echo "<tr>";			
			    echo "<td>".$pc['productname']."</td>";			
			    echo "<td>".$pc['productquantity']."</td>";
			    $Price = round($unitPrice * $pc['productquantity'],2);
			    echo "<td>$".$Price."</td>";
			    echo "</tr>";
			    $totalPrice += $Price;
		    }
		    echo"</table>";
		    
		    echo"<p align='center' style='color:red'>Total Price:".$totalPrice."</p>";
			echo"<input type='hidden' name='ordertotalPrice' value='$totalPrice'>";
			echo"<p align='center' style='color:red'>Please review your payment information.</p>";
    
           
            if(!$cus_id){
?>
                <p align='center' style='color:red'>No profile information now.</p>
<?php            
            }else{
?>
                    <table>
                        <tr><td>First Name:</td>
                            <td><?php echo $cus_id['firstName']; ?></td>
                        </tr>
                        <tr><td>Last Name:</td>
                            <td><?php echo $cus_id['lastName']; ?></td>
                        </tr>
                        <tr><td>Credit Card Number:</td>
                            <td><?php echo $cus_id['cardNumber']; ?></td>
                        </tr>
                        <tr><td>Credit Card Type:</td>
                            <td><?php echo $cus_id['cardType']; ?></td>
                        </tr>
                         <tr><td>Expiration Date:</td>
                            <td><?php echo $cus_id['expireDate']; ?></td>
                        </tr>
                         <tr><td>Billing Address:</td>
                            <td><?php echo $cus_id['billAdd']; ?></td>
                        </tr>
                         <tr><td>Shipping Address:</td>
                            <td><?php echo $cus_id['shipAdd']; ?></td>
                        </tr>
                    <table>
                    <p align='center' style='color:red'>Update your profile, please click here.<a href="<?php echo site_url('account/updateProfile') ?>">UPDATE PROFILE</a></p>
			        <input type='button' onclick='javascript:history.back()' value='Back'/>
			        <input type='submit' value='Confirm'/>
		        </form> 
		        </div>
<?php       }
      }

    
?>
