<?php
error_reporting(0);
include('../includes/dbconnection.php');
$action = $_POST['action'];
 if($action == "query") {	
 //$reporttype = $_POST['reporttype']; 
 //$cate = $_POST['cate'];
 //$type =$_POST['tygs']; 
 $startdate =$_POST['startdate']; 
 $enddate =$_POST['enddate']; 
 
 $QUEY = "";
 $msg = "";
echo "<table class='table table-bordered' id='table'> <thead><tr>
						<th>#</th>
						<th>Bill No</th>
						<th>Bill Date</th>  
						<th>With Tax</th>  
						<th>Without Tax</th>  
						<th>CGST </th>  
						<th>SGST </th>  	
						<th>KYC </th>  		
											</tr>";
					$QUEY = "SELECT  invoice_no, transaction_date,gst_total,total_amount,product_total,add_charge_total, coupen_discount, discount_amount, price_discount FROM saloon_sale_transaction  WHERE  bill_type = 'C' and date(transaction_date) between '$startdate' and ' $enddate' ";
				
				echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;						
						while ($row=mysqli_fetch_array($ret)) {
						$calcualte = ($row['product_total']  - ($row['price_discount'] + $row['coupen_discount'] )) * (84.0336134453782 / 100);
						
						$withouttax = $calcualte;
						$cgst = ($calcualte * 0.09);
						$sgst = ($calcualte * 0.09);
						$kfc = ($calcualte * 0.01);
						$withtax = ($calcualte + $cgst + $sgst + $kfc );
						//$cgst = (( $row['gst_total'])) * (47.36842105263158/100);
						//$sgst = (( $row['gst_total']))   *(47.36842105263158/100);
						//$kyc = (( $row['gst_total']))  *(5.263157894736842/100);
						echo "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['invoice_no']."</td> 
								<td class='eve'>".$row['transaction_date']."</td> 
								<td class='eve'>".number_format($withtax,2) ."</td> 
								<td class='eve'>".number_format($withouttax,2) ."</td> 
								<td class='eve'>".number_format($cgst,2)."</td> 
								<td class='eve'>".number_format($sgst,2)."</td>  
								<td class='eve'>".number_format($kfc,2)."</td> 
								
						</tr>";
							$i++;
					}
				}
				else {
						echo "<tr><th colspan='8'>No Data Found</th> </tr>";
					}
			}
			else {
					echo "<tr><th colspan='8'>".mysqli_error($con)."</th> </tr>";
				}
 }
 ?>