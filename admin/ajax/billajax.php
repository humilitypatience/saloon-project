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
if($action == 'loadservices') {
	$QUEY = "SELECT ID, ServiceName FROM tblservices WHERE active = 'Y' ORDER BY ID";
	//error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	echo "<label>Services</label><select id='ServiceDropDown' name='customer' class='form-control'>";						
	if($ret) {
		$co = mysqli_num_rows($ret);
		echo "<option value = '-1'>--Select Services--</option>";
		if($co > 0) {
			while ($row=mysqli_fetch_assoc($ret)) {				
				echo "<option value = '".$row['ID']."'>".$row['ServiceName']."</option>";
			}
		}
		else {
			
		}
	}
	else {		
		echo mysqli_error($ret);	
	}
	echo '</select>';
}
if($action == 'getser') {
	error_reporting(E_ALL);
	$id = $_POST['id'];
	$cid = $_POST['cid'];
	$employeeropdown = "";
	$member = 'N';
	$customer_query = "SELECT member FROM tblcustomers WHERE date(now()) between member_from_date and member_end_date and ID = ".$cid;
	error_log($customer_query);
	$customer_result=mysqli_query($con,$customer_query);
	if($customer_result) {
		$num_mem_row = mysqli_num_rows($customer_result);
		if($num_mem_row > 0) {
			$cus_row = mysqli_fetch_assoc($customer_result);
			$member_fetch = $cus_row['member'];
		}
		else {
			$member_fetch = 'N';
		}
		
		$QUEY = "SELECT ID, ServiceName, Cost, cgst, sgst, discount, discount_factor,member_cost,categories_id  FROM tblservices WHERE active = 'Y' and ID = ".$id;
		//error_log($QUEY);
		$ret=mysqli_query($con,$QUEY);
		if($ret) {
			$co = mysqli_num_rows($ret);
			$row = mysqli_fetch_assoc($ret);
			if($co > 0) {
					$QUEY2 = "SELECT ID, CONCAT(Name,' - ',MobileNumber) as employee FROM saloon_employee WHERE role = 'S' and active = 'Y' ORDER BY ID";
					//error_log($QUEY);
					$ret2=mysqli_query($con,$QUEY2 );
					$employeeropdown .= "<select id='EmployeeDropDown' name='employee[]' class='form-control EmployeeDropDown'>";						
					if($ret2) {
						$co2 = mysqli_num_rows($ret2);
						$employeeropdown .= "<option value = '-1'>--Select Employee--</option>";
						if($co > 0) {
							while ($row2=mysqli_fetch_assoc($ret2)) {				
								$employeeropdown .=  "<option value = '".$row2['ID']."'>".$row2['employee']."</option>";
							}
						}
						else {
							
						}
					}
					else {		
						$employeeropdown .=  mysqli_error($ret);
					}
					$employeeropdown .=  '</select>';
				 $ID= $row['ID'];
				 $ServiceName= $row['ServiceName'];
				 $Cost = "";
				 error_log($member_fetch);
				 if($member_fetch == "N") {
					$Cost= $row['Cost'];
				 }
				 if($member_fetch == "Y") {
					$Cost= $row['member_cost'];
				 }
				 error_log($Cost);
				 $cgst= $row['cgst'];
				 $categories_id= $row['categories_id'];
				 $sgst= $row['sgst'];
				 $discount_factor= $row['discount_factor'];
				 $discount= $row['discount'];
				 $total = "";
				if($discount_factor == "A") {
					$discount= $discount;
				}
				if($discount_factor == "P") {
					$discount= $Cost * ($discount / 100);
				}
				 $cgst_final =  ($Cost - $discount) * ($cgst / 100);
				 $sgst_final =  ($Cost - $discount) * ($sgst / 100);
				 $total =  ($Cost  - $discount + (( $cgst_final) +  ($sgst_final)));
			$tr = "<tr>				
					<td>
						<input type='hidden' class='id' name='sid[]' value='".$ID."'/>
						<input type='hidden' class='cg' name='cg[]' value='".$cgst."'/>
						<input type='hidden' class='sg' name='sg[]' value='".$sgst."'/>
						<input type='hidden' class='catet' name='cateid[]' value='".$categories_id."'/>
						
						<input class='form-control serviceName' name='serviceName[]' value='".$ServiceName."' readonly id='productName' tabindex='-1'   />
					</td>
					<td>$employeeropdown</td>
					<td><input type='text' name='cost[]' onkeyup='NumAndTwoDecimals(event , this);'  onkeydown='NumAndTwoDecimals(event , this);'  readonly class='cost form-control'  autocomplete='off' tabindex='1' value = '".$Cost."'  /></td>
					<td><input type='text' name='adchar[]' onkeyup='NumAndTwoDecimals(event , this);'  onkeydown='NumAndTwoDecimals(event , this);' onkeypress='NumAndTwoDecimals(event , this);' onkeydown='NumAndTwoDecimals(event , this);' class='adchar form-control'  autocomplete='off' value = '0.00'  /></td>					
					<td><input type='text' name='discount[]' onkeyup='NumAndTwoDecimals(event , this);' onkeydown='NumAndTwoDecimals(event , this);' onkeydown='NumAndTwoDecimals(event , this);'  class='discount form-control'  autocomplete='off' tabindex='2' value = '".$discount."'  /></td>
					<td><input type='text' name='cgst[]' onkeyup='NumAndTwoDecimals(event , this);' onkeydown='NumAndTwoDecimals(event , this);' onkeydown='NumAndTwoDecimals(event , this);' class='cgst form-control' readonly autocomplete='off' tabindex='-1' value = '".$cgst_final."'  /></td>
					<td><input type='text' name='sgst[]' onkeyup='NumAndTwoDecimals(event , this);' onkeydown='NumAndTwoDecimals(event , this);' class='sgst form-control' readonly autocomplete='off' tabindex='-1' value = '".$sgst_final."'  /></td>
					<td><input type='text' name='total[]' onkeyup='NumAndTwoDecimals(event , this);'  onkeydown='NumAndTwoDecimals(event , this);' class='total form-control' readonly autocomplete='off' tabindex='-1' value = '".$total."'  /></td>
					<td style='font-size: 12px;width: 5%;padding: 0px;vertical-align: middle;padding: 0px;text-align: center;'><a href='#' title='delete'><img src='images/cross.png' class='delete'/></a>  </td>
			</tr>";
					
			
		 } // /while 
		// //error_log($tr);
	echo $tr;
		}// if num_rows
		}
}
	
