<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['naturalsaid']==0)) {
  header('location:logout.php');
} 
else{  
	include('../includes/dbconnection.php');
	$action = $_POST['action'];
	if($action == 'loadcustomersal') {		
		$QUEY = "SELECT ID, CONCAT(Name,' - ',MobileNumber) as customer FROM tblcustomers WHERE active = 'Y' ORDER BY ID";
		error_log($QUEY);
		$ret=mysqli_query($con,$QUEY );
		echo "<select id='CustomerDropDown' name='customer' class='form-control'>";						
		if($ret) {
			$co = mysqli_num_rows($ret);
			echo "<option value = 'ALL'>ALL</option>";
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
	if($action == 'loadcategory') {		
		$QUEY = "SELECT id, name FROM tblcategories WHERE active = 'Y' ORDER BY id";
		error_log($QUEY);
		$ret=mysqli_query($con,$QUEY );
		echo "<select id='CATDropDown' name='cats' class='form-control' required>";						
		if($ret) {
			$co = mysqli_num_rows($ret);
			echo "<option value = 'ALL'>--ALL--</option>";
			if($co > 0) {
				while ($row=mysqli_fetch_assoc($ret)) {				
					echo "<option value = '".$row['id']."'>".$row['name']."</option>";
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
	if($action == 'loadinv') {		
		$QUEY = "SELECT invoice_no FROM saloon_sale_transaction";
		error_log($QUEY);
		$ret=mysqli_query($con,$QUEY );
		echo "<select id='InvoiceDropDown' name='invoice' class='form-control'>";						
		if($ret) {
			$co = mysqli_num_rows($ret);
			echo "<option value = 'ALL'>ALL</option>";
			if($co > 0) {
				while ($row=mysqli_fetch_assoc($ret)) {				
					echo "<option value = '".$row['invoice_no']."'>".$row['invoice_no']."</option>";
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
	if($action == 'loadcainv') {		
		$QUEY = "SELECT invoice_no FROM dlt_saloon_sale_transaction";
		error_log($QUEY);
		$ret=mysqli_query($con,$QUEY );
		echo "<select id='InvoiceDropDown' name='invoice' class='form-control'>";						
		if($ret) {
			$co = mysqli_num_rows($ret);
			echo "<option value = 'ALL'>ALL</option>";
			if($co > 0) {
				while ($row=mysqli_fetch_assoc($ret)) {				
					echo "<option value = '".$row['invoice_no']."'>".$row['invoice_no']."</option>";
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
	
	
	if($action == 'loadcat') {		
		$QUEY = "SELECT id, name FROM tblcategories WHERE active = 'Y' ORDER BY id";
		error_log($QUEY);
		$ret=mysqli_query($con,$QUEY );
		echo "<select id='CATDropDown' name='cats' class='form-control' required>";						
		if($ret) {
			$co = mysqli_num_rows($ret);
			echo "<option value = 'ALL'>--Select--</option>";
			if($co > 0) {
				while ($row=mysqli_fetch_assoc($ret)) {				
					echo "<option value = '".$row['id']."'>".$row['name']."</option>";
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
	if($action == 'loadservices') {
		$QUEY = "SELECT ID, ServiceName FROM tblservices WHERE active = 'Y' and ID not in (SELECT service_id FROM incentive_mapping) ORDER BY ID";
		//error_log($QUEY);
		$ret=mysqli_query($con,$QUEY );
		echo "<label>Services</label><select id='ServiceDropDown' name='service' class='form-control'>";						
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
	}
	
	if($action == 'loadse') {		
		$QUEY = "SELECT ID, ServiceName FROM tblservices WHERE active = 'Y' ORDER BY ID";
		error_log($QUEY);
		$ret=mysqli_query($con,$QUEY );
		echo "<select id='ServiceDropDown' name='service' class='form-control'>";						
		if($ret) {
			$co = mysqli_num_rows($ret);
			echo "<option value = 'ALL'>ALL</option>";
			if($co > 0) {
				while ($row=mysqli_fetch_assoc($ret)) {				
					echo "<option value = '".$row['ID']."'>".$row['ServiceName']."</option>";
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
	

	if($action == 'loadstaffal') {		
		$QUEY = "SELECT ID, CONCAT(Name,' - ',MobileNumber) as staff FROM saloon_employee WHERE active = 'Y' ORDER BY ID";
		error_log($QUEY);
		$ret=mysqli_query($con,$QUEY );
		echo "<select id='staffDropDown' name='staff' class='form-control'>";						
		if($ret) {
			$co = mysqli_num_rows($ret);
			echo "<option value = 'ALL'>ALL</option>";
			if($co > 0) {
				while ($row=mysqli_fetch_assoc($ret)) {				
					echo "<option value = '".$row['ID']."'>".$row['staff']."</option>";
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
	if($action == 'loadgst') {		
		$QUEY = "SELECT sgst, gst_name as name,cgst FROM saloon_gst WHERE active = 'Y' ORDER BY id";
		error_log($QUEY);
		$ret=mysqli_query($con,$QUEY );
		$ret2=mysqli_query($con,$QUEY );
		echo "<select id='CGSTDropDown' name='cgst' class='form-control'>";						
		if($ret) {
			$co = mysqli_num_rows($ret);
			echo "<option value = '-1'>--Select CGST--</option>";
			if($co > 0) {
				while ($row=mysqli_fetch_assoc($ret)) {				
					echo "<option value = '".$row['cgst']."'>".$row['name']."</option>";
				}
			}
			else {
				
			}
		}
		else {			
			 mysqli_error($ret);
		}	
		echo "</select>[BRK]<select id='SGSTDropDown' name='sgst' class='form-control'>";
		if($ret2) {
			$co = mysqli_num_rows($ret2);
			echo "<option value = '-1'>--Select SGST--</option>";
			if($co > 0) {
				while ($row=mysqli_fetch_assoc($ret2)) {				
					echo "<option value = '".$row['sgst']."'>".$row['name']."</option>";
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
}
?>