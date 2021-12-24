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

	if($detail != "Y") {	
		if($datewise != "Y") {
			if($type == "WIG") {
				 $msg  = "SALE REPORT - with GST Between Date $startdate and $enddate";
					echo "<tr>
						<th>#</th>
						<th>Customer Name</th>  
						<th>Total Cost</th>  
						<th>Total Disount</th>  
						<th>GST Amount</th>  
						<th>Total Amount</th>  		
					</tr>";
					$QUEY = "SELECT b.Name as name,sum(a.actual_price) as cost,sum(a.total) as total,sum(a.discount_price) as discount_price,  sum(cgst+sgst) as gst FROM saloon_sale_service_cart a, tblcustomers b,saloon_sale_transaction c  WHERE a.cart_invoice_no = c.invoice_no and a.customer_id = b.ID and date(c.transaction_date) between '$startdate' and '$enddate'  and  c.bill_type='S'  GROUP BY b.Name";
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						 $wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total'];
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['name']."</td> 
								<td class='eve'>".$row['cost']."</td> 
								<td class='eve'>".$row['discount_price']."</td> 
								<td class='eve'>".$row['gst']."</td> 
								<td class='eve'>".$row['total']."</td> 
						</tr>";
							$i++;
					}
					echo "<tr>
							<td colspan = '5' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
						
					}
					else {
						echo "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
			}
			else if($type == "WOG") {
						 $msg  = "SALE REPORT - WITH OUT GST Between Date $startdate and $enddate";
					echo "<tr>
						<th>#</th>
						<th>Customer Name</th>  
						<th>Total Cost</th>  
						<th>Total Disount</th>  
						<th>Total Amount</th>  		
					</tr>";
					$QUEY = "SELECT b.Name as name,sum(a.actual_price) as cost,sum(a.total) as total,sum(a.discount_price) as discount_price,  sum(cgst+sgst) as gst FROM saloon_sale_service_cart a, tblcustomers b,saloon_sale_transaction c  WHERE a.cart_invoice_no = c.invoice_no and a.customer_id = b.ID and date(c.transaction_date) between '$startdate' and '$enddate'  and  c.bill_type='S'  GROUP BY b.Name";
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						 $wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total'];
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['name']."</td> 
								<td class='eve'>".$row['cost']."</td> 
								<td class='eve'>".$row['discount_price']."</td> 
								<td class='eve'>".$row['total']."</td> 
						</tr>";
							$i++;
					}
					echo "<tr>
							<td colspan = '4' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
					}
					else {
						echo "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
			}
			else if($type == "GSA") {
						 $msg  = "SALE REPORT - WITH OUT GST Between Date $startdate and $enddate";
					echo "<tr>
						<th>#</th>
						<th>Customer Name</th>  
						<th>CGST</th>  
						<th>SGST</th>  
						<th>Total GST</th>  		
					</tr>";
				$QUEY = "SELECT b.Name as name,sum(a.cgst) as cgst,sum(a.sgst) as sgst,sum(a.discount_price) as discount_price,  sum(cgst+sgst) as gst FROM saloon_sale_service_cart a, tblcustomers b,saloon_sale_transaction c  WHERE a.cart_invoice_no = c.invoice_no and a.customer_id = b.ID and date(c.transaction_date) between '$startdate' and '$enddate'  and  c.bill_type='S'  GROUP BY b.Name";
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						$wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total'];
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['name']."</td> 
								<td class='eve'>".$row['cgst']."</td> 
								<td class='eve'>".$row['sgst']."</td> 
								<td class='eve'>".$row['gst']."</td> 
						</tr>";
							$i++;
					}
					echo "<tr>
							<td colspan = '4' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
					}
					else {
						echo "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
			}
		}
		else {
			  $msg  = "Sale SALE REPORT Datewise - with GST Between Date $startdate and $enddate";
			if($type == "WIG") {
				
					echo "<tr>
						<th>#</th>
						<th>Customer Name</th> 
						<th>Date</th>  						
						<th>Total Cost</th>  
						<th>Total Disount</th>  
						<th>GST Amount</th>  
						<th>Total Amount</th>  		
					</tr>";
					$QUEY = "SELECT b.Name as name,c.transaction_date,sum(a.actual_price) as cost,sum(a.total) as total,sum(a.discount_price) as discount_price,  sum(cgst+sgst) as gst FROM saloon_sale_service_cart a, tblcustomers b,saloon_sale_transaction c  WHERE a.cart_invoice_no = c.invoice_no and a.customer_id = b.ID and date(c.transaction_date) between '$startdate' and '$enddate'  and  c.bill_type='S'  GROUP BY b.Name,c.transaction_date";
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						$wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total'];
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['name']."</td> 
								<td class='eve'>".$row['transaction_date']."</td> 
								<td class='eve'>".$row['cost']."</td> 
								<td class='eve'>".$row['discount_price']."</td> 
								<td class='eve'>".$row['gst']."</td> 
								<td class='eve'>".$row['total']."</td> 
						</tr>";
							$i++;
					}
					echo "<tr>
							<td colspan = '6' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
					}
					else {
						echo "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
			}
			else if($type == "WOG") {
						 $msg  = "SALE REPORT - WITH OUT GST Between Date $startdate and $enddate";
					echo "<tr>
						<th>#</th>
						<th>Customer Name</th>  
						<th>Date</th>  
						<th>Total Cost</th>  
						<th>Total Disount</th>  
						<th>Total Amount</th>  		
					</tr>";
					$QUEY = "SELECT b.Name as name,c.transaction_date,sum(a.actual_price) as cost,sum(a.total) as total,sum(a.discount_price) as discount_price,  sum(cgst+sgst) as gst FROM saloon_sale_service_cart a, tblcustomers b,saloon_sale_transaction c  WHERE a.cart_invoice_no = c.invoice_no and a.customer_id = b.ID and date(c.transaction_date) between '$startdate' and '$enddate'  and  c.bill_type='S'  GROUP BY b.Name,c.transaction_date";
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						$wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total'];
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['name']."</td> 
								<td class='eve'>".$row['transaction_date']."</td> 
								<td class='eve'>".$row['cost']."</td> 
								<td class='eve'>".$row['discount_price']."</td> 
								<td class='eve'>".$row['total']."</td> 
						</tr>";
							$i++;
					}
					echo "<tr>
							<td colspan = '5' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
					}
					else {
						echo "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
			}
			else if($type == "GSA") {
						 $msg  = "SALE REPORT - WITH OUT GST Between Date $startdate and $enddate";
					echo "<tr>
						<th>#</th>
						<th>Customer Name</th>  
						<th>Date</th>  
						<th>CGST</th>  
						<th>SGST</th>  
						<th>Total GST</th>  		
					</tr>";
				$QUEY = "SELECT b.Name as name,c.transaction_date,sum(a.cgst) as cgst,sum(a.sgst) as sgst,sum(a.discount_price) as discount_price,  sum(cgst+sgst) as gst FROM saloon_sale_service_cart a, tblcustomers b,saloon_sale_transaction c  WHERE a.cart_invoice_no = c.invoice_no and a.customer_id = b.ID and date(c.transaction_date) between '$startdate' and '$enddate'  and  c.bill_type='S'  GROUP BY b.Name,c.transaction_date";
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						$wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total'];
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['name']."</td> 
								<td class='eve'>".$row['transaction_date']."</td> 
								<td class='eve'>".$row['cgst']."</td> 
								<td class='eve'>".$row['sgst']."</td> 
								<td class='eve'>".$row['gst']."</td> 
						</tr>";
							$i++;
					}
					echo "<tr>
							<td colspan = '5' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
					}
					else {
						echo "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
			}
		}
	}
	else {				

		if($datewise != "Y") {
			if($type == "WIG") {
				 $msg  = "SALE REPORT - with GST Between Date $startdate and $enddate";
					echo "<tr>
						<th>#</th>
						<th>Customer Name</th>
						<th>Category</th> 
						<th>Service Name</th>  
						<th>Total Cost</th>  
						<th>Total Disount</th>  
						<th>GST Amount</th>  
						<th>Total Amount</th>  		
					</tr>";
					$QUEY = "SELECT   a.service_name as sername, b.Name as name,sum(a.actual_price) as cost,sum(a.total) as total,sum(a.discount_price) as discount_price,  sum(a.cgst+a.sgst) as gst, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblcustomers b,saloon_sale_transaction c, tblservices d  WHERE a.service_id = d.ID and a.cart_invoice_no = c.invoice_no and a.customer_id = b.ID and  date(c.transaction_date) between '$startdate' and '$enddate'  and  c.bill_type='S'  GROUP BY b.Name,a.service_name";
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						$wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total'];
							
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
					echo "<tr>
							<td colspan = '7' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
					}
					else {
						echo "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
			}
			else if($type == "WOG") {
						 $msg  = "SALE REPORT - WITH OUT GST Between Date $startdate and $enddate";
					echo "<tr>
						<th>#</th>
						<th>Customer Name</th>  
						<th>Category</th> 
						<th>Service Name</th>  
						<th>Total Cost</th>  
						<th>Total Disount</th>  
						<th>Total Amount</th>  		
					</tr>";
					$QUEY = "SELECT a.service_name as sername, b.Name as name,sum(a.actual_price) as cost,sum(a.total) as total,sum(a.discount_price) as discount_price,  sum(a.cgst+a.sgst) as gst, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblcustomers b,saloon_sale_transaction c , tblservices d  WHERE      a.service_id = d.ID and a.cart_invoice_no = c.invoice_no and a.customer_id = b.ID and date(c.transaction_date) between '$startdate' and '$enddate'  and  c.bill_type='S'  GROUP BY b.Name,a.service_name";
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						$wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total'];
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['name']."</td> 
								<td class='eve'>".$row['category']."</td>
								<td class='eve'>".$row['sername']."</td> 
								<td class='eve'>".$row['cost']."</td> 
								<td class='eve'>".$row['discount_price']."</td> 
								<td class='eve'>".$row['total']."</td> 
						</tr>";
							$i++;
					}
					echo "<tr>
							<td colspan = '6' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
					}
					else {
						echo "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
			}
			else if($type == "GSA") {
						 $msg  = "SALE REPORT - WITH OUT GST Between Date $startdate and $enddate";
					echo "<tr>
						<th>#</th>
						<th>Customer Name</th> 
						<th>Category</th> 						
						<th>Service Name</th>  
						<th>CGST</th>  
						<th>SGST</th>  
						<th>Total GST</th>  		
					</tr>";
				$QUEY = "SELECT a.service_name as sername, b.Name as name,sum(a.cgst) as cgst,sum(a.sgst) as sgst,sum(a.discount_price) as discount_price,  sum(a.cgst+a.sgst) as gst, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblcustomers b,saloon_sale_transaction c, tblservices d  WHERE      a.service_id = d.ID and a.cart_invoice_no = c.invoice_no and a.customer_id = b.ID and date(c.transaction_date) between '$startdate' and '$enddate'  and  c.bill_type='S'  GROUP BY b.Name,a.service_name";
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						$wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total'];
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['name']."</td> 
								<td class='eve'>".$row['category']."</td>
								<td class='eve'>".$row['sername']."</td> 
								<td class='eve'>".$row['cgst']."</td> 
								<td class='eve'>".$row['sgst']."</td> 
								<td class='eve'>".$row['gst']."</td> 
						</tr>";
							$i++;
					}
					echo "<tr>
							<td colspan = '6' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
					}
					else {
						echo "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
			}
		}
		
		else { 
			$msg  = "Sale Report Between Date $startdate and $enddate";
			if($type == "WIG") {
				 $msg  = "SALE REPORT - with GST Between Date $startdate and $enddate";
					echo "<tr>
						<th>#</th>
						<th>Customer Name</th>  
						<th>Category</th> 
						 <th>Date</th>  
						<th>Service Name</th> 
						<th>Total Cost</th>  
						<th>Total Disount</th>  
						<th>GST Amount</th>  
						<th>Total Amount</th>  		
					</tr>";
					$QUEY = "SELECT   a.service_name as sername, b.Name as name,sum(a.actual_price) as cost,c.transaction_date as date, sum(a.total) as total,sum(a.discount_price) as discount_price,  sum(a.cgst+a.sgst) as gst, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblcustomers b,saloon_sale_transaction c, tblservices d  WHERE     a.service_id = d.ID and a.cart_invoice_no = c.invoice_no and a.customer_id = b.ID and date(c.transaction_date) between '$startdate' and '$enddate'  and  c.bill_type='S'  GROUP BY c.transaction_date, b.Name,a.service_name";
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						$wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total'];
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['name']."</td>  
								<td class='eve'>".$row['category']."</td>
								<td class='eve'>".$row['date']."</td>
								<td class='eve'>".$row['sername']."</td> 
								<td class='eve'>".$row['cost']."</td> 
								<td class='eve'>".$row['discount_price']."</td> 
								<td class='eve'>".$row['gst']."</td> 
								<td class='eve'>".$row['total']."</td> 
						</tr>";
							$i++;
					}
					echo "<tr>
							<td colspan = '8' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
					}
					else {
						echo "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
			}
			else if($type == "WOG") {
						 $msg  = "SALE REPORT - WITH OUT GST Between Date $startdate and $enddate";
					echo "<tr>
						<th>#</th>
						<th>Customer Name</th>  
						<th>Category</th> 	
						<th>Date</th>						
						<th>Service Name</th>  
						<th>Total Cost</th>  
						<th>Total Disount</th>  
						<th>Total Amount</th>  		
					</tr>";
					$QUEY = "SELECT a.service_name as sername, b.Name as name,sum(a.actual_price) as cost,c.transaction_date as date, sum(a.total) as total,sum(a.discount_price) as discount_price,  sum(a.cgst+a.sgst) as gst, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblcustomers b,saloon_sale_transaction c , tblservices d  WHERE      a.service_id = d.ID and a.cart_invoice_no = c.invoice_no and a.customer_id = b.ID and date(c.transaction_date) between '$startdate' and '$enddate'  and  c.bill_type='S'  GROUP BY c.transaction_date, b.Name,a.service_name";
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						$wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total'];
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['name']."</td>
								<td class='eve'>".$row['category']."</td>
								 <td class='eve'>".$row['date']."</td> 
								<td class='eve'>".$row['sername']."</td> 
								<td class='eve'>".$row['cost']."</td> 
								<td class='eve'>".$row['discount_price']."</td> 
								<td class='eve'>".$row['total']."</td> 
						</tr>";
							$i++;
					}
					echo "<tr>
							<td colspan = '7' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
					}
					else {
						echo "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
			}
			else if($type == "GSA") {
						 $msg  = "SALE REPORT - WITH OUT GST Between Date $startdate and $enddate";
					echo "<tr>
						<th>#</th>
						<th>Customer Name</th>  
						<th>Category</th> 
						<th>Date</th>  
						<th>Service Name</th>  
						<th>CGST</th>  
						<th>SGST</th>  
						<th>Total GST</th>  		
					</tr>";
				$QUEY = "SELECT a.service_name as sername, b.Name as name,sum(a.cgst) as cgst,sum(a.sgst) as sgst,c.transaction_date as date, sum(a.discount_price) as discount_price,  sum(a.cgst+a.sgst) as gst, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblcustomers b,saloon_sale_transaction c, tblservices d  WHERE    a.service_id = d.ID and a.cart_invoice_no = c.invoice_no and a.customer_id = b.ID and date(c.transaction_date) between '$startdate' and '$enddate'  and  c.bill_type='S'  GROUP BY c.transaction_date, b.Name,a.service_name";
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						$wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total'];
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['name']."</td>
								<td class='eve'>".$row['category']."</td>
								<td class='eve'>".$row['date']."</td> 
								<td class='eve'>".$row['sername']."</td> 
								<td class='eve'>".$row['cgst']."</td> 
								<td class='eve'>".$row['sgst']."</td> 
								<td class='eve'>".$row['gst']."</td> 
						</tr>";
							$i++;
					}
					echo "<tr>
							<td colspan = '7' style='text-align:right'>Total GST</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
					}
					else {
						echo "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
			}
		}
	echo "</tbody> </table> <p style='text-align:left;color:red;font-size:14px'>Count: $co</p>";
	}
 }
 
 ?>