<?php
error_reporting(0);
include('../includes/dbconnection.php');
$action = $_POST['action'];
 if($action == "query") {	
 $cate = $_POST['cate'];
 $customer =$_POST['customer']; 
  $detail =$_POST['detail']; 
 $datewise =$_POST['datewise']; 
 $startdate =$_POST['startdate']; 
 $enddate =$_POST['enddate']; 
 $QUEY = "";
	 	echo "<table class='table table-bordered' id='table'> <thead>";
	if($cate == "CBW") {
		if($detail != "Y") {	
				if($datewise != "Y") {
				
				echo "<tr>
							<th>#</th>
							<th>Customer Name</th>  
							<th>Customer Type</th>  
							<th>Total Amount</th>  
						</tr>";
					
				echo "</thead><tbody>";
			if($customer == "ALL") {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount, a.customer_id, b.Name, IF(b.member = 'Y','Member','Non Member') as member FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id ORDER BY total_amount desc";
			}
			else {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount, a.customer_id, b.Name, IF(b.member = 'Y','Member','Non Member') as member FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id ORDER BY total_amount desc";
			}
			error_log($QUEY);
			$ret=mysqli_query($con,$QUEY );
			if($ret) {
				$co = mysqli_num_rows($ret);
				if($co > 0) {
					$i =1;
					 $wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total_amount'];
						
					echo "<tr> 
							<th scope='row'>".$i."</th> 
							<td class='eve'>".$row['Name']."</td> 
							<td class='eve'>".$row['member']."</td> 
							<td class='eve'>".number_format($row['total_amount'],2)."</td> 
					</tr>";
						$i++;
				}
				echo "<tr>
							<td colspan = '3' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
				}
				else {
					echo "<tr><th colspan='4'>No Data Found</th> </tr>";
				}
			}
				else {
					echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
					}
			}
			else {
						
				echo "<tr>
							<th>#</th>
							<th>Customer Name</th>  
							<th>Customer Type</th>  
							<th>Date</th>  
							<th>Total Amount</th>  
						</tr>";
					
				echo "</thead><tbody>";
			if($customer == "ALL") {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount, a.transaction_date, a.customer_id, b.Name, IF(b.member = 'Y','Member','Non Member') as member FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id,a.transaction_date ORDER BY a.transaction_date desc";
			}
			else {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount,  a.transaction_date,a.customer_id, b.Name, IF(b.member = 'Y','Member','Non Member') as member FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id,a.transaction_date ORDER BY a.transaction_date desc";
			}
			error_log($QUEY);
			$ret=mysqli_query($con,$QUEY );
			if($ret) {
				$co = mysqli_num_rows($ret);
				if($co > 0) {
					$i =1;
					 $wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total_amount'];
						
					echo "<tr> 
							<th scope='row'>".$i."</th> 
							<td class='eve'>".$row['Name']."</td> 
							<td class='eve'>".$row['member']."</td> 
							<td class='eve'>".$row['transaction_date']."</td> 
							<td class='eve'>".number_format($row['total_amount'],2)."</td> 
					</tr>";
						$i++;
				}
				echo "<tr>
							<td colspan = '4' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
				}
				else {
					echo "<tr><th colspan='4'>No Data Found</th> </tr>";
				}
			}
				else {
					echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
					}
			}
		}
		else {
			if($datewise != "Y") {
				
				echo "<tr>
							<th>#</th>
							<th>Customer Name</th>
							<th>Customer Type</th>  
							<th>Category</th>
							<th>Service Name</th>  
							<th>Total Amount</th>  
						</tr>";
					
				echo "</thead><tbody>";
			if($customer == "ALL") {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount,c.service_name, a.customer_id, b.Name,  IF(b.member = 'Y','Member','Non Member') as member, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and  c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id, c.service_name ORDER BY total_amount desc";
			}
			else {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount, c.service_name, a.customer_id, b.Name, IF(b.member = 'Y','Member','Non Member') as member , IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and   c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id,c.service_name ORDER BY total_amount desc";
			}
			error_log($QUEY);
			$ret=mysqli_query($con,$QUEY );
			if($ret) {
				$co = mysqli_num_rows($ret);
				if($co > 0) {
					$i =1;
					 $wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total_amount'];
						
					echo "<tr> 
							<th scope='row'>".$i."</th> 
							<td class='eve'>".$row['Name']."</td>
							<td class='eve'>".$row['member']."</td> 
							<td class='eve'>".$row['category']."</td> 
							<td class='eve'>".$row['service_name']."</td> 
							<td class='eve'>".number_format($row['total_amount'],2)."</td> 
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
			else {
						
			echo "<tr>
							<th>#</th>
							<th>Customer Name</th>
							<th>Customer Type</th>  
							<th>Category</th>
							<th>Service Name</th>  
							<th>Date</th>  
							<th>Total Amount</th>  
						</tr>";
					
				echo "</thead><tbody>";
			if($customer == "ALL") {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount,c.service_name, a.customer_id, b.Name , IF(b.member = 'Y','Member','Non Member') as member, a.transaction_date, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and    c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id, c.service_name,a.transaction_date ORDER BY total_amount,a.transaction_date desc";
			}
			else {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount, c.service_name, a.customer_id, b.Name , IF(b.member = 'Y','Member','Non Member') as member, a.transaction_date,IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and    c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id,c.service_name,a.transaction_date ORDER BY total_amount,a.transaction_date desc";
			}
			error_log($QUEY);
			$ret=mysqli_query($con,$QUEY );
			if($ret) {
				$co = mysqli_num_rows($ret);
				if($co > 0) {
					$i =1;
					 $wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total_amount'];
						
					echo "<tr> 
							<th scope='row'>".$i."</th> 
							<td class='eve'>".$row['Name']."</td>
							<td class='eve'>".$row['member']."</td> 
							<td class='eve'>".$row['category']."</td> 
							<td class='eve'>".$row['service_name']."</td> 
							<td class='eve'>".$row['transaction_date']."</td> 
							<td class='eve'>".number_format($row['total_amount'],2)."</td> 
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
}
	if($cate == "CNO") {
		if($detail != "Y") {	
				if($datewise != "Y") {
					echo "<tr>
								<th>#</th>
								<th>Customer Name</th>  
								<th>Customer Type</th>  
								<th>No Of Visists</th>  
							</tr>";
						
					echo "</thead><tbody>";
				if($customer == "ALL") {
					$QUEY = "SELECT count(a.invoice_no) as count , a.customer_id, b.Name, IF(b.member = 'Y','Member','Non Member') as member FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id ORDER BY total_amount desc";
				}
				else {
					$QUEY = "SELECT count(a.invoice_no) as count, a.customer_id, b.Name, IF(b.member = 'Y','Member','Non Member') as member FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id ORDER BY total_amount desc";
				}
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						while ($row=mysqli_fetch_array($ret)) {
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['Name']."</td> 
								<td class='eve'>".$row['member']."</td> 
								<td class='eve'>".($row['count'])."</td> 
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
			else {
					echo "<tr>
								<th>#</th>
								<th>Customer Name</th>  
								<th>Customer Type</th> 
								<th>Date</th>  
								<th>No Of Visists</th>  
							</tr>";
						
					echo "</thead><tbody>";
				if($customer == "ALL") {
					$QUEY = "SELECT count(a.invoice_no) as count , a.customer_id, b.Name, a.transaction_date, IF(b.member = 'Y','Member','Non Member') as member FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id,a.transaction_date ORDER BY a.transaction_date desc";
				}
				else {
					$QUEY = "SELECT count(a.invoice_no) as count, a.customer_id, b.Name, a.transaction_date, IF(b.member = 'Y','Member','Non Member') as member FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id,a.transaction_date ORDER BY a.transaction_date desc";
				}
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						while ($row=mysqli_fetch_array($ret)) {
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['Name']."</td> 
								<td class='eve'>".$row['member']."</td> 
								<td class='eve'>".$row['transaction_date']."</td> 
								<td class='eve'>".($row['count'])."</td> 
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
		}
		else {
			if($datewise != "Y") {
					echo "<tr>
								<th>#</th>
								<th>Customer Name</th>
								<th>Customer Type</th> 
								<th>Category</th>
								<th>Service Name</th>
								<th>No Of Visists</th>  
							</tr>";
						
					echo "</thead><tbody>";
				if($customer == "ALL") {
					$QUEY = "SELECT count(a.invoice_no) as count , a.customer_id,  IF(b.member = 'Y','Member','Non Member') as member, b.Name,c.service_name,IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and    c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id,c.service_name ORDER BY c.service_name desc";
				}
				else {
					$QUEY = "SELECT count(a.invoice_no) as count, a.customer_id , IF(b.member = 'Y','Member','Non Member') as member, b.Name,c.service_name,IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and    c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id,c.service_name ORDER BY c.service_name desc";
				}
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						while ($row=mysqli_fetch_array($ret)) {
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['Name']."</td> 
								<td class='eve'>".$row['member']."</td> 
								<td class='eve'>".$row['category']."</td> 
								<td class='eve'>".$row['service_name']."</td> 
								<td class='eve'>".($row['count'])."</td> 
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
			else {
					echo "<tr>
								<th>#</th>
								<th>Customer Name</th>
								<th>Customer Type</th> 
								<th>Category</th>
								<th>Service Name</th>
								<th>Date</th>  
								<th>No Of Visists</th>  
							</tr>";
						
					echo "</thead><tbody>";
				if($customer == "ALL") {
					$QUEY = "SELECT count(a.invoice_no) as count , a.customer_id, b.Name , IF(b.member = 'Y','Member','Non Member') as member, a.transaction_date,c.service_name,IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b , saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and   c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id,a.transaction_date,c.service_name ORDER BY a.transaction_date desc";
				}
				else {
					$QUEY = "SELECT count(a.invoice_no) as count, a.customer_id, b.Name , IF(b.member = 'Y','Member','Non Member') as member, a.transaction_date,c.service_name,IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b , saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id,a.transaction_date,c.service_name ORDER BY a.transaction_date desc";
				}
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						while ($row=mysqli_fetch_array($ret)) {
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['Name']."</td>
								<td class='eve'>".$row['member']."</td>
								<td class='eve'>".$row['category']."</td> 								
								<td class='eve'>".$row['service_name']."</td> 
								<td class='eve'>".$row['transaction_date']."</td> 
								<td class='eve'>".($row['count'])."</td> 
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
		}}
}
echo "</tbody> </table> ";
 }
 ?>