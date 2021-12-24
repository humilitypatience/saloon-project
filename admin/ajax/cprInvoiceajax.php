<?php
error_reporting(0);
include('../includes/dbconnection.php');
$action = $_POST['action'];
 if($action == "query") {	
 //$cate = $_POST['cate'];
  $startdate =$_POST['startdate']; 
 $enddate =$_POST['enddate']; 
 $invoice =$_POST['invoice']; 
 $typeselect = $_POST['typeselect']; 
  $reportfor = $_POST['reportfor']; 
  $QUEY = "";


		echo "<table class='table table-bordered' id='table'> <thead>";
				echo "<tr>
					<th>#</th>
					<th>Total Item</th>  
					<th>Transaction Date</th>  
					<th>Total Amount</th> 
					<th>Customer Name</th>
					<th>Detail</th>
					
				</tr>";
				if($reportfor  == "ALL") {
					if($typeselect == "in") {
						if($invoice == "ALL"){
							$QUEY = "select DISTINCT a.invoice_no,a.total_item,a.transaction_date,a.total_amount,concat(b.Name,' - ',b.MobileNumber) as Customer from dlt_saloon_sale_transaction a, tblcustomers b, dlt_saloon_sale_service_cart c where a.invoice_no = c.cart_invoice_no and  a.customer_id=b.ID ";
						}
						else {
							$QUEY = "select DISTINCT a.invoice_no,a.total_item,a.transaction_date,a.total_amount,concat(b.Name,' - ',b.MobileNumber) as Customer from dlt_saloon_sale_transaction a, tblcustomers b, dlt_saloon_sale_service_cart c where a.invoice_no = c.cart_invoice_no and  a.customer_id=b.ID  and a.invoice_no = '$invoice'";
						}
					}
					else{
						$QUEY = "select DISTINCT a.invoice_no,a.total_item,a.transaction_date,a.total_amount,concat(b.Name) as Customer from dlt_saloon_sale_transaction a, tblcustomers b, dlt_saloon_sale_service_cart c  where a.invoice_no = c.cart_invoice_no and  a.customer_id=b.ID and (date(a.transaction_date) between '$startdate' and '$enddate') ORDER BY invoice_no desc";
					}
				}
				else {
					if($typeselect == "in") {
						if($invoice == "ALL"){
							$QUEY = "select DISTINCT a.invoice_no,a.total_item,a.transaction_date,a.total_amount,concat(b.Name,' - ',b.MobileNumber) as Customer from dlt_saloon_sale_transaction a, tblcustomers b, dlt_saloon_sale_service_cart c where a.invoice_no = c.cart_invoice_no and  a.customer_id=b.ID and a.bill_type = '$reportfor'";
						}
						else {
							$QUEY = "select DISTINCT a.invoice_no,a.total_item,a.transaction_date,a.total_amount,concat(b.Name,' - ',b.MobileNumber) as Customer from dlt_saloon_sale_transaction a, tblcustomers b, dlt_saloon_sale_service_cart c where a.invoice_no = c.cart_invoice_no and  a.customer_id=b.ID  and a.invoice_no = '$invoice' and a.bill_type = '$reportfor'";
						}
					}
					else{
						$QUEY = "select DISTINCT a.invoice_no,a.total_item,a.transaction_date,a.total_amount,concat(b.Name) as Customer from dlt_saloon_sale_transaction a, tblcustomers b, dlt_saloon_sale_service_cart c  where a.invoice_no = c.cart_invoice_no and  a.customer_id=b.ID and a.bill_type = '$reportfor' and (date(a.transaction_date) between '$startdate' and '$enddate') ORDER BY invoice_no desc";
					}
				}
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
			$co = mysqli_num_rows($ret);
			if($co > 0) {
				$i =1;
				while ($row=mysqli_fetch_array($ret)) {
					
				echo "<tr> 
						<td class='eve'>".$row['invoice_no']."</td>  
						<td class='eve'>".$row['total_item']."</td> 
						<td class='eve'>".$row['transaction_date']."</td> 
						<td class='eve'>".$row['total_amount']."</td> 
						<td class='eve'>".$row['Customer']."</td>
						<td><input type='button'  data-toggle='modal' data-target='#getinvoice' class='btn btn-warning  getinvoice ' id='".$row['invoice_no']."' value='Detail'/></td>						
						
						
						</tr>";
					$i++;
			}
			}
			else {
				echo "<tr><th colspan='3'>No Data Found</th> </tr>";
			}
		}
		else {
			echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
		}
 }
 
	
