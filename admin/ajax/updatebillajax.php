<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('functions.php');
if (strlen($_SESSION['naturalsaid']==0)) {
  header('location:logout.php');
  } else{

  
include('../includes/dbconnection.php');
$action = $_POST['action'];
$invid = $_POST['invoice'];
if($action == "delete") {
	$invid = $_POST['id'];
	
	$saloon_sale_service_cart_query ="SELECT * FROM saloon_sale_service_cart WHERE cart_invoice_no = '$invid'";
	$saloon_sale_service_cart_result =mysqli_query($con, $saloon_sale_service_cart_query);
	if($saloon_sale_service_cart_result) {
		$cartcountrows = mysqli_num_rows($saloon_sale_service_cart_result);
		if($cartcountrows > 0) {
			$querypreparecart = "INSERT INTO  dlt_saloon_sale_service_cart (additional_charge, employee_id, cart_invoice_no, service_id, service_name, actual_price, discount_price, cgst, sgst, total, customer_id) VALUES";
			$i = 0;
			while($row=mysqli_fetch_assoc($saloon_sale_service_cart_result)) {					
		
			
					
					if($i !=  $cartcountrows-1) {
						$delimiter = ",";
					}
					else {
						$delimiter = "";
					}
					$additional_charge = $row['additional_charge'];
					$employee_id = $row['employee_id'];
					$cart_invoice_no = $row['cart_invoice_no'];
					$service_id = $row['service_id'];
					$service_name = $row['service_name'];
					$actual_price = $row['actual_price'];
					$discount_price = $row['discount_price'];
					$cgst = $row['cgst'];
					$sgst = $row['sgst'];
					$total = $row['total'];
					$customer_id = $row['customer_id'];
					$querypreparecart .= "( $additional_charge,$employee_id,'$cart_invoice_no',$service_id ,'$service_name',$actual_price,$discount_price,$cgst,$sgst,$total,$customer_id ) $delimiter " ;
						$i++;
				
			}
				error_log("CARTQUERY".$querypreparecart);
				$ret1=mysqli_query($con,$querypreparecart );			
				if($ret1) {
					
						$saloon_sales_query ="SELECT * FROM saloon_sales WHERE invoice_no = '$invid'";
						$saloon_sales__result =mysqli_query($con, $saloon_sales_query);
						if($saloon_sales__result) {
							$countrowssales = mysqli_num_rows($saloon_sales__result);
							if($countrowssales > 0) {
								$queryprepare3 = "INSERT INTO  dlt_saloon_sales (staff_id, invoice_no, customer_id, customer_name, total_no_service, total_bill, status)
																VALUES ";
								while($row=mysqli_fetch_assoc($saloon_sales__result)) {					
									for ($i = 0; $i < $countrowssales; $i++) {
									
										if($i !=  $countrowssales-1) {
											$delimiter = ",";
										}
										else {
											$delimiter = "";
										}
										$staff_id = $row['staff_id'];
										$invoice_no = $row['invoice_no'];
										$customer_id = $row['customer_id'];
										$customer_name = $row['customer_name'];
										$total_no_service = $row['total_no_service'];
										$total_bill = $row['total_bill'];
										$status = $row['status'];
										$queryprepare3 .= "( $staff_id,'$invoice_no', $customer_id,'$customer_name', $total_no_service, $total_bill, 'E') $delimiter " ;
										
									}
								}
									error_log($queryprepare3);
									$ret2=mysqli_query($con,$queryprepare3 );									
									if($ret2) {
										$saloon_sales_transaction_query ="SELECT * FROM saloon_sale_transaction WHERE invoice_no = '$invid'";
										error_log($saloon_sales_transaction_query);
										$saloon_sales_transaction_result =mysqli_query($con, $saloon_sales_transaction_query);
										if($saloon_sales_transaction_result) {
											$countrowstra = mysqli_num_rows($saloon_sales_transaction_result);
											if($countrowstra > 0) {
												$querypreparequeryquer = "INSERT INTO  dlt_saloon_sale_transaction (dlt_time, invoice_no, total_item, coupen, coupen_id, coupen_discount, transaction_date, customer_id, total_amount, paid_amount, discount_amount, balance_amount, status, payment_mode, create_time, tra_reference_no, product_total, gst_total, add_charge_total, price_discount, bill_type)
																				VALUES ";
												while($row=mysqli_fetch_assoc($saloon_sales_transaction_result)) {					
													for ($i = 0; $i < $countrowstra; $i++) {
													
														if($i !=  $countrowstra-1) {
															$delimiter = ",";
														}
														else {
															$delimiter = "";
														}
														$invoice_no = $row['invoice_no'];
														$total_item = $row['total_item'];
														$coupen = $row['coupen'];
														$coupen_id = $row['coupen_id'];
														$coupen_discount = $row['coupen_discount'];
														IF($coupen_discount == "" ) {
															$coupen_discount = 0;
														}
														$transaction_date = $row['transaction_date'];
														$customer_id = $row['customer_id'];
														$total_amount = $row['total_amount'];
														$paid_amount = $row['paid_amount'];
														$discount_amount = $row['discount_amount'];
														$balance_amount = $row['balance_amount'];
														$status = $row['status'];
														$payment_mode = $row['payment_mode'];
														$create_time = $row['create_time'];
														$tra_reference_no = $row['tra_reference_no'];
														$product_total = $row['product_total'];
														$gst_total = $row['gst_total'];
														$add_charge_total = $row['add_charge_total'];
														$price_discount = $row['price_discount'];
														$bill_type = $row['bill_type'];
														
														$querypreparequeryquer .= "(now(), '$invoice_no', '$total_item' ,'$coupen', '$coupen_id', '$coupen_discount', '$transaction_date', '$customer_id', '$total_amount', '$paid_amount', '$discount_amount', '$balance_amount', '$status', '$payment_mode', '$create_time', '$tra_reference_no','$product_total','$gst_total','$add_charge_total','$price_discount','$bill_type') $delimiter " ;
														
													}
												}
													error_log($querypreparequeryquer);
													$ret3=mysqli_query($con,$querypreparequeryquer );			
													if($saloon_sales_transaction_result && $saloon_sale_service_cart_result && $saloon_sales__result && $ret1 && $ret2&& $ret3) {
														$query = "DELETE FROM saloon_sale_service_cart WHERE cart_invoice_no = '$invid'";
														$result = mysqli_query($con, $query);
														$query = "DELETE FROM saloon_sale_transaction WHERE invoice_no = '$invid'";
														$result = mysqli_query($con, $query);
														$query = "DELETE FROM saloon_sales WHERE invoice_no = '$invid'";
														$result = mysqli_query($con, $query);
														echo "Invoice $invid Canceled Successfully";
													}
													else {
														echo "Invoice $invid Canceled Failed";
													}	
												}
											}		
											else {
												echo "Cart Error: ".mysqli_error($con);
											}
										
										}
										else {
											echo "Cart Error: ".mysqli_error($con);
										}
									}							
									
							else {
							}
				}
							else {
								echo "Cart Error: ".mysqli_error($con);
							}
						}
						
					}
				else {
		}
	
}
else {
		echo "Cart Error: ".mysqli_error($con);
	}
			}
		
		
if($action == "submit") {
	$query = "DELETE FROM saloon_sale_service_cart WHERE cart_invoice_no = '$invid'";
	$result = mysqli_query($con, $query);
	$query = "DELETE FROM saloon_sale_transaction WHERE invoice_no = '$invid'";
	$result = mysqli_query($con, $query);
	$query = "DELETE FROM saloon_sales WHERE invoice_no = '$invid'";
	$result = mysqli_query($con, $query);
	$id = json_decode($_POST["ids"]);
	$serviceName = json_decode($_POST["serviceName"]);
	$discounts = json_decode($_POST["discounts"]);
	$costs = json_decode($_POST["costs"]);
	$cgsts = json_decode($_POST["cgsts"]);
	$sgsts = json_decode($_POST["sgsts"]);
	$totals = json_decode($_POST["totals"]);
	$employees = json_decode($_POST["employees"]);
	$adcharge = json_decode($_POST["adcharge"]);
	$proTotalAmt = $_POST["proTotalAmt"];
	$customer = $_POST["cus"];
	$codi = $_POST["codi"]; 
	$coupen = $_POST["coupen"];
	$type = $_POST["type"];
	$par = 0;$ret_seq = "";
	if($type=='C') {
		$par = 1;
		$ret_seq = "INA".date('Ymd');
	}
	if($type=='S') {
		$par = 2;
		$ret_seq = "INB".date('Ymd');
	}
//	$invoice_no = generate_seq_num($par, $con);
	$invoice_no = $invid;
	$count =  count($id);
	//error_log($count);
	$delimiter = "";
	$coupen_on = 'N';
	$totalDiscount = 0.00;
	$total = $_POST['total'];
	if($coupen == -1) {
		$codi = 'NULL';
		$coupen_on = 'N';
		
	}
	else {
		$codi =$_POST["codi"]; 
		$totalDiscount = $totalDiscount +  $codi;
		$coupen_on = 'Y';
	}
	$paid_amount =$_POST['paymentamount'];
	
	$staff_id = $_SESSION['naturalsaid'];
	$balance_amount = $_POST['balanceamount'];
	$paymentMode = $_POST['paymentMode'];
	$customerName = $_POST['customerName'];
	$ts = $_POST['tgs'];
	$txref =$_POST['txref']; 
	$prodis = $_POST['prodis']; 
	$pridis = $_POST['pridis']; 
	$addcharge = $_POST['addcha'];
	$tdate = 	$_POST['tdate'];
	$queryprepare = "INSERT INTO  saloon_sale_service_cart (additional_charge, employee_id, cart_invoice_no, service_id, service_name, actual_price, discount_price, cgst, sgst, total, customer_id) VALUES";
	for ($i = 0; $i < $count; $i++) {
		$totalDiscount += $totalDiscount[$i];
		if($i !=  $count-1) {
			$delimiter = ",";
		}
		else {
			$delimiter = "";
		}
		$queryprepare .= "( $adcharge[$i],$employees[$i],'$invoice_no',$id[$i] ,'$serviceName[$i]',$costs[$i],$discounts[$i],$cgsts[$i],$sgsts[$i],$totals[$i],$customer ) $delimiter " ;
		
	}
	error_log($queryprepare);
	$ret=mysqli_query($con,$queryprepare );
	echo "<div class='modal-body cusmodel'> ";
	if($ret) {
			$queryprepare2 = "INSERT INTO  saloon_sales (staff_id, invoice_no, customer_id, customer_name, total_no_service, total_bill, status)
											VALUES( $staff_id,'$invoice_no', $customer,'$customerName', $count, $total, 'E')";
			error_log($queryprepare2);
			$ret3=mysqli_query($con,$queryprepare2 );
			if($queryprepare2) {
				$queryprepare1 = "INSERT INTO  saloon_sale_transaction (bill_type, price_discount, discount_amount, gst_total, product_total, add_charge_total, tra_reference_no, invoice_no, total_item, coupen, coupen_id, coupen_discount, transaction_date, customer_id , total_amount, paid_amount,balance_amount, status, payment_mode, create_time)
												VALUES('$type',$pridis, $prodis, $ts ,'$proTotalAmt', $addcharge, '$txref','$invoice_no', $count,'$coupen_on', $coupen, $codi, '$tdate',$customer, $total, $paid_amount,$balance_amount,'E','$paymentMode',now())";
				error_log($queryprepare1);
				$ret2=mysqli_query($con,$queryprepare1 );
				
				$upddate_query = "UPDATE tblcustomers SET last_invoice_id = '$invoice_no' WHERE ID = $customer";
				//error_log($upddate_query);
				$ret4=mysqli_query($con,$upddate_query );
				if($queryprepare2) {
					echo "<p style='text-align: center;font-size: x-large;font-family: monospace;color: black;'>Invoice No  <span id='inno'> $invoice_no </span>  Created Successfully</p>";
				}
				else {
					echo mysqli_error($con);
				}
					
			}
			else{
				echo mysqli_error($con);
			}
	}
	else {
		echo mysqli_error($con);
	}
	echo "</div>";
  }}
?>