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
			$QUEY = "SELECT  c.employee_id,b.Name FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id GROUP BY b.ID";
		}
		else {
			$QUEY = "SELECT c.employee_id,b.Name FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id GROUP BY b.ID";
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
										<th style='text-align:center;width:15%'>Count</th>
										<th style='text-align:center;width:15%'>Total Amount</th>
										<th style='text-align:center;width:20%'>Incentive Amount</th>
									</tr></thead><tbody>";
						if($service == "ALL") {
							$query = "SELECT a.service_id, a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count FROM saloon_sale_service_cart a,  saloon_employee b  , saloon_sale_transaction c WHERE date(c.transaction_date) between '$startdate' and '$enddate' and c.invoice_no = a.cart_invoice_no  and   a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name,a.service_id";
						}
						else {
							$query = "SELECT a.service_id,a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count FROM saloon_sale_service_cart a,  saloon_employee b , saloon_sale_transaction c WHERE date(c.transaction_date) between '$startdate' and '$enddate' and c.invoice_no = a.cart_invoice_no  and   a.service_id = $service and a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name,a.service_id";
						}
						error_log($query);
						$result=mysqli_query($con,$query );
						if($result) {
							$co2 = mysqli_num_rows($result);
							if($co2 <= 0) {
								
									echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><th colspan='5'>No Data Found</th> </tr></tbody></table>";
							}
							else {
							$i =1;
							$wholeto =  0;
								while ($row2=mysqli_fetch_array($result)) {
									$incentive_map_query = "SELECT amount_factor , IFNULL(rate,0.00) as rate FROM incentive_mapping WHERE service_id = ".$row2['service_id'];
									error_log($incentive_map_query);
									$incentive_map_result=mysqli_query($con,$incentive_map_query );
									if($incentive_map_result) {
										$incentive_map_row = mysqli_fetch_assoc($incentive_map_result);
										
										$wholeto += $row2['total_amount'];
										$amount_factor = $incentive_map_row['amount_factor'];
										$incentive_amount = 0;
										if($amount_factor == "A") {
											$incentive_amount = $row2['count'] * $incentive_map_row['rate'];
										}
										if($amount_factor == "P") {
											$incentive_amount = $row2['count'] *( $incentive_map_row['rate']/100);
										}								
										$wholeinc += $incentive_amount;
										error_log($amount_factor);
										error_log($incentive_amount);
										echo "
											<tr> 
											<td style='text-align:center;width:25%' >".$i."</td> 	
											<td style='text-align:center;width:25%' class='eve'>".$row2['service_name']."</td> 
											<td style='text-align:center;width:15%' class='eve'>".$row2['count']."</td> 
											<td style='text-align:center;width:15%' class='eve'>".number_format($row2['total_amount'],2)."</td> 
											<td style='text-align:center;width:20%' class='eve'>".number_format($incentive_amount,2)."</td> 
									</tr>
									
									";
										$i++;
								}
								else {
									echo "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr>";
								}
							}
						}
						
						echo "<tr>
						<td colspan = '3' style='text-align:right'>Total </td>
							<td colspan = '1'style='text-align:center;color:blue;font-size:20px;font-family:bold;'>  <b>".number_format($wholeto,2)."</b></td>
							<td colspan = '1' style='text-align:center;color:red;font-size:20px;font-family:bold;'><b>".number_format($wholeinc,2)."</b></td>
						</tr></tbody></table>";
						$wholeto =  0;
						$wholeinc = 0;
						$incentive_amount = 0;
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
			$QUEY = "SELECT  c.employee_id,b.Name FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id and c.employee_id = $staff GROUP BY b.ID";
		}
		else {
			$QUEY = "SELECT c.employee_id,b.Name FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id and c.service_id = $service and c.employee_id = $staff  GROUP BY b.ID";
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
										<th style='text-align:center;width:15%'>Count</th>
										<th style='text-align:center;width:15%'>Total Amount</th>
										<th style='text-align:center;width:20%'>Incentive Amount</th>
									</tr></thead><tbody>";
						if($service == "ALL") {
							$query = "SELECT a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count, (SELECT amount_factor FROM  incentive_mapping WHERE service_id = a.service_id) as amount_factor, IFNULL((SELECT rate FROM  incentive_mapping WHERE service_id = a.service_id),0.00) as rate FROM saloon_sale_service_cart a,  saloon_employee b  , saloon_sale_transaction c WHERE date(c.transaction_date) between '$startdate' and '$enddate' and c.invoice_no = a.cart_invoice_no  and   a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name";
						}
						else {
							$query = "SELECT a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count, (SELECT amount_factor FROM  incentive_mapping WHERE service_id = a.service_id) as amount_factor, IFNULL((SELECT rate FROM  incentive_mapping WHERE service_id = a.service_id),0.00) as rate FROM saloon_sale_service_cart a,  saloon_employee b , saloon_sale_transaction c WHERE date(c.transaction_date) between '$startdate' and '$enddate' and c.invoice_no = a.cart_invoice_no  and   a.service_id = $service and a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name";
						}
						error_log($query);
						$result=mysqli_query($con,$query );
						if($result) {
							$co2 = mysqli_num_rows($result);
							if($co2 <= 0) {
									echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><th colspan='4'>No Data Found</th> </tr></tbody></table>";
							}
							else {
							$i =1;
							$wholeto =  0;
								while ($row2=mysqli_fetch_array($result)) {							
							
								$wholeto += $row2['total_amount'];
								$amount_factor = $row2['amount_factor'];
								$incentive_amount = 0;
								if($amount_factor == "A") {
									$incentive_amount = $row2['count'] * $row2['rate'];
								}
								if($amount_factor == "P") {
									$incentive_amount = $row2['count'] *( $row2['rate']/100);
								}								
								$wholeinc += $incentive_amount;
								echo "
									<tr> 
									<td style='text-align:center;width:25%' >".$i."</td> 	
									<td style='text-align:center;width:25%' class='eve'>".$row2['service_name']."</td> 
									<td style='text-align:center;width:25%' class='eve'>".$row2['count']."</td> 
									<td style='text-align:center;width:25%' class='eve'>".number_format($row2['total_amount'],2)."</td> 
									<td style='text-align:center;width:20%' class='eve'>".number_format($incentive_amount,2)."</td> 
							</tr>
							
							";
								$i++;
							}
						}
						
						echo "<tr>
							<td colspan = '3' style='text-align:right'>Total </td>
							<td colspan = '1'style='text-align:center;color:blue;font-size:20px;font-family:bold;'>  <b>".number_format($wholeto,2)."</b></td>
							<td colspan = '1' style='text-align:center;color:red;font-size:20px;font-family:bold;'><b>".number_format($wholeinc,2)."</b></td>
						</tr></tbody></table>";
						$wholeto =  0;
						$wholeinc = 0;
						$incentive_amount = 0;
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
			$QUEY = "SELECT  c.employee_id,b.Name FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id GROUP BY b.ID";
		}
		else {
			$QUEY = "SELECT c.employee_id,b.Name FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id and c.service_id = $service GROUP BY b.ID";
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
										<th style='text-align:center;width:15%'>Service</th>
										<th style='text-align:center;width:15%'>Date</th>
										<th style='text-align:center;width:10%'>Count</th>
										<th style='text-align:center;width:15%'>Total Amount</th>
										<th style='text-align:center;width:20%'>Incentive Amount</th>
									</tr></thead><tbody>";
						if($service == "ALL") {
							$query = "SELECT c.transaction_date, a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count, (SELECT amount_factor FROM  incentive_mapping WHERE service_id = a.service_id) as amount_factor, IFNULL((SELECT rate FROM  incentive_mapping WHERE service_id = a.service_id),0.00) as rate FROM saloon_sale_service_cart a,  saloon_employee b,saloon_sale_transaction c WHERE date(c.transaction_date) between '$startdate' and '$enddate' and  a.cart_invoice_no = c.invoice_no and a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name,transaction_date"
;
						}
						else {
							$query = "SELECT c.transaction_date, a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count, (SELECT amount_factor FROM  incentive_mapping WHERE service_id = a.service_id) as amount_factor, IFNULL((SELECT rate FROM  incentive_mapping WHERE service_id = a.service_id),0.00) as rate FROM saloon_sale_service_cart a,  saloon_employee b,saloon_sale_transaction c WHERE date(c.transaction_date) between '$startdate' and '$enddate' and  a.cart_invoice_no = c.invoice_no and a.service_id = $service and a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name,transaction_date";
						}
						error_log($query);
						$result=mysqli_query($con,$query );
						if($result) {
							$co2 = mysqli_num_rows($result);
							if($co2 <= 0) {
									echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:15%'>Service</th>
										<th style='text-align:center;width:15%'>Date</th>
										<th style='text-align:center;width:10%'>Count</th>
										<th style='text-align:center;width:15%'>Total Amount</th>
										<th style='text-align:center;width:20%'>Incentive Amount</th>
									</tr></thead><tbody><tr><th colspan='5'>No Data Found</th> </tr></tbody></table>";
							}
							else {
							$i =1;
							$wholeto =  0;
								while ($row2=mysqli_fetch_array($result)) {							
								$wholeto += $row2['total_amount'];
								$wholeto += $row2['total_amount'];
								$amount_factor = $row2['amount_factor'];
								$incentive_amount = 0;
								if($amount_factor == "A") {
									$incentive_amount = $row2['count'] * $row2['rate'];
								}
								if($amount_factor == "P") {
									$incentive_amount = $row2['count'] *( $row2['rate']/100);
								}								
								$wholeinc += $incentive_amount;
								echo "
									<tr> 
									<td style='text-align:center;width:10%' >".$i."</td> 	
									<td style='text-align:center;width:15%' class='eve'>".$row2['service_name']."</td> 
									<td style='text-align:center;width:15%' class='eve'>".$row2['transaction_date']."</td> 
									<td style='text-align:center;width:10%' class='eve'>".$row2['count']."</td> 
									<td style='text-align:center;width:20%' class='eve'>".number_format($row2['total_amount'],2)."</td> 
										<td style='text-align:center;width:20%' class='eve'>".number_format($incentive_amount,2)."</td> 
							</tr>
							
							";
								$i++;
							}
						}
						
						echo "<tr>
							<td colspan = '4' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						<td colspan = '1' style='text-align:center;color:red;font-size:20px;font-family:bold;'><b>".number_format($wholeinc,2)."</b></td>
						</tr></tbody></table>";
						$wholeto =  0;
						$wholeinc = 0;
						$incentive_amount = 0;
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
			$QUEY = "SELECT  c.employee_id,b.Name FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id and c.employee_id = $staff GROUP BY b.ID";
		}
		else {
			$QUEY = "SELECT c.employee_id,b.Name FROM saloon_sale_transaction a, saloon_employee b, saloon_sale_service_cart c WHERE date(a.transaction_date) between '$startdate' and '$enddate' and a.invoice_no = c.cart_invoice_no and b.ID = c.employee_id and c.service_id = $service and c.employee_id = $staff  GROUP BY b.ID";
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
										<th style='text-align:center;width:15%'>Service</th>
										<th style='text-align:center;width:15%'>Date</th>
										<th style='text-align:center;width:10%'>Count</th>
										<th style='text-align:center;width:15%'>Total Amount</th>
										<th style='text-align:center;width:20%'>Incentive Amount</th>
									</tr></thead><tbody>";
						if($service == "ALL") {
							$query = "SELECT c.transaction_date, a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count, (SELECT amount_factor FROM  incentive_mapping WHERE service_id = a.service_id) as amount_factor, IFNULL((SELECT rate FROM  incentive_mapping WHERE service_id = a.service_id),0.00) as rate FROM saloon_sale_service_cart a,  saloon_employee b,saloon_sale_transaction c WHERE date(c.transaction_date) between '$startdate' and '$enddate' and  a.cart_invoice_no = c.invoice_no and a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name,transaction_date"
;
						}
						else {
							$query = "SELECT c.transaction_date, a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count, (SELECT amount_factor FROM  incentive_mapping WHERE service_id = a.service_id) as amount_factor, IFNULL((SELECT rate FROM  incentive_mapping WHERE service_id = a.service_id),0.00) as rate FROM saloon_sale_service_cart a,  saloon_employee b,saloon_sale_transaction c WHERE date(c.transaction_date) between '$startdate' and '$enddate' and  a.cart_invoice_no = c.invoice_no and a.service_id = $service and a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name,transaction_date";
						}
						error_log($query);
						$result=mysqli_query($con,$query );
						if($result) {
							$co2 = mysqli_num_rows($result);
							if($co2 <= 0) {
									echo "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:15%'>Service</th>
										<th style='text-align:center;width:15%'>Date</th>
										<th style='text-align:center;width:10%'>Count</th>
										<th style='text-align:center;width:15%'>Total Amount</th>
										<th style='text-align:center;width:20%'>Incentive Amount</th>
									</tr></thead><tbody><tr><th colspan='5'>No Data Found</th> </tr></tbody></table>";
							}
							else {
							$i =1;
							$wholeto =  0;
								while ($row2=mysqli_fetch_array($result)) {							
								$wholeto += $row2['total_amount'];
								$wholeto += $row2['total_amount'];
								$amount_factor = $row2['amount_factor'];
								$incentive_amount = 0;
								if($amount_factor == "A") {
									$incentive_amount = $row2['count'] * $row2['rate'];
								}
								if($amount_factor == "P") {
									$incentive_amount = $row2['count'] *( $row2['rate']/100);
								}								
								$wholeinc += $incentive_amount;
								echo "
									<tr> 
									<td style='text-align:center;width:10%' >".$i."</td> 	
									<td style='text-align:center;width:15%' class='eve'>".$row2['service_name']."</td> 
									<td style='text-align:center;width:15%' class='eve'>".$row2['transaction_date']."</td> 
									<td style='text-align:center;width:10%' class='eve'>".$row2['count']."</td> 
									<td style='text-align:center;width:20%' class='eve'>".number_format($row2['total_amount'],2)."</td> 
										<td style='text-align:center;width:20%' class='eve'>".number_format($incentive_amount,2)."</td> 
							</tr>
							
							";
								$i++;
							}
						}
						
						echo "<tr>
							<td colspan = '4' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						<td colspan = '1' style='text-align:center;color:red;font-size:20px;font-family:bold;'><b>".number_format($wholeinc,2)."</b></td>
						</tr></tbody></table>";
						$wholeto =  0;
						$wholeinc = 0;
						$incentive_amount = 0;
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