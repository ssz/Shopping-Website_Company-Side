		<form name="fproductdetail" method="GET" action="<?php echo site_url('account/addCart'); ?>">
<?php
		$row = $product;
		$row2 = $discountinfo;
		if (!$row){
			echo "<p style='color:read'>No Such Product Information.</p>";
			
		}else{
			if($row2){				
				$SalesPrice=round($row['price']*(1-$row2['discount']*0.01),2);
			}else{
			    $SalesPrice=$row['price'];			
			}
?>

<div class="content details-page">
			<!---start-product-details--->
			<div class="product-details">
				<div class="wrap">

				<div class="details-left">
					<div class="details-left-slider">
							<img src="<?php echo base_url();?>assets/images/productid_<?php echo $row['productID']; ?>.jpg" />
					</div>
					<div class="details-left-info">
						<div class="details-right-head">
						<h1><?php echo $row['productname'];?> </h1>
						<p class="product-detail-info"> <?php echo $row['description']; ?> </p>
						<div class="product-more-details">
							<ul class="price-avl">
								<li class="price"><span> <?php if($row['price']!= $SalesPrice){echo "$".$row['price'];} ?> </span><label><?php echo"$"."$SalesPrice" ?></label></li>
								<li class="stock"><i>In stock</i></li>
								<div class="clear"> </div>
							</ul>
							<ul class="prosuct-qty">
								<span>Quantity:</span>
                        			<select name="quantity" id="quantity">
                            			<option value="1" selected>1</option>
                            			<option value="2">2</option>
                            			<option value="3">3</option>
                            			<option value="4">4</option>
                            			<option value="5">5</option>
                            			<option value="6">6</option>
                            			<option value="7">7</option>
                            			<option value="8">8</option>
                        			</select>
							</ul>
							<input type="hidden" name='productID' value="<?php echo $row['productID'] ?>"/> 
			    			<input type="submit" value="AddtoCart"/>               
                			<input type="button" onclick="javascript:history.back()" value="Back"/>
						</div>
					</div>
					</div>
					<div class="clear"> </div>
				</div>
				<div class="clear"> </div>
			</div>
			<!----product-rewies---->
			<div class="product-reviwes">
				<div class="wrap">


       		<div class="clear"> </div>
       		<!--- start-similar-products--->
       		<div class="similar-products">
       				<h3>SIMILAR PRODUCTS</h3>
       			<div class="similar-products-right">
       				<div class="content-right">
					<div class="product-grids">
       			<?php
			    if($row_recom_first){
			    ?>
			    	<div onclick="location.href='<?php echo site_url('account/displayproduct/'.$row_recom_first['productID']);?>'" class="product-grid fade">
					<div class='product-pic'>
					<a href='#'><img src="<?php echo base_url();?>assets/images/productid_<?php echo $row_recom_first['productID']; ?>.jpg"/></a>
					<p>
					<a href='#'><?php echo $row_recom_first['productname'] ?></a>
					</p>
					</div>
					<div class='product-info'>
								<div class='clear'> </div>
							</div>
					</div>
			<?php
			    }
			    if($row_recom_second) {
			?>
			    	<div onclick="location.href='<?php echo site_url('account/displayproduct/'.$row_recom_second['productID']);?>'" class="product-grid fade">
					<div class='product-pic'>
					<a href='#'><img src="<?php echo base_url();?>assets/images/productid_<?php echo $row_recom_second['productID']; ?>.jpg"/></a>
					<p>
					<a href='#'><?php echo $row_recom_second['productname'] ?></a>
					</p>
					</div>
					<div class='product-info'>
								<div class='clear'> </div>
							</div>
					</div>
			<?php

			    }
            ?>
            	</div>
            	</div>
       			
       			
       			
       			
       			</div>
       			<div class="clear"> </div>
       		</div>
       		<!--- //End-similar-products--->
			</div>
			</div>
			<div class="clear"> </div>
			<!--//vertical Tabs-->
			<!----//product-rewies---->
			<!---//End-product-details--->
			</div>
		</div>
			    
			</form>     
            
			
<?php
		}
?>