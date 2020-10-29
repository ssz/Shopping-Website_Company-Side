<?php
		if(isset($msg)) {
			echo "<p align='center' style='color:red'>".$msg."</p>";
		}
		
		//$sql = "SELECT orderID, customerID, orderdate, totalpay from orderlist WHERE customerID = '$customerid' ORDER BY orderID DESC";
		if (!$orderlist) {
			echo "<p align='center' style='color:red'>There is no orders in your account.</p>";
		} else {
?>	
			<div class='wrap' align='center'>
			<table  style='text-align:center'>
				<tr>
					<th>OrderID</th>
					<th>Date</th>
					<th>Total Price</th>
				</tr>
<?php
			foreach($orderlist as $row) {
?>
				<tr>
				<td><a href='<?php echo site_url('account/displayOrder/'.$row['orderID']);?>'><?php echo $row['orderID'] ?></a></td>
				<td><?php echo $row['orderdate'] ?></td>
				<td>$<?php echo $row['totalpay'] ?></td>
				</tr>
<?php
			}
		
?>
			</table>
			</div>
<?php	}
?>
   
