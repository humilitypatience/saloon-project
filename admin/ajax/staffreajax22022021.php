<?php
error_reporting(0);
include('../includes/dbconnection.php');
$action = $_POST['action'];
 if($action == "query") {	
 $service = $_POST['service'];
 $staff =$_POST['staff']; 
 $datewise =$_POST['datewise']; 
 $startdate =$_POST['startdate']; 
 $enddate =$_POST['enddate']; 
 $QUEY = "";
 if($datewise != "Y") {	
	if($staff == "ALL") {				
		if($service == "ALL") {
			$QUEY = "SELECT  c.employee_id,b.Name, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c,tblservices d WHERE  c.service_id=d.ID and date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id GROUP BY b.ID";
		}
		else {
			$QUEY = "SELECT c.employee_id,b.Name, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c,tblservices d WHERE  c.service_id=d.ID and date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id and c.service_id = $service GROUP BY b.ID";
		}
			error_log($QUEY);
			$ret=mysqli_query($con,$QUEY );
			if($ret) {
				$co = mysqli_num_rows($ret);
				if($co > 0) {
					$i =1;
					$name = "";
					while ($row=mysqli_fetch_array($ret)) {	
					echo "<b><p style='color:red;font-size:14px;font-family:bold;text-align:left;margin-bottom:1%'>".$row['Name']." : </p></b>";
						echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody>";
						if($service == "ALL") {
							$query = "SELECT a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a,  saloon_employee b,tblservices d WHERE  a.service_id=d.ID and a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name";
						}
						else {
							$query = "SELECT a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a,  saloon_employee b,tblservices d WHERE  a.service_id=d.ID and a.service_id = $service and a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name";
						}
						error_log($query);
						$result=mysqli_query($con,$query );
						if($result) {
							$co2 = mysqli_num_rows($result);
							if($co2 <= 0) {
									echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><th colspan='4'>No Data Found</th> </tr></tbody></table>";
							}
							else {
							$i =1;
							$wholeto =  0;
								while ($row2=mysqli_fetch_array($result)) {							
								$wholeto += $row2['total_amount'];
								echo "
									<tr> 
									<td style='text-align:center;width:25%' >".$i."</td> 	
									<td style='text-align:center;width:25%' class='eve'>".$row2['service_name']."</td>
										<td style='text-align:center;width:25%' class='eve'>".$row2['category']."</td>
									<td style='text-align:center;width:25%' class='eve'>".$row2['count']."</td> 
									<td style='text-align:center;width:25%' class='eve'>".number_format($row2['total_amount'],2)."</td> 
							</tr>
							
							";
								$i++;
							}
						}
						
						echo "<tr>
							<td colspan = '4' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
						}
						else {
							echo "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr>";
						}
					}
					
				}
				else {
					echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><th colspan='4'>No Data Found</th> </tr></tbody></table>";
				}
			}
				else {
					echo "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr>";
					}
			
echo "</tbody> </table> ";
 }
 else {
			if($service == "ALL") {
			$QUEY = "SELECT  c.employee_id,b.Name, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c,tblservices d WHERE  c.service_id=d.ID and date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id and c.employee_id = $staff GROUP BY b.ID";
		}
		else {
			$QUEY = "SELECT c.employee_id,b.Name, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c,tblservices d WHERE  c.service_id=d.ID and date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id and c.service_id = $service and c.employee_id = $staff  GROUP BY b.ID";
		}
			error_log($QUEY);
			$ret=mysqli_query($con,$QUEY );
			if($ret) {
				$co = mysqli_num_rows($ret);
				if($co > 0) {
					$i =1;
					$name = "";
					while ($row=mysqli_fetch_array($ret)) {	
					echo "<b><p style='color:red;font-size:14px;font-family:bold;text-align:left;margin-bottom:1%'>".$row['Name']." : </p></b>";
						echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody>";
						if($service == "ALL") {
							$query = "SELECT a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a,  saloon_employee b, saloon_sale_transaction c,tblservices d WHERE  a.service_id=d.ID and date(c.transaction_date) between '$startdate' and '$enddate' and a.cart_invoice_no = c.invoice_no and a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name,transaction_date";
						}
						else {
							$query = "SELECT a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a,  saloon_employee b, saloon_sale_transaction c,tblservices d WHERE  a.service_id=d.ID and date(c.transaction_date) between '$startdate' and '$enddate' and a.cart_invoice_no = c.invoice_no and a.service_id = $service and a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name,transaction_date";
						}
						error_log($query);
						$result=mysqli_query($con,$query );
						if($result) {
							$co2 = mysqli_num_rows($result);
							if($co2 <= 0) {
									echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><th colspan='4'>No Data Found</th> </tr></tbody></table>";
							}
							else {
							$i =1;
							$wholeto =  0;
								while ($row2=mysqli_fetch_array($result)) {							
								$wholeto += $row2['total_amount'];
								echo "
									<tr> 
									<td style='text-align:center;width:25%' >".$i."</td> 	
									<td style='text-align:center;width:25%' class='eve'>".$row2['service_name']."</td>
										<td style='text-align:center;width:25%' class='eve'>".$row2['category']."</td>
									<td style='text-align:center;width:25%' class='eve'>".$row2['count']."</td> 
									<td style='text-align:center;width:25%' class='eve'>".number_format($row2['total_amount'],2)."</td> 
							</tr>
							
							";
								$i++;
							}
						}
						
						echo "<tr>
							<td colspan = '4' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
						}
						else {
							echo "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr>";
						}
					}
					
				}
				else {
					echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><th colspan='4'>No Data Found</th> </tr></tbody></table>";
				}
			}
				else {
					echo "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr>";
					}
			
echo "</tbody> </table> ";
 }
 }
 
 
 else {
	 	if($staff == "ALL") {				
		if($service == "ALL") {
			$QUEY = "SELECT  c.employee_id,b.Name, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c,tblservices d WHERE  c.service_id=d.ID and date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id GROUP BY b.ID";
		}
		else {
			$QUEY = "SELECT c.employee_id,b.Name, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c,tblservices d WHERE  c.service_id=d.ID and date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id and c.service_id = $service GROUP BY b.ID";
		}
			error_log($QUEY);
			$ret=mysqli_query($con,$QUEY );
			if($ret) {
				$co = mysqli_num_rows($ret);
				if($co > 0) {
					$i =1;
					$name = "";
					while ($row=mysqli_fetch_array($ret)) {	
					echo "<b><p style='color:red;font-size:14px;font-family:bold;text-align:left;margin-bottom:1%'>".$row['Name']." : </p></b>";
						echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Date</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody>";
						if($service == "ALL") {
							$query = "SELECT c.transaction_date, a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a,  saloon_employee b,saloon_sale_transaction c,tblservices d WHERE  a.service_id=d.ID and date(c.transaction_date) between '$startdate' and '$enddate' and  a.cart_invoice_no = c.invoice_no and a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name,transaction_date";
						}
						else {
							$query = "SELECT c.transaction_date, a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category  FROM saloon_sale_service_cart a,  saloon_employee b,saloon_sale_transaction c,tblservices d WHERE  a.service_id=d.ID and date(c.transaction_date) between '$startdate' and '$enddate' and  a.cart_invoice_no = c.invoice_no and a.service_id = $service and a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name,transaction_date";
						}
						error_log($query);
						$result=mysqli_query($con,$query );
						if($result) {
							$co2 = mysqli_num_rows($result);
							if($co2 <= 0) {
									echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Date</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><th colspan='5'>No Data Found</th> </tr></tbody></table>";
							}
							else {
							$i =1;
							$wholeto =  0;
								while ($row2=mysqli_fetch_array($result)) {							
								$wholeto += $row2['total_amount'];
								echo "
									<tr> 
									<td style='text-align:center;width:25%' >".$i."</td> 	
									<td style='text-align:center;width:25%' class='eve'>".$row2['service_name']."</td>
										<td style='text-align:center;width:25%' class='eve'>".$row2['category']."</td>
									<td style='text-align:center;width:25%' class='eve'>".$row2['transaction_date']."</td> 
									<td style='text-align:center;width:25%' class='eve'>".$row2['count']."</td> 
									<td style='text-align:center;width:25%' class='eve'>".number_format($row2['total_amount'],2)."</td> 
							</tr>
							
							";
								$i++;
							}
						}
						
						echo "<tr>
							<td colspan = '5' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
						}
						else {
							echo "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr>";
						}
					}
					
				}
				else {
					echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Date</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><th colspan='4'>No Data Found</th> </tr></tbody></table>";
				}
			}
				else {
					echo "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr>";
					}
			
echo "</tbody> </table> ";
 }
 else {
			if($service == "ALL") {
			$QUEY = "SELECT  c.employee_id,b.Name, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c,tblservices d WHERE  c.service_id=d.ID and date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id and c.employee_id = $staff GROUP BY b.ID";
		}
		else {
			$QUEY = "SELECT c.employee_id,b.Name, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c,tblservices d WHERE  c.service_id=d.ID and date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id and c.service_id = $service and c.employee_id = $staff  GROUP BY b.ID";
		}
			error_log($QUEY);
			$ret=mysqli_query($con,$QUEY );
			if($ret) {
				$co = mysqli_num_rows($ret);
				if($co > 0) {
					$i =1;
					$name = "";
					while ($row=mysqli_fetch_array($ret)) {	
					echo "<b><p style='color:red;font-size:14px;font-family:bold;text-align:left;margin-bottom:1%'>".$row['Name']." : </p></b>";
						echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Date</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody>";
						if($service == "ALL") {
							$query = "SELECT a.service_name,b.Name,sum(a.total) as total_amount, count(cart_id) as count,c.transaction_date, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a,  saloon_employee b , saloon_sale_transaction c,tblservices d WHERE  a.service_id=d.ID and  date(c.transaction_date) between '$startdate' and '$enddate' and a.employee_id = b.ID and c.invoice_no = a.cart_invoice_no and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name, transaction_date";
						}
						else {
							$query = "SELECT a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count,c.transaction_date, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a,  saloon_employee b , saloon_sale_transaction c,tblservices d WHERE  a.service_id=d.ID and  date(c.transaction_date) between '$startdate' and '$enddate' and a.service_id = $service and a.employee_id = b.ID and c.invoice_no = a.cart_invoice_no and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name, transaction_date";
						}
						error_log($query);
						$result=mysqli_query($con,$query );
						if($result) {
							$co2 = mysqli_num_rows($result);
							if($co2 <= 0) {
									echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
											<th style='text-align:center;width:25%'>Date</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><th colspan='4'>No Data Found</th> </tr></tbody></table>";
							}
							else {
							$i =1;
							$wholeto =  0;
								while ($row2=mysqli_fetch_array($result)) {							
								$wholeto += $row2['total_amount'];
								echo "
									<tr> 
									<td style='text-align:center;width:25%' >".$i."</td> 	
									<td style='text-align:center;width:25%' class='eve'>".$row2['service_name']."</td>
									<td style='text-align:center;width:25%' class='eve'>".$row2['category']."</td>
									<td style='text-align:center;width:25%' class='eve'>".$row2['transaction_date']."</td> 
									<td style='text-align:center;width:25%' class='eve'>".$row2['count']."</td> 
									<td style='text-align:center;width:25%' class='eve'>".number_format($row2['total_amount'],2)."</td> 
							</tr>";
								$i++;
							}
						}
						
						echo "<tr>
							<td colspan = '5' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
						}
						else {
							echo "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr>";
						}
					}
					
				}
				else {
					echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><th colspan='4'>No Data Found</th> </tr></tbody></table>";
				}
			}
				else {
					echo "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr>";
					}
			
echo "</tbody> </table> ";
 }
 }
 }
 ?>