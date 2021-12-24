<?php
error_reporting(0);
include('../includes/dbconnection.php');
$action = $_POST['action'];
$id = trim($_POST['id']);
 if($action == "print") {	
 	// $msg  = "Service Report Between Date $startdate and $enddate";
	$query = "SELECT b.balance_amount, b.paid_amount, b.total_amount,b.coupen, b.coupen_id,b.coupen_discount, b.price_discount, b.discount_amount, b.gst_total, a.service_name, b.invoice_no,b.add_charge_total, a.actual_price,b.product_total, a.total,c.Name,date(b.create_time) as date,c.MobileNumber  FROM saloon_sale_service_cart a, saloon_sale_transaction b, tblcustomers c  WHERE  a.customer_id = b.customer_id and c.ID = b.customer_id and a.cart_invoice_no = b.invoice_no and a.cart_invoice_no = '$id'";
	error_log($query);
	$result=mysqli_query($con,$query );
	if($result) {
		$row_row = mysqli_fetch_assoc($result);
		$customer_name = $row_row['Name'];
		$invoice_no = $row_row['invoice_no'];
		$date = $row_row['date'];
		$MobileNumber = $row_row['MobileNumber'];
		$product_total =  number_format($row_row['product_total'],2);
		$add_charge_total =  number_format($row_row['add_charge_total'],2);
		$dis =  number_format(($row_row['discount_amount'] + $row_row['price_discount']),2);
		$gst_total =  number_format($row_row['gst_total'],2);
		$coupen = $row_row['coupen'];
		$coupen_id = $row_row['coupen_id'];
		$coupen_discount =  number_format($row_row['coupen_discount'],2);
		$total_amount = number_format($row_row['total_amount'],2);
		$balance_amount =  number_format($row_row['balance_amount'],2);
		$paid_amount = number_format($row_row['paid_amount'],2);
		$cgtaxgrp = ($gst_total) *  (47.36842105263158/100);
		$sgtaxgrp = ($gst_total) * (47.36842105263158/100);
		$kfcaxgrp = ($gst_total) * (5.263157894736842/100);
		$cgtaxgrp = number_format($cgtaxgrp,2);
		$sgtaxgrp = number_format($sgtaxgrp,2);
		$kfcaxgrp = number_format($kfcaxgrp,2);
		echo "<hr/>";
		echo "<table>
				<thead>
					<tr  style='background-color:white'>
						<td style='width:50%'>Customer: $customer_name</td>
					</tr>
					<tr  style='background-color:white'>
						<td style='width:50%'>Phone No: $MobileNumber</td>
					</tr>
					<tr  style='background-color:white'>
						<td style='width:50%'> Invoice No: $invoice_no</td>
					</tr>
					<tr  style='background-color:white'>
						<td style='width:50%'> Date: $date</td>
					</tr>
				</thead>
			  </table> <p></p> <hr>";
		echo "<table class='table table-bordered' id='table' style='border:none'> <thead>";

				echo "<tr>
						<th>#</th>
						<th>Service Name</th>  
						<th>Price</th>  
						<th>Total</th>  
					</tr>";
					
					echo "</thead><tbody>";
					$QUEY = "SELECT service_name, actual_price, total  FROM saloon_sale_service_cart  WHERE cart_invoice_no = '$id'";
					error_log($QUEY);
					$ret=mysqli_query($con,$QUEY );
					if($ret) {
						$co = mysqli_num_rows($ret);
						if($co > 0) {
							$i =1;
							while ($row=mysqli_fetch_array($ret)) {
								
							echo "<tr style='background-color:white;border:none'> 
									<td style='background-color:white;border:none' scope='row'>".$i."</td> 
									<td style='background-color:white;border:none' class='eve'>".$row['service_name']."</td> 
									<td style='background-color:white;border:none' class='eve'>".$row['actual_price']."</td> 
									<td  style='background-color:white;border:none' class='eve'>".$row['total']."</td> 
							</tr>";
								$i++;
						}
						}
						else {
							echo "<tr><th colspan='4'>No Data Found</th> </tr>";
						}
					}
					else {
						echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
					}
					echo "</tbody></table><hr />";
					echo "<table style='background-color:white;border:none'>
							<tr style='background-color:white;border:none' >
								<td style='width:50%;border:none;'>Basic Sales</td><td style='width:50%;border:none;'>$product_total</td>
							</tr>
							<tr style='background-color:white;border:none' >
								<td style='width:50%;border:none;'>Add Charges</td><td style='width:50%;border:none;'>$add_charge_total </td>
							</tr>
							<tr style='background-color:white;border:none' >
								<td style='width:50%;border:none;'>GST</td><td style='width:50%;border:none;'>$gst_total </td>
							</tr>
							<tr style='background-color:white;border:none' >
								<td style='width:50%;border:none;'>Discount</td><td style='width:50%;border:none;'>$dis </td>
							</tr>";
						if($coupen == "Y") {
							echo "<tr style='background-color:white;border:none' >
								<td style='width:50%;border:none;'>Coupen Discount</td><td style='width:50%;border:none;'>$coupen_discount </td>
							</tr>";
						}			
						echo "<tr style='background-color:white;border:none' >
								<td style='width:50%;border:none;'>Total Amount</td><td style='width:50%;border:none;'>$total_amount </td>
							</tr>";
						  echo "</table><hr>";
						  echo "<table style='background-color:white;border:none'>
							<tr style='background-color:white;border:none' >
								<td style='width:50%;border:none;'>Paid Amount</td><td style='width:50%;border:none;'>$paid_amount</td>
							</tr>
							<tr style='background-color:white;border:none' >
								<td style='width:50%;border:none;'>Balance Amount</td><td style='width:50%;border:none;'>$balance_amount</td>
							</tr>
							</table>";
							
							  echo "</table><hr>";
						  echo "<table style='background-color:white;border:none'>
							<tr style='background-color:white;border:none' >
								<td style='width:50%;border:none;'>CGST </td><td style='width:50%;border:none;'>$cgtaxgrp</td>
							</tr>
							<tr style='background-color:white;border:none' >
								<td style='width:50%;border:none;'>SGST</td><td style='width:50%;border:none;'>$sgtaxgrp</td>
							</tr>
							<tr style='background-color:white;border:none' >
								<td style='width:50%;border:none;'>KFC</td><td style='width:50%;border:none;'>$kfcaxgrp</td>
							</tr>
							</table>";
							 echo "<table style='background-color:white;border:none'>
							<tr style='background-color:white;border:none' >
								<td  style='text-align:left;'>GSTIN: 32AAOFJ3740J1ZA </td>  <td  style='text-align:right;'>Thank You..Visit Again </td>
							</tr>
						
							</table>";
	 }
 }
 ?>