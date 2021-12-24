<?php
error_reporting(0);
include('../includes/dbconnection.php');
$action = $_POST['action'];
 if($action == "query") {	
 //$cate = $_POST['cate'];
 $service =$_POST['service']; 
 $cats =$_POST['cats']; 
 $startdate =$_POST['startdate']; 
 $enddate =$_POST['enddate']; 
 $detail =$_POST['detail']; 
 $datewise =$_POST['datewise']; 
 $QUEY = "";
 $msg = "";
echo "<table class='table table-bordered' id='table'> <thead>";

	if($detail != "Y") {	
		if($datewise != "Y") {
			 $msg  = "Service Report Between Date $startdate and $enddate";
			echo "<tr>
					<th>#</th>
					<th>Service Name</th>  
					<th>Category</th>
					<th>Sale Count</th>  
				</tr>";
				if($cats == "ALL"){
				  if($service == "ALL") {
				  
					$QUEY = "SELECT count(*) as count, a.service_name as name, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblservices b, saloon_sale_transaction c  WHERE   date(c.transaction_date) between '$startdate' and '$enddate' and a.service_id = b.ID  and c.invoice_no = a.cart_invoice_no GROUP BY a.service_id ORDER BY a.service_id";
				  }
				  else {
					$QUEY = "SELECT count(*) as count, a.service_name as name, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblservices b, saloon_sale_transaction c  WHERE   date(c.transaction_date) between '$startdate' and '$enddate' and  a.service_id = b.ID  and c.invoice_no = a.cart_invoice_no and b.ID = '$service'  GROUP BY a.service_id ORDER BY a.service_id";
				 }
				} else if ($service != "ALL")  { 
				    $QUEY = "SELECT count(*) as count, a.service_name as name, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblservices b, saloon_sale_transaction c  WHERE   date(c.transaction_date) between '$startdate' and '$enddate' and  a.service_id = b.ID  and c.invoice_no = a.cart_invoice_no and   b.ID = '$service' and b.categories_id=$cats GROUP BY a.service_id ORDER BY a.service_id";
					}
					else {
					$QUEY = "SELECT count(*) as count, a.service_name as name, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblservices b, saloon_sale_transaction c  WHERE   date(c.transaction_date) between '$startdate' and '$enddate' and  a.service_id = b.ID  and c.invoice_no = a.cart_invoice_no and b.categories_id=$cats GROUP BY a.service_id ORDER BY a.service_id";
				    }
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						 $wholeto =  0;
					    	while ($row=mysqli_fetch_array($ret)) {
							 $wholeto += $row['count'];
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['name']."</td>
									<td class='eve'>".$row['category']."</td>
								<td class='eve'>".$row['count']."</td> 
						</tr>";
							$i++;
					}
					echo "<tr>
							<td colspan = '3' style='text-align:right'>Total Sales Count</td>
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
			 $msg  = "Service Datewise Report Between Date $startdate and $enddate";
			echo "<tr>
					<th>#</th>
					<th>Service Name</th> 
					<th>Category</th>
					<th>Date</th>  
					<th>Count</th>  
				</tr>";
				if($cats == "ALL"){
				if($service == "ALL") {
					
					$QUEY = "SELECT count(*) as count, a.service_name as name,c.transaction_date, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblservices b, saloon_sale_transaction c  WHERE   date(c.transaction_date) between '$startdate' and '$enddate' and a.service_id = b.ID  and c.invoice_no = a.cart_invoice_no GROUP BY c.transaction_date,a.service_id ORDER BY c.transaction_date";
					
				}
				else {
					$QUEY = "SELECT count(*) as count, a.service_name as name,c.transaction_date, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblservices b, saloon_sale_transaction c  WHERE   date(c.transaction_date) between '$startdate' and '$enddate' and  a.service_id = b.ID  and c.invoice_no = a.cart_invoice_no and b.ID = $service GROUP BY c.transaction_date,a.service_id ORDER BY c.transaction_date";
		
				}
				}else{
						$QUEY = "SELECT count(*) as count, a.service_name as name,c.transaction_date, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblservices b, saloon_sale_transaction c  WHERE   date(c.transaction_date) between '$startdate' and '$enddate' and  a.service_id = b.ID  and c.invoice_no = a.cart_invoice_no  and b.categories_id='$cats' GROUP BY c.transaction_date,a.service_id ORDER BY c.transaction_date";
					}
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						 $wholeto =  0;
					    	while ($row=mysqli_fetch_array($ret)) {
							 $wholeto += $row['count'];
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['name']."</td> 
								<td class='eve'>".$row['category']."</td>
								<td class='eve'>".$row['transaction_date']."</td> 
								<td class='eve'>".$row['count']."</td> 
						</tr>";
							$i++;
					}
					echo "<tr>
							<td colspan = '4' style='text-align:right'>Total Sales Count</td>
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
		if($datewise != "Y") {
			 $msg  = "Service Report Between Date $startdate and $enddate";
			echo "<tr>
					<th>#</th>
					<th>Service Name</th> 
					<th>Category</th>
					<th>Customer Name</th>  
					<th>Sale Count</th>  
				</tr>";
				 if($cats == "ALL") {
				if($service == "ALL") {  
				 
					$QUEY = "SELECT count(*) as count, a.service_name as name, c.Name as cname, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblservices b, tblcustomers c , saloon_sale_transaction d  WHERE   d.invoice_no =a.cart_invoice_no and a.customer_id = c.ID and b.ID = a.service_id and date(d.transaction_date) between '$startdate' and '$enddate' GROUP BY a.service_name,cname ORDER BY a.service_id";
				  
				}
				else {
					$QUEY = "SELECT count(*) as count, a.service_name as name, c.Name as cname, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblservices b, tblcustomers c , saloon_sale_transaction d  WHERE   d.invoice_no =a.cart_invoice_no and a.customer_id = c.ID and b.ID = a.service_id and a.service_id = $service and date(d.transaction_date) between '$startdate' and '$enddate' GROUP BY a.service_name,cname ORDER BY a.service_id";
				}
				}else{
					 $QUEY = "SELECT count(*) as count, a.service_name as name, c.Name as cname, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblservices b, tblcustomers c , saloon_sale_transaction d  WHERE   d.invoice_no =a.cart_invoice_no and a.customer_id = c.ID and b.ID = a.service_id and b.categories_id='$cats' and  date(d.transaction_date) between '$startdate' and '$enddate' GROUP BY a.service_name,cname ORDER BY a.service_id";
				  }
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						 $wholeto =  0;
					    	while ($row=mysqli_fetch_array($ret)) {
							 $wholeto += $row['count'];
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['name']."</td> 
								<td class='eve'>".$row['category']."</td>
								<td class='eve'>".$row['cname']."</td>
								<td class='eve'>".$row['count']."</td> 
						</tr>";
							$i++;
					}
					echo "<tr>
							<td colspan = '4' style='text-align:right'>Total Sales Count</td>
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
			$msg  = "Service Report Between Date $startdate and $enddate";
			echo "<tr>
					<th>#</th>
					<th>Service Name</th> 
					<th>Category</th>
					<th>Customer Name</th>  
					<th>Date</th>  
					<th>Sale Count</th>  
				</tr>";
				 if($cats == "ALL") {
				if($service == "ALL") {
					
					$QUEY = "SELECT count(*) as count, a.service_name as name, c.Name as cname, d.transaction_date, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblservices b, tblcustomers c , saloon_sale_transaction d  WHERE   d.invoice_no =a.cart_invoice_no and a.customer_id = c.ID and b.ID = a.service_id and date(d.transaction_date) between '$startdate' and '$enddate' GROUP BY a.service_name,cname,d.transaction_date ORDER BY a.service_id,d.transaction_date";
					
				}
				else {
					$QUEY = "SELECT count(*) as count, a.service_name as name, c.Name as cname, d.transaction_date,IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblservices b, tblcustomers c , saloon_sale_transaction d  WHERE   d.invoice_no =a.cart_invoice_no and a.customer_id = c.ID and b.ID = a.service_id and a.service_id = $service and date(d.transaction_date) between '$startdate' and '$enddate' GROUP BY a.service_name,cname ORDER BY a.service_id,d.transaction_date";
				}
				 }else{
						 $QUEY = "SELECT count(*) as count, a.service_name as name, c.Name as cname, d.transaction_date, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblservices b, tblcustomers c , saloon_sale_transaction d  WHERE   d.invoice_no =a.cart_invoice_no and a.customer_id = c.ID and b.ID = a.service_id and b.categories_id=$cats and date(d.transaction_date) between '$startdate' and '$enddate' GROUP BY a.service_name,cname ORDER BY a.service_id,d.transaction_date";
					 }
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						 $wholeto =  0;
					    	while ($row=mysqli_fetch_array($ret)) {
							 $wholeto += $row['count'];
							
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['name']."</td> 
								<td class='eve'>".$row['category']."</td> 
								<td class='eve'>".$row['cname']."</td> 
								<td class='eve'>".$row['transaction_date']."</td> 
								<td class='eve'>".$row['count']."</td> 
						</tr>";
							$i++;
					}
					echo "<tr>
							<td colspan = '5' style='text-align:right'>Total Sales Count</td>
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
	echo "</tbody> </table> ";
	}
 }

 ?>