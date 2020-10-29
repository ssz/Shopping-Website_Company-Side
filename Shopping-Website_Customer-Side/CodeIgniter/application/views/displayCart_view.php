<?php
    
    echo "<div align='center'>";
    if($this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')<=15*60)){
		
		if(!$cart_cusid){
            echo "<p>No items in your cart now.</p>";
        }else{
        $customerid = $this->session->userdata('customerid');
?>
             <form name='cf1' method='POST' action="<?php echo site_url('account/displayCart'); ?>">
                <table align='center'>
                    <tr>
                        <th>ProductName</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Delete</th>
                    </tr>
<?php  
        }
		  
        foreach($cart_cusid as $cc ){
            
            $productID=$cc['productID'];
            $product_pid=$this->my_model->product_pid($productID); //$sql_cp="SELECT * FROM product WHERE productID=$productID"; 
            $ss_discount=$this->my_model->ss_discount($productID); //$sql2 = "SELECT discount FROM specialsale WHERE productID = '$productID'";                               
            
            if($product_pid){      
                echo" <tr>";
                    echo"<td>".$product_pid['productname']."</td>";

                    if($ss_discount){ 
                        $ssp = $product_pid['price']*(1-$ss_discount['discount']*0.01);
                    }else{
                        $ssp = $product_pid['price'];
                    }
                    echo"<td>".$ssp."</td>";
                    
                    echo"<td><select name='quantity_$productID'>";
                
                    //echo"<td><select name='quantity_$product_pid'>";
                    $qpID = 'quantity_'.$productID;
                    if(isset($_POST[$qpID])&&!isset($_POST['delete'])) {
                    	$qty = $_POST[$qpID];
                    //if($this->input->post('$qpID') && !$this->input->post('delete')){	                    			
                    //    $qty = $this->input->post('$qpID');
                        $this->my_model->updatecart_pqty($customerid, $productID, $qty); //$sql_up = "UPDATE cart SET productquantity='$qty' WHERE customerID='$customerid' AND productID='$productID'";
                    }else{
                        $qty = $cc['productquantity'];
                    }
			         
                    for($i=1;$i<9;$i++){
                        if($i==$qty){
                            echo"<option value='$i' selected>".$qty."</option>";
                        }else{
                            echo"<option value='$i'>".$i."</option>";
                        }
                    }   
                    echo"</select></td>";
                    //echo"<td><input type='radio' name='modify' value=".$row['productID']."></td>";
                    echo"<td><input type='checkbox' name='delete[]' value=".$product_pid['productID']."></td>";
                    echo"</tr>";        
            }
        }
?>
        </table>
            <br>
            <input type='submit' name='submit'>
            <input type='button' onclick='javascript:history.back()' value='Back'/>
            <input type='button' name='checkout' value='checkout' Onclick="location.href='<?php echo site_url('account/checkout'); ?>'"/>
            <input type='button' name='Logout' value='Logout' Onclick="location.href='<?php echo site_url('account/clogout'); ?>'"/>
        </form> 
        
     
    
<?php

    }
        
    if(!$this->session->userdata('cloginsuccess') || $this->session->userdata('cloginsuccess')==false){
        
        echo "<div align='center'>";
        if(!isset($_COOKIE["cart"])){
            echo "<p>No items in your cart now.</p>";
        }else{
?>
             <form name='cf1' method='POST' action="<?php echo site_url('account/displayCart'); ?>">
                <table align='center'>
                    <tr>
                        <th>ProductName</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Delete</th>
                    </tr>
<?php 
        
           
            foreach($_COOKIE["cart"] as $productID => $qty){
            
                $product_pid=$this->my_model->product_pid($productID); //$sql_cp="SELECT * FROM product WHERE productID=$productID"; 
                $ss_discount=$this->my_model->ss_discount($productID); //$sql2 = "SELECT discount FROM specialsale WHERE productID = '$productID'";                               
            
                if($ss_discount){ 
                    $ssp = $product_pid['price']*(1-$ss_discount['discount']*0.01);
                }else{
                    $ssp = $product_pid['price'];
                }
            
                    echo" <tr>";
                        echo"<td>".$product_pid['productname']."</td>";
                        echo"<td>".$ssp."</td>";
                
                        echo"<td><select name='quantity_".$productID."'>";
                        $qpID = 'quantity_'.$productID;				
                        if(isset($_POST[$qpID])&&!isset($_POST['delete'])) {
                            $qty = $_POST[$qpID];
                            $expire=time()+60*60*24;
                            setcookie("cart[$productID]",$qty,$expire);
                        }
                        //echo "<td>".$qty."</td>";
                        for($i=1;$i<9;$i++){
                            if($i==$qty){
                                echo"<option value='$i' selected>".$qty."</option>";
                            }else{
                                echo"<option value='$i'>".$i."</option>";
                            }
                        }
                        echo"</select></td>";
                        //echo"<td><input type='radio' name='modify' value=".$row['productID']."></td>";
                        echo"<td><input type='checkbox' name='delete[]' value=".$product_pid['productID']."></td>";
                        echo"</tr>";   
            }
        }
?>        
        </table>
            <br>
            <input type='submit' name='submit'>
            <input type='button' onclick='javascript:history.back()' value='Back'/>
            <input type='button' name='checkout' value='checkout' Onclick="location.href='<?php echo site_url('account/checkout'); ?>'"/>
        </form>
<?php
        
    }
    echo "</div>";   
?>              