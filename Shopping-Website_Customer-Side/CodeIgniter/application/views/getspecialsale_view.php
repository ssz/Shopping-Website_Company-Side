<?php
  	
    //$sql = "SELECT specialsale.specialID, specialsale.productID, product.productname, product.price, specialsale.discount, specialsale.startday, specialsale.startmon, specialsale.startyear, specialsale.endday, specialsale.endmon, specialsale.endyear FROM product, specialsale WHERE product.productID=specialsale.productID";
    if(!$specialsale){
        echo '<p>No Special Sale Today.</p>';            
    }else{
?>
    <div class="img-slider">
	    <div class="wrap">
	        <ul id="jquery-demo">
<?php        
            foreach ($specialsale as $row){
?>
                <li>
                <a href="<?php echo site_url('account/displayproduct/'.$row['productID']);?>">
            	    <img src="<?php echo base_url();?>assets/images/productid_<?php echo $row['productID']; ?>.jpg" alt='' style='max-width: 50%'/>
                </a>
                <div class='slider-detils'>
             	    <a href="<?php echo site_url('account/displayproduct/'.$row['productID']);?>"><h3><?php echo $row['productname']; ?><label style='color:red'><?php echo $row['discount']; ?>% OFF</label></h3></a>
                </div>
                </li>
<?php
    		}
?>
            </ul>
	    </div>
	</div>
    <div class="clear"> </div>
<?php
	}
?>