if($action == "getinvoicem") {
	$id = $_POST['id'];
	
	$dlt_saloon_sale_transaction_query = "SELECT a.price_discount, a.gst_total, a.add_charge_total, a.product_total, IF(a.bill_type = 'C','Customer',IF(a.bill_type = 'S','Staff','Others')) as bill_type, a.invoice_no, a.coupen as valcou, if(a.coupen='Y',(SELECT name FROM saloon_campaign WHERE ID = a.coupen_id ),'No Coupen Applied') as coupen, a.coupen_discount, a.total_item, (SELECT CONCAT(customer_name ) FROM tblcustomers WHERE ID = a.customer_id) as customer,  a.transaction_date, a.total_amount, a.paid_amount,a.discount_amount, a.balance_amount, IF(a.payment_mode = 'CI','CASH-IN-HAND','CARD') as payment_mode, a.create_time, IFNULL((SELECT CONCAT(UserName,' - ',MobileNumber) FROM tbladmin WHERE ID = b.staff_id),' - ') as staff_id, b.total_bill FROM dlt_saloon_sale_transaction a, dlt_saloon_sales b  WHERE a.invoice_no = b.invoice_no and a.invoice_no = '$id' " ;
	error_log($dlt_saloon_sale_transaction_query);
	$dlt_saloon_sale_transaction_result=mysqli_query($con,$dlt_saloon_sale_transaction_query );
	if($dlt_saloon_sale_transaction_result) {
		$row2 = mysqli_fetch_assoc($dlt_saloon_sale_transaction_result);
		$invoice_no = $row2['invoice_no'];
		$coupen = $row2['coupen'];
		$coupen_discount = $row2['coupen_discount'];
		$transaction_date = $row2['transaction_date'];
		$paid_amount = $row2['paid_amount'];
		$total_amount = $row2['total_amount'];
		$discount_amount = $row2['discount_amount'];
		$balance_amount = $row2['balance_amount'];
		$payment_mode = $row2['payment_mode'];
		$staff_id = $row2['staff_id'];
		$total_item = $row2['total_item'];
		$customer = $row2['customer'];
		$valcou = $row2['valcou'];
		$bill_type = $row2['bill_type'];
		$product_total = number_format($row2['product_total'],2);
		$add_charge_total = number_format($row2['add_charge_total'],2);
		$gst_total = number_format($row2['gst_total'],2);
		$price_discount = number_format($row2['price_discount'],2);
		$varco = "";
		if($valcou == "Y") {
			$varcou = "Yes";
		}
		else {
			$varcou = "No";
		}
		$dlt_saloon_sale_service_cart_query = "SELECT dlt_cart_id, service_name, actual_price, discount_price, cgst, sgst, total FROM dlt_saloon_sale_service_cart  WHERE cart_invoice_no = '$id'" ;
		//error_log($dlt_saloon_sale_service_cart_query);
		$dlt_saloon_sale_service_cart_result=mysqli_query($con,$dlt_saloon_sale_service_cart_query );
		echo "<div class='modal-body cusmodlt' style='padding:0px'> 
				<div class='col-lg-8'>
			 <table class='table table-bordered' width='100%' border='1'> 
						<thead>							
							<tr>
								<th >Invoice No: $invoice_no</th>			
								<th >Customer Name: $customer</th>								
							</tr>
							<tr>
								<th>Date: $transaction_date</th>
								<th>Staff: $staff_id</th>
							</tr>
						</thead>
						<tbody id='tbody'>
							<tr>
								
							</tr>
						</tbody>
				</table>";
		echo "
			  <table class='table table-bordered' width='100%' border='1'> 
								<thead>							
									<tr>
										<th>#</th>
										<th>Service</th>
										<th>Cost</th>
										<th>Discount</th>
										<th>CGST</th>
										<th>SGST</th>
										<th>Total</th>
									</tr>
								</thead>
									<tbody id='tbody'>";
		if($dlt_saloon_sale_service_cart_result) {
			$co = mysqli_num_rows($dlt_saloon_sale_service_cart_result);
			if($co > 0) {
				while($row = mysqli_fetch_assoc($dlt_saloon_sale_service_cart_result)) {
					$dlt_cart_id = $row['dlt_cart_id'];
					$service_name = $row['service_name'];
					$actual_price = $row['actual_price'];	
					$discount_price = $row['discount_price'];	
					$cgst = $row['cgst'];	
					$sgst = $row['sgst'];	
					$total = $row['total'];	
					
					echo "<tr><td>$dlt_cart_id</td>
							<td>$service_name</td>
							<td>$actual_price</td>
							<td>$discount_price</td>
							<td>$cgst</td>
							<td>$sgst</td>
							<td>$total</td>
						</tr>";
				}					
				echo "</tbody></table></div><div class='col-lg-4'>
				<table class='table table-bordered'>
					
					<tr><th style='text-align:right'>Bill Type :</th><th> $bill_type</th></tr>
					<tr><th style='text-align:right'>Product Total :</th><th> $product_total</th></tr>
					<tr><th style='text-align:right'>Extra Charges :</th><th> $add_charge_total</th></tr>
					<tr><th style='text-align:right'>Total GST : </th><th>$gst_total</th></tr>
					<tr><th style='text-align:right'>Service Discount : </th><th>$price_discount</th></tr>
					<tr><th style='text-align:right'>Coupen : </th><th>$varcou</th></tr>
					<tr><th style='text-align:right'>Total Item : </th><th>$total_item</th></tr>
					<tr><th style='text-align:right'>Total Amount : </th><th>$total_amount</th></tr>
					<tr><th style='text-align:right'>Discount Amount :</th><th> $discount_amount</th></tr>
					<tr><th style='text-align:right'>Coupen Discount :</th><th> $coupen_discount</th></tr>
					<tr><th style='text-align:right'>Paid Amount :</th><th> $paid_amount</th></tr>
					<tr><th style='text-align:right'>Balance Amount :</th><th> $balance_amount</th></tr>
					<tr><th style='text-align:right'>Payment Mode :</th><th> $payment_mode</th></tr>
				</table>
				
				";
			}
			else {
				echo "<tr>
						<th colspan='6'>No Customer Detail Found..</th>	
					</tr>";
			}
		}
		else {
			echo "<tr>
					<th colspan='6'>".mysqli_error($con)."</th>	
				</tr>";
		}
		echo "</div> ";
	}
	else {
		echo "<tr>
					<th colspan='6'>".mysqli_error($con)."</th>	
				</tr>";
	}
}
 ?>