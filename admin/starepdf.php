 <?php
//error_reporting(0);
require('tcpdf/tcpdf.php'); 
include('includes/dbconnection.php');
 ini_set("memory_limit",-1);
ERROR_REPORTING(0);
 //$cate = $_POST['cate'];
 $service = $_POST['service'];
 $staff =$_POST['staff']; 
 $datewise =$_POST['datewise']; 
 $startdate =$_POST['startdate']; 
 $enddate =$_POST['enddate']; 
 $QUEY = "";
 $msg = "";
$tithead = "Staff Report";

$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
$obj_pdf->SetCreator(PDF_CREATOR);  
$obj_pdf->SetTitle($tithead);  
$obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
$obj_pdf->SetDefaultMonospacedFont('helvetica');  
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
$obj_pdf->setPrintHeader(false);  
$obj_pdf->setPrintFooter(false);  
$obj_pdf->SetAutoPageBreak(TRUE, 10);  
$obj_pdf->SetFont('helvetica', '', 12);
$obj_pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
$obj_pdf->AddPage();  
$heading = "<h1 style='text-align:justify;'>$tithead</h1>";
$obj_pdf->Image('logo/logo.png', 16, 20, 30, 10, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
$date_report = "Report Generated at ".date('Y-d-m h:i:s A');
$obj_pdf->writeHTMLCell(150, '', 83, '', $heading, 0, 1, 0, true, '', true);

$obj_pdf->writeHTMLCell(150, '', 130, 20, $date_report, 0, 1, 0, true, '', true);
$obj_pdf->Ln();

$html = "<html>
<head><title style='display:none'>Report</title><link href='css/custom.css' rel='stylesheet'><link href='css/bootstrap.css' rel='stylesheet' type='text/css' /><link href='css/style.css' rel='stylesheet' type='text/css' /><link rel='stylesheet' href='css/popup.css' type='text/css' media='screen' /><link rel='stylesheet' type='text/css' href='css/default1.css'/><link rel='stylesheet' type='text/css' href='css/layout.css' media='screen' />'
		<style>#footer {position: absolute;bottom: 0;width: 100%;height: 100px;}</style><span class='header'><p style='float:right;margin-top:0.4px'></p>
		<h2 style='text-align:center;margin-top:30px'>PDF Report</h2></span><style>
                .tableWithOuterBorder{
                    border: 0.5px solid black;
                    border-collapse: separate;
                    border-spacing: 0;
                }
                </style><style>th{color:red;text-align:center;border:1px solid black;}</style><style>td{text-align:center;border:1px solid black;}</style></head><body><br>
		
		";
				$html .= "";
	$obj_pdf->Ln();
	
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
					$html .=  "<b><p style='color:red;font-size:14px;font-family:bold;text-align:left;margin-bottom:1%'>".$row['Name']." : </p></b>";
						$html .=  "<table class='table table-bordered' id='table'><thead><tr>
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
									$html .=  "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><td colspan='4'>No Data Found</td><td></td> <td></td><td></td><td></td></tr></tbody></table>";
							}
							else {
							$i =1;
							$wholeto =  0;
								while ($row2=mysqli_fetch_array($result)) {							
								$wholeto += $row2['total_amount'];
								$html .=  "
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
						
						$html .=  "<tr>
							<td colspan = '5' style='text-align:right'>Total Sales Count</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
						}
						else {
							$html .=  "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr>";
						}
					}
					
				}
				else {
					$html .=  "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><td colspan='4'>No Data Found</td><td style=''></td><td style=''></td> </tr></tbody></table>";
				}
			}
				else {
					$html .=  "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr>";
					}
			
$html .=  "</tbody> </table> ";
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
					$html .=  "<b><p style='color:red;font-size:14px;font-family:bold;text-align:left;margin-bottom:1%'>".$row['Name']." : </p></b>";
						$html .=  "<table class='table table-bordered' id='table'><thead><tr>
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
									$html .=  "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><td colspan='4'>No Data Found</td> <td style=''></td><td style=''></td></tr></tbody></table>";
							}
							else {
							$i =1;
							$wholeto =  0;
								while ($row2=mysqli_fetch_array($result)) {							
								$wholeto += $row2['total_amount'];
								$html .=  "
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
						
						$html .=  "<tr>
							<td></td><td></td><td colspan = '5' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr>";
						}
						else {
							$html .=  "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr>";
						}
					}
					
				}
				else {
					$html .=  "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><th colspan='4'>No Data Found</th> </tr></tbody></table>";
				}
			}
				else {
					$html .=  "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr>";
					}
			
