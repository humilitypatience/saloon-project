<?php
error_reporting(0);
include('../includes/dbconnection.php');
$action = $_POST['action'];
 if($action == "query") {	
 //$reporttype = $_POST['reporttype']; 
 //$cate = $_POST['cate'];
 $type =$_POST['tygs']; 
 $startdate =$_POST['startdate']; 
 $enddate =$_POST['enddate']; 
 $detail =$_POST['detail']; 
 $datewise =$_POST['datewise']; 
 $QUEY = "";
 $msg = "";
echo "<table class='table table-bordered' id='table'> <thead>";



				 $msg  = "SALE REPORT - with GST Between Date $startdate and $enddate";
					echo "<tr>
						<th>#</th>
						
						<th>Customer Name</th>
						<th>Category</th> 
						<th>Service Name</th>  
						<th>Total Cost</th>  
						<th>Total Disount</th>  
						<th>GST Amount</th>  
						<th>Net Total</th>  
						  		
					</tr>";
					$QUEY = "SELECT c.price_discount as tradisscount, a.cart_invoice_no,c.invoice_no, c.coupen_discount, a.service_name as sername, b.Name as name,sum(a.actual_price) as cost,sum(a.total) as total,sum(a.discount_price) as discount_price, a.cart_invoice_no, sum(a.cgst+a.sgst) as gst, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblcustomers b,saloon_sale_transaction c, tblservices d  WHERE a.service_id = d.ID and a.cart_invoice_no = c.invoice_no and a.customer_id = b.ID   and date(c.transaction_date) between '$startdate' and '$enddate'  and  c.bill_type='C'  GROUP BY a.cart_invoice_no,c.invoice_no, a.customer_id,sername";
					
					
				echo "</thead><tbody>";
				error_log($QUEY);
					
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						 $wholeto =  0;
						 $discount_price  = 0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total'];
							$invoice_no = $row['cart_invoice_no'];
							$chck_invoice = $row['invoice_no'];
							if($chck_invoice == $invoice_no) {
								$discount_price =  $$discount_price;
							}
							else {
								$discount_price += $row['tradisscount'];
							}
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
							
								<td class='eve'>".$row['name']."</td> 
								<td class='eve'>".$row['category']."</td> 
								<td class='eve'>".$row['sername']."</td> 
								<td class='eve'>".$row['cost']."</td> 
								<td class='eve'>".$row['discount_price']."</td> 
								<td class='eve'>".$row['gst']."</td> 
								<td class='eve'>".$row['total']."</td> 
								
						</tr>";
							$i++;
					}
					$QUEY2 = "SELECT  sum(price_discount) as sprice_discount, sum(IFNULL(coupen_discount,0.00)) as  scoupen_discount FROM  saloon_sale_transaction WHERE  date(transaction_date) between '$startdate' and '$enddate'  and  bill_type='C' and invoice_no in (SELECT DISTINCT cart_invoice_no FROM saloon_sale_service_cart )  ";
					error_log($QUEY2);
					$ret2=mysqli_query($con,$QUEY2 );
					if($ret2) {
						$co2 = mysqli_num_rows($ret2);
						$row2=mysqli_fetch_array($ret2);
						$sprice_discount = $row2['sprice_discount'];
						$scoupen_discount = $row2['scoupen_discount'];
					}
					else {
						echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
					}
					echo "<tr>
							<td colspan = '7' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
							
						</tr>
						<tr>
							<td colspan = '7' style='text-align:right'>Total Coupen Disount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($scoupen_discount,2)."</b></td>
							
						</tr>
						<tr>
							<td colspan = '7' style='text-align:right'>Total Whole Disount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($sprice_discount,2)."</b></td>
							
						</tr>
						<tr>
							<td colspan = '7' style='text-align:right'>Total Net Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto - ($sprice_discount + $scoupen_discount),2)."</b></td>
							
						</tr></tbody></table>";
					}
					else {
						echo "<tr><th colspan='8'>No Data Found</th> </tr>";
					}
				}
				else {
					echo "<tr><th colspan='8'>".mysqli_error($con)."</th> </tr>";
				}
			}
	echo "</tbody> </table> <p style='text-align:left;color:red;font-size:14px'>Count: $co</p>";
	
 ?>