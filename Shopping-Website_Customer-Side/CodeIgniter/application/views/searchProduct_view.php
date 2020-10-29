<?php 
	if (!$result){
		echo "<p align='center' style='color:red'>Your search did not match any products</p>";
		exit();
	}	
?>
	<div class="content-right">
	<div class="product-grids">
<?php
	    foreach ($specialsale as $row_s){
		$saleprice=round($row_s['price']*(1-$row_s['discount']*0.01),2);
?>

		<div onclick="location.href='<?php echo site_url('account/displayproduct/'.$row_s['productID']);?>'" class="product-grid fade">
		<div class='product-pic'>
		<a href='#'><img src="<?php echo base_url();?>assets/images/productid_<?php echo $row_s['productID']; ?>.jpg"/></a>
		<p>
		<a href='#'><?php echo $row_s['productname']?></a>
		</p>
			</div>
			<div class='product-info'>
				<div class='product-info-cust'>
					<a href='#'><?php echo $row_s['productcategoryname'] ?></a>
				</div>
				<div class='product-info-price'>
				<a href='#' style='color:red'><?php echo $saleprice ?></a>
		</div>
								<div class='clear'> </div>
							</div>
							<div class='more-product-info'>
								<span style='color:red'>Sale</span>
							</div>
						</div>
<?php	}
	
		foreach ($nonspecialsale as $row_p){
?>
			<div onclick="location.href='<?php echo site_url('account/displayproduct/'.$row_p['productID']);?>'" class="product-grid fade">
			<div class='product-pic'>
			<a href='#'><img src="<?php echo base_url();?>assets/images/productid_<?php echo $row_p['productID']; ?>.jpg"/></a>
			<p>
			<a href='#'><?php echo $row_p['productname'] ?></a>
			</p>
				</div>
				<div class='product-info'>
					<div class='product-info-cust'>
						<a href='#'><?php echo $row_p['productcategoryname'] ?></a>
					</div>
					<div class='product-info-price'>
					<a href='#'><?php echo $row_p['price'] ?></a>
				</div>
								<div class='clear'> </div>
							</div>
							<div class='more-product-info'>
								<span></span>
							</div>
						</div>	
<?php	}?>
	</div>
	</div>