$html .=  "</tbody> </table> ";
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
					$html .=  "<b><p style='color:red;font-size:14px;font-family:bold;text-align:left;margin-bottom:1%'>".$row['Name']." : </p></b>";
						$html .=  "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Date</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody>";
						if($service == "ALL") {
							$query = "SELECT c.transaction_date, a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a,  saloon_employee b,saloon_sale_transaction c,tblservices d WHERE  a.service_id=d.ID and date(c.transaction_date) between '$startdate' and '$enddate' and  a.cart_invoice_no = c.invoice_no and a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name,transaction_date";
;
						}
						else {
							$query = "SELECT c.transaction_date, a.service_name,b.Name,sum(a.total) as total_amount,count(cart_id) as count, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category  FROM saloon_sale_service_cart a,  saloon_employee b,saloon_sale_transaction c,tblservices d WHERE  a.service_id=d.ID and date(c.transaction_date) between '$startdate' and '$enddate' and  a.cart_invoice_no = c.invoice_no and a.service_id = $service and a.employee_id = b.ID and a.employee_id = ".$row['employee_id']." GROUP BY employee_id,service_name,transaction_date";
						}
						error_log($query);
						$result=mysqli_query($con,$query );
						if($result) {
							$co2 = mysqli_num_rows($result);
							if($co2 <= 0) {
									$html .=  "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Date</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><th colspan='5'>No Data Found</th><td style=''></td></tr></tbody></table>";
							}
							else {
							$i =1;
							$wholeto =  0;
								while ($row2=mysqli_fetch_array($result)) {							
								$wholeto += $row2['total_amount'];
								$html .=  "
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
						
						$html .=  "<tr>
							<td style=''></td><td style=''></td><td style=''></td><td colspan = '5' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
						}
						else {
							$html .=  "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr>";
						}
					}
					
				}
				else {
					$html .=  "<table class='table table-bordered' id='table'><thead><tr>
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
					$html .=  "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr>";
					}
			
$html .=  "</tbody> </table> ";
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
					$html .=  "<b><p style='color:red;font-size:14px;font-family:bold;text-align:left;margin-bottom:1%'>".$row['Name']." : </p></b>";
						$html .=  "<table class='table table-bordered' id='table'><thead><tr>
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
									$html .=  "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
											<th style='text-align:center;width:25%'>Date</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><th colspan='4'>No Data Found</th> </tr>";
							}
							else {
							$i =1;
							$wholeto =  0;
								while ($row2=mysqli_fetch_array($result)) {							
								$wholeto += $row2['total_amount'];
								$html .=  "
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
							$html .=  "<tr>
							<td style=''></td><td style=''></td><td style=''></td><td colspan = '5' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
						
						}
						}
					
						else {
							$html .=  "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr></tbody></table>";
						}
					}
					
				}
				else {
					$html .=  "<table class='table table-bordered' id='table'><thead><tr>
										<th style='text-align:center;width:25%'>#</th>
										<th style='text-align:center;width:25%'>Service</th>
										<th style='text-align:center;width:25%'>Category</th>
										<th style='text-align:center;width:25%'>Count</th>
										<th style='text-align:center;width:25%'>Total Value</th>
									</tr></thead><tbody><tr><th colspan='4'>No Data Found</th> </tr></tbody></table>";
				}
			}
				else {
					$html .=  "<tr><th colspan='4'>".mysqli_error($con)."</th> </tr></tbody></table>";
					}
			

 }
 }
 $html .= "</tbody></table>";
	
//error_log($html);
	$obj_pdf->writeHTMLCell(0, 0, '', '', $html , 0, 1, 0, true, '', true);
	$date = date('Ymdhs');
	$filereport_file_name = $report_file_name.$date;
 	$filereport_file_name = $report_file_name.$date;
 	$path = REPORT_SAVE_LOCATION;
 	if (!file_exists($path)) {
	 	mkdir($path, 0777, true);
 	}
	
	$full_path = $path.$filereport_file_name.".pdf";
	ob_end_clean();
	$obj_pdf->Output($full_path, 'I');
	$obj_pdf->Output($full_path, 'F'); 
?>
