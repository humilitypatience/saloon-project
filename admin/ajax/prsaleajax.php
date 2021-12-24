<?php
error_reporting(0);
include('../includes/dbconnection.php');
$action = $_POST['action'];
 if($action == "query") {	
 //$cate = $_POST['cate'];
 $customer =$_POST['customer']; 
 $startdate =$_POST['startdate']; 
 $enddate =$_POST['enddate']; 
 $detail =$_POST['detail']; 
 $datewise =$_POST['datewise']; 
 $QUEY = "";
 $cate = "BP";
echo "<table class='table table-bordered' id='table'> <thead>";

	if($detail != "Y") {	
		if($cate == "BC") {
			echo "<tr>
					<th>#</th>
					<th>Customer Name</th>  
					<th>Sale Count</th>  
				</tr>";
			if($customer == "ALL") {
				$QUEY = "SELECT count(a.customer_id) as count, a.customer_id, b.Name as name  FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate'  and a.customer_id = c.customer_id and a.invoice_no = c.cart_invoice_no and  a.customer_id= b.ID GROUP BY a.customer_id ORDER BY count desc";
			}
			else {
				$QUEY = "SELECT count(a.customer_id) as count, a.customer_id, b.Name as name  FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate'  and b.customer_id = $customer and a.customer_id = c.customer_id and a.invoice_no = c.cart_invoice_no and  a.customer_id= b.ID GROUP BY a.customer_id ORDER BY count desc";
			}
		}
		if($cate == "BP") {
			echo "<tr>
					<th>#</th>
					<th>Service Name</th>  
					<th>Sale Count</th>  
				</tr>";
			if($customer == "ALL") {
				$QUEY = "SELECT count(c.service_id) as count, a.customer_id, c.service_name as name FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate'  and a.customer_id = c.customer_id and a.invoice_no = c.cart_invoice_no and  a.customer_id= b.ID GROUP BY c.service_id ORDER BY count desc";
			}
			else {
				$QUEY = "SELECT count(c.service_id) as count, a.customer_id, c.service_name as name  FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate'  and b.customer_id = $customer and a.customer_id = c.customer_id and a.invoice_no = c.cart_invoice_no and  a.customer_id= b.ID GROUP BY c.service_id ORDER BY count desc";
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
						<th scope='row'>".$i."</th> 
						<td class='eve'>".$row['name']."</td> 
						<td class='eve'>".$row['count']."</td> 
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

		if($cate == "CNO") {
			echo "<tr>
						<th>#</th>
						<th>Customer Name</th>  
						<th>No Of Visists</th>  
					</tr>";
				
			echo "</thead><tbody>";
		if($customer == "ALL") {
			$QUEY = "SELECT count(a.invoice_no) as count , a.customer_id, b.Name FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id ORDER BY total_amount desc";
		}
		else {
			$QUEY = "SELECT count(a.invoice_no) as count, a.customer_id, b.Name FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id ORDER BY total_amount desc";
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
	echo "</tbody> </table> ";
	}
	else {
		if($cate == "BC") {
			echo "<tr>
					<th>#</th>
					<th>Customer Name</th>  
					<th>Transaction Date</th>  
					<th>Amount</th>  
					<th>Sale Count</th>  
				</tr>";
			if($customer == "ALL") {
				$QUEY = "SELECT count(a.customer_id) as count, a.customer_id, a.transaction_date, total as total_amount,  b.Name as name  FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate'  and a.customer_id = c.customer_id and a.invoice_no = c.cart_invoice_no and  a.customer_id= b.ID GROUP BY a.transaction_date, a.customer_id, a.total_amount ORDER BY a.transaction_date,count desc";
			}
			else {
				$QUEY = "SELECT count(a.customer_id) as count, a.customer_id, a.transaction_date, total as total_amount, b.Name as name  FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate'  and b.customer_id = $customer and a.customer_id = c.customer_id and a.invoice_no = c.cart_invoice_no and  a.transaction_date,a.customer_id= b.ID GROUP BY a.customer_id, a.total_amount ORDER BY a.transaction_date,count desc";
			}
		}
		if($cate == "BP") {
			echo "<tr>
					<th>#</th>
					<th>Service Name</th>  
					<th>Transaction Date</th> 
					<th>Amount</th> 
					<th>Sale Count</th>  
				</tr>";
			if($customer == "ALL") {
				$QUEY = "SELECT count(c.service_id) as count, a.customer_id, a.transaction_date,total as total_amount, c.service_name as name FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate'  and a.customer_id = c.customer_id and a.invoice_no = c.cart_invoice_no and  a.customer_id= b.ID GROUP BY c.service_id, a.transaction_date,a.total_amount ORDER BY count, a.transaction_date desc";
			}
			else {
				$QUEY = "SELECT count(c.service_id) as count, a.customer_id, a.transaction_date, total as total_amount,c.service_name as name  FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate'  and b.customer_id = $customer and a.customer_id = c.customer_id and a.invoice_no = c.cart_invoice_no and  a.customer_id= b.ID GROUP BY c.service_id, a.transaction_date,a.total_amount ORDER BY count, a.transaction_date desc";
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
						<th scope='row'>".$i."</th> 
						<td class='eve'>".$row['name']."</td> 
						<td class='eve'>".$row['transaction_date']."</td> 
						<td class='eve'>".$row['total_amount']."</td> 
						<td class='eve'>".$row['count']."</td> 
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


	echo "</tbody> </table> ";
	}
 }
 ?>