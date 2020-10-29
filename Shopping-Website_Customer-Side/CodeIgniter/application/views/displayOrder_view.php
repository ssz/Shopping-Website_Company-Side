<?php
        $row = $order;
		if (!$row) {
			echo "<p align='center' style='color:red'>Cannot get the order info.</p>";
		}
		else {
			if (!$orderinfo) {
				echo "<p align='center' style='color:red'>Cannot get the order details.</p>";
			}
?>
			<div align='center'>
			<table>
			<tr>
				<td >Order ID: </td>
				<td><?php echo $orderid; ?></td>
			</tr>
			<tr>
				<td>Order Date: </td>
				<td><?php echo $row['orderdate']; ?></td>
			</tr>
			</table>
			
			<br>
			<table style='text-align:center'>
			<tr>
				<th>Product Name</th>
				<th>Product Quantity</th>
				<th>Product Price</th>
			</tr>

<?php
			foreach($orderinfo as $row2){
				echo "<tr>";
				echo "<td>".$row2['productname']."</td>";
				echo "<td>".$row2['productquantity']."</td>";
				echo "<td>$".$row2['price']."</td>";
				echo "</tr>";
			}
?>

			<tr>
				<td>Total Price:</td>
				<td></td>
				<td>$<?php echo $row['totalpay']; ?></td>
			</tr>
			</table>
			<br>

			<input type="button" onclick="javascript:history.back()" value="Back"/>
			</div>
<?php			
			 }
?>     