if($action == 'loadall') {
	
	$QUEY = "SELECT ID, CONCAT(Name,' - ',MobileNumber,'(',IF(member='Y','Member','Non-Member'),')') as customer FROM tblcustomers WHERE active = 'Y' ORDER BY ID";
	//error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	echo "<select id='CustomerDropDown' name='customer' class='form-control'>";						
	if($ret) {
		$co = mysqli_num_rows($ret);
		echo "<option value = '-1'>--Select Customer--</option>";
		if($co > 0) {
			while ($row=mysqli_fetch_assoc($ret)) {				
				echo "<option value = '".$row['ID']."'>".$row['customer']."</option>";
			}
		}
		else {
			
		}
	}
	else {		
		echo mysqli_error($ret);
	}
	echo '</select>';
	echo "[BRK]";
	$QUEY = "SELECT ID, ServiceName FROM tblservices WHERE active = 'Y' ORDER BY ID";
	//error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	echo "<label>Services</label><select id='ServiceDropDown' name='services' class='form-control'>";						
	if($ret) {
		$co = mysqli_num_rows($ret);
		echo "<option value = '-1'>--Select Services--</option>";
		if($co > 0) {
			while ($row=mysqli_fetch_assoc($ret)) {				
				echo "<option value = '".$row['ID']."'>".$row['ServiceName']."</option>";
			}
		}
		else {
			
		}
	}
	else {		
		echo mysqli_error($ret);	
	}
	echo '</select>';
	echo "[BRK]";
	$QUEY = "SELECT id, name FROM saloon_campaign WHERE active = 'Y' and (date(now()) between start_date and end_date) or (start_date is null or  end_date is null ) ORDER BY id";
	//error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	echo "<select id='PromoDropDown' name='campaign' class='form-control'>";						
	if($ret) {
		$co = mysqli_num_rows($ret);
		echo "<option value = '-1'>--Select Campaign--</option>";
		if($co > 0) {
			while ($row=mysqli_fetch_assoc($ret)) {				
				echo "<option value = '".$row['id']."'>".$row['name']."</option>";
			}
		}
		else {
			
		}
	}
	else {		
		echo mysqli_error($ret);	
	}
	echo "</select>";
	echo "[BRK]";
	$QUEY = "SELECT ID, CONCAT(Name,' - ',MobileNumber) as employee FROM saloon_employee ORDER BY ID";
	//error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	echo "<select id='EmployeeDropDown' name='employee' class='form-control'>";						
	if($ret) {
		$co = mysqli_num_rows($ret);
		echo "<option value = '-1'>--Select Employee--</option>";
		if($co > 0) {
			while ($row=mysqli_fetch_assoc($ret)) {				
				echo "<option value = '".$row['ID']."'>".$row['employee']."</option>";
			}
		}
		else {
			
		}
	}
	else {		
		echo mysqli_error($ret);
	}
	echo '</select>';
}
if($action == 'loadcustomers') {
	
	$QUEY = "SELECT ID, CONCAT(Name,' - ',MobileNumber) as customer FROM tblcustomers ORDER BY ID";
	//error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	echo "<select id='CustomerDropDown' name='customer' class='form-control'>";						
	if($ret) {
		$co = mysqli_num_rows($ret);
		echo "<option value = '-1'>--Select Customer--</option>";
		if($co > 0) {
			while ($row=mysqli_fetch_assoc($ret)) {				
				echo "<option value = '".$row['ID']."'>".$row['customer']."</option>";
			}
		}
		else {
			
		}
	}
	else {
		echo '</select>';
		echo mysqli_error($ret);
	}	
}
if($action == "submit") {
	$id = json_decode($_POST["ids"]);
	$catidcat = json_decode($_POST["catidcat"]);
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
		if (date('m') <= 3) {
			$ret_seq = date('y',strtotime('-1 year'))."-".date('y')."/".date('m/');
		}
		else {
			$ret_seq = date('y')."-".date('y',strtotime('+1 year'))."/".date('m/');
		}
	}
	if($type=='S') {
		$par = 2;
		if (date('m') <= 3) {
			$ret_seq = date('y',strtotime('-1 year'))."-".date('y')."/".date('m/');
		}
		else {
			$ret_seq = date('y')."-".date('y',strtotime('+1 year'))."/".date('m/');
		}
	}
	$number = date("z")+1; // 31
	
	error_log("number = ".$number);
	$year = cal_days_in_year(date('Y'));
	error_log("year = ".$year);
	$min = $year - $number;
	if( $min == 0 ) {
		$query = "UPDATE sequence_num SET value = 0000 WHERE id = 1";
		$result = mysqli_query($query);
	}
	$invoice_no = generate_seq_num($par, $con);
	if($type=='C') {
	$invoice_no = $ret_seq.$invoice_no;
	}
	if($type=='S') {
		$invoice_no = $ret_seq.$type.$invoice_no;
	}
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
												VALUES('$type',$pridis, $prodis, $ts ,'$proTotalAmt', $addcharge, '$txref','$invoice_no', $count,'$coupen_on', $coupen, $codi, now(),$customer, $total, $paid_amount,$balance_amount,'E','$paymentMode',now())";
				error_log($queryprepare1);
				$ret2=mysqli_query($con,$queryprepare1 );
				
				$upddate_query = "UPDATE tblcustomers SET last_invoice_id = '$invoice_no' WHERE ID = $customer";
				//error_log($upddate_query);
				$ret4=mysqli_query($con,$upddate_query );
				if($queryprepare2) {
					echo "<p style='text-align: center;font-size: x-large;font-family: monospace;color: black;'>Invoice No <span id='inno'> $invoice_no </span> Created Successfully</p>";
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
}
if($action == "promodiscount") {
	$id = $_POST['id'];
	$total = $_POST['total'];
	$QUEY = "SELECT discount_factor, discount FROM saloon_campaign WHERE id = ".$id." and active = 'Y' and (date(now()) between start_date and end_date) or (start_date is null or  end_date is null ) " ;
	//error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	if($ret) {
		$co = mysqli_num_rows($ret);
		if($co > 0) {
			$row = mysqli_fetch_assoc($ret);
			 $discount_factor= $row['discount_factor'];
			 $discount= $row['discount'];
			if($discount_factor == "A") {
				$discount= $discount;
			}
			if($discount_factor == "P") {
				$discount= $total * ($discount / 100);
			}
			//error_log($discount);
			echo $discount;
		}
		else {
		 echo 0;
		}		
	}
	echo  mysqli_error($con);
}
if($action == "getinvoicem") {
	$id = $_POST['id'];
	$cid = $_POST['cid'];
	$saloon_sale_transaction_query = "SELECT a.invoice_no, if(a.coupen='Y',(SELECT name FROM saloon_campaign WHERE ID = a.coupen_id ),'No Coupen Applied') as coupen, a.coupen_discount, a.transaction_date, a.total_amount, a.paid_amount,a.discount_amount, a.balance_amount, IF(a.payment_mode = 'CI','CASH-IN-HAND','CARD') as payment_mode, a.create_time, IFNULL((SELECT CONCAT(UserName,' - ',MobileNumber) FROM tbladmin WHERE ID = b.staff_id),' - ') as staff_id, b.total_bill FROM saloon_sale_transaction a, saloon_sales b  WHERE a.invoice_no = b.invoice_no and a.invoice_no = '$id' and a.customer_id = $cid" ;
	//error_log($saloon_sale_transaction_query);
	$saloon_sale_transaction_result=mysqli_query($con,$saloon_sale_transaction_query );
	$row2 = mysqli_fetch_assoc($saloon_sale_transaction_result);
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
	$saloon_sale_service_cart_query = "SELECT cart_id, service_name, actual_price, discount_price, cgst, sgst, total FROM saloon_sale_service_cart  WHERE cart_invoice_no = '$id' and customer_id = $cid" ;
	//error_log($saloon_sale_service_cart_query);
	$saloon_sale_service_cart_result=mysqli_query($con,$saloon_sale_service_cart_query );
	echo "<div class='modal-body cusmodel'> 
		  <table class='table table-bordered' width='100%' border='1'> 
					<thead>							
						<tr>
							<th colspan='2'>Invoice No: $invoice_no</th>							
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
	if($saloon_sale_service_cart_result) {
		$co = mysqli_num_rows($saloon_sale_service_cart_result);
		if($co > 0) {
			while($row = mysqli_fetch_assoc($saloon_sale_service_cart_result)) {
				$cart_id = $row['cart_id'];
				$service_name = $row['service_name'];
				$actual_price = $row['actual_price'];	
				$discount_price = $row['discount_price'];	
				$cgst = $row['cgst'];	
				$sgst = $row['sgst'];	
				$total = $row['total'];	
				
				echo "<tr><td>$cart_id</td>
						<td>$service_name</td>
						<td>$actual_price</td>
						<td>$discount_price</td>
						<td>$cgst</td>
						<td>$sgst</td>
						<td>$total</td>
					</tr>";
			}					
			echo "</tbody></table>
			<table class='table table-bordered'>
				<tr><th style='text-align:right'>Total Amount : $total_amount</th></tr>
				<tr><th style='text-align:right'>Discount Amount : $discount_amount</th></tr>
				<tr><th style='text-align:right'>Coupen Discount : $coupen_discount</th></tr>
				<tr><th style='text-align:right'>Paid Amount : $paid_amount</th></tr>
				<tr><th style='text-align:right'>Balance Amount : $balance_amount</th></tr>
				<tr><th style='text-align:right'>Payment Mode : $payment_mode</th></tr>
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
if($action == "getcusdet") {
	$id = $_POST['id'];
	$QUEY = "SELECT ID,Name, Email, MobileNumber, Gender, last_invoice_id, member,date(member_from_date) as member_from_date, date(member_end_date) as member_end_date , IF(member= 'Y','Member','Non-member') as memde FROM tblcustomers WHERE active = 'Y' and ID = ".$id ;
	//error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	
	echo "<div class='modal-body cusmodel'>"; 
	if($ret) {
		$co = mysqli_num_rows($ret);
		if($co > 0) {
			$row = mysqli_fetch_assoc($ret);
			$name = $row['Name'];
			$email = $row['Email'];
			$contact = $row['MobileNumber'];	
			$member = $row['member'];	
			$member_from_date = $row['member_from_date'];	
			$member_end_date = $row['member_end_date'];	
			$memde = $row['memde'];	
		
			echo "						
				<table class='table table-bordered'>
					<thead>
						<tr>
							<th>Name  </th>
							<th style='color:red' >$name </th>
						</tr>
						<tr>
							<th>E-mail</th>
							<th style='color:blue'>$email</th>
						</tr>
						
						<tr>
							<th >Contact No </th>
							<th style='color:blue'>$contact</th>
						</tr>
						<tr>
							<th >Member </th>
							<th style='color:blue'>$memde</th>
						</tr>";
						if($member == "Y") {
						echo "	<tr>
							<th >Member Start Date</th>
							<th style='color:blue'>$member_from_date </th>
						</tr>";
						echo "	<tr>
							<th >Member End Date</th>
							<th style='color:blue'>$member_end_date</th>
						</tr>";
						}
					echo "</thead>
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
  }
  function cal_days_in_year($year){
    $days=0; 
    for($month=1;$month<=12;$month++){ 
        $days = $days + cal_days_in_month(CAL_GREGORIAN,$month,$year);
     }
 return $days;
}
?>