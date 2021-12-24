<?php
//error_reporting(0);
require('tcpdf/tcpdf.php'); 
include('includes/dbconnection.php');
 ini_set("memory_limit",-1);
ERROR_REPORTING(0);
 $cate = $_POST['cate'];
 $customer =$_POST['customer']; 
  $detail =$_POST['detail']; 
 $datewise =$_POST['datewise']; 
 $startdate =$_POST['startdate']; 
 $enddate =$_POST['enddate']; 
$tithead = "";
if($cate == "CBW") {
	$tithead = "Customer Billwise History";
}
else {
	$tithead = "Customer No of visited History";
}
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
$obj_pdf->writeHTMLCell(150, '', 58, '', $heading, 0, 1, 0, true, '', true);

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
	$obj_pdf->Ln();
	$html .= "<table style='width: 100%;position: relative;' id='table'>
		<thead>";


		
	if($cate == "CBW") {
		if($detail != "Y") {	
				if($datewise != "Y") {
				
				$html .=  "<tr>
							<th>#</th>
							<th>Customer Name</th>  
							<th>Total Amount</th>  
						</tr>";
					
				$html .=  "</thead><tbody>";
			if($customer == "ALL") {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount, a.customer_id, b.Name FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id ORDER BY total_amount desc";
			}
			else {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount, a.customer_id, b.Name FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id ORDER BY total_amount desc";
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
						
					$html .=  "<tr> 
							<th scope='row'>".$i."</th> 
							<td class='eve'>".$row['Name']."</td> 
							<td class='eve'>".number_format($row['total_amount'],2)."</td> 
					</tr>";
						$i++;
				}
				$html .=  "<tr>
							<td style=''></td><td colspan = '2' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
				}
				else {
					$html .=  "<tr><th colspan='3'>No Data Found</th> </tr>";
				}
			}
				else {
					$html .=  "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
					}
			}
			else {
						
				$html .=  "<tr>
							<th>#</th>
							<th>Customer Name</th>  
							<th>Date</th>  
							<th>Total Amount</th>  
						</tr>";
					
				$html .=  "</thead><tbody>";
			if($customer == "ALL") {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount, a.transaction_date, a.customer_id, b.Name FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id,a.transaction_date ORDER BY a.transaction_date desc";
			}
			else {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount,  a.transaction_date,a.customer_id, b.Name FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id,a.transaction_date ORDER BY a.transaction_date desc";
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
						
					$html .=  "<tr> 
							<th scope='row'>".$i."</th> 
							<td class='eve'>".$row['Name']."</td> 
							<td class='eve'>".$row['transaction_date']."</td> 
							<td class='eve'>".number_format($row['total_amount'],2)."</td> 
					</tr>";
						$i++;
				}
				$html .=  "<tr>
							<td style=''></td><td style=''></td><td colspan = '2' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
				}
				else {
					$html .=  "<tr><th colspan='3'>No Data Found</th> </tr>";
				}
			}
				else {
					$html .=  "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
					}
			}
		}
		else {
			if($datewise != "Y") {
				
				$html .=  "<tr>
							<th>#</th>
							<th>Customer Name</th>  
							<th>Category</th>
							<th>Services Name</th>  
							<th>Total Amount</th>  
						</tr>";
					
				$html .=  "</thead><tbody>";
			if($customer == "ALL") {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount,c.service_name, a.customer_id, b.Name, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and  c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id, c.service_name ORDER BY total_amount desc";
			}
			else {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount, c.service_name, a.customer_id, b.Name, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and   c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id,c.service_name ORDER BY total_amount desc";
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
						
					$html .=  "<tr> 
							<th scope='row'>".$i."</th> 
							<td class='eve'>".$row['Name']."</td> 
							<td class='eve'>".$row['category']."</td>
							<td class='eve'>".$row['service_name']."</td> 
							<td class='eve'>".number_format($row['total_amount'],2)."</td> 
					</tr>";
						$i++;
				}
				$html .=  "<tr>
							<td style=''></td><td style=''></td><td style=''></td><td colspan = '2' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
				}
				else {
					$html .=  "<tr><th colspan='3'>No Data Found</th> </tr>";
				}
			}
				else {
					$html .=  "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
					}
			}
			else {
						
			$html .=  "<tr>
							<th>#</th>
							<th>Customer Name</th>  
							<th>Category</th>
							<th>Services Name</th>  
							<th>Date</th>  
							<th>Total Amount</th>  
						</tr>";
					
				$html .=  "</thead><tbody>";
			if($customer == "ALL") {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount,c.service_name, a.customer_id, b.Name, a.transaction_date, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and    c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id, c.service_name,a.transaction_date ORDER BY total_amount,a.transaction_date desc";
			}
			else {
				$QUEY = "SELECT SUM(a.total_amount) as total_amount, c.service_name, a.customer_id, b.Name, a.transaction_date,IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and    c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id,c.service_name,a.transaction_date ORDER BY total_amount,a.transaction_date desc";
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
						
					$html .=  "<tr> 
							<th scope='row'>".$i."</th> 
							<td class='eve'>".$row['Name']."</td>
							<td class='eve'>".$row['category']."</td>							
							<td class='eve'>".$row['service_name']."</td> 
							<td class='eve'>".$row['transaction_date']."</td> 
							<td class='eve'>".number_format($row['total_amount'],2)."</td> 
					</tr>";
						$i++;
				}
				$html .=  "<tr>
							<td style=''></td><td style=''></td><td style=''></td><td style=''></td><td colspan = '2' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
				}
				else {
					$html .=  "<tr><th colspan='3'>No Data Found</th> </tr>";
				}
			}
				else {
					$html .=  "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
					}
			}
		}
}
	if($cate == "CNO") {
		if($detail != "Y") {	
				if($datewise != "Y") {
					$html .=  "<tr>
								<th>#</th>
								<th>Customer Name</th>  
								<th>No Of Visists</th>  
							</tr>";
						
					$html .=  "</thead><tbody>";
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
					 $wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total_amount'];
							
						$html .=  "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['Name']."</td> 
								<td class='eve'>".($row['count'])."</td> 
						</tr>";
							$i++;
					}
					$html .=  "<tr>
							<td style=''></td><td colspan = '2' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
					}
					else {
						$html .=  "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					$html .=  "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
			}
			else {
					$html .=  "<tr>
								<th>#</th>
								<th>Customer Name</th>  
								<th>Date</th>  
								<th>No Of Visists</th>  
							</tr>";
						
					$html .=  "</thead><tbody>";
				if($customer == "ALL") {
					$QUEY = "SELECT count(a.invoice_no) as count , a.customer_id, b.Name, a.transaction_date FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id,a.transaction_date ORDER BY a.transaction_date desc";
				}
				else {
					$QUEY = "SELECT count(a.invoice_no) as count, a.customer_id, b.Name, a.transaction_date FROM saloon_sale_transaction a, tblcustomers b WHERE date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id,a.transaction_date ORDER BY a.transaction_date desc";
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
							
						$html .=  "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['Name']."</td> 
								<td class='eve'>".$row['transaction_date']."</td> 
								<td class='eve'>".($row['count'])."</td> 
						</tr>";
							$i++;
					}
					$html .=  "<tr>
							<td style=''></td><td style=''></td><td colspan = '2' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
					}
					else {
						$html .=  "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					$html .=  "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
			}
		}
		else {
			if($datewise != "Y") {
					$html .=  "<tr>
								<th>#</th>
								<th>Customer Name</th>  
								<th>Category</th>
								<th>Service Name</th>
								<th>No Of Visists</th>  
							</tr>";
						
					$html .=  "</thead><tbody>";
				if($customer == "ALL") {
					$QUEY = "SELECT count(a.invoice_no) as count , a.customer_id, b.Name,c.service_name,IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and    c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id,c.service_name ORDER BY c.service_name desc";
				}
				else {
					$QUEY = "SELECT count(a.invoice_no) as count, a.customer_id, b.Name,c.service_name,IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b, saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and    c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id,c.service_name ORDER BY c.service_name desc";
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
							
						$html .=  "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['Name']."</td>
									<td class='eve'>".$row['category']."</td>
								<td class='eve'>".$row['service_name']."</td> 
								<td class='eve'>".($row['count'])."</td> 
						</tr>";
							$i++;
					}
					$html .=  "<tr>
							<td style=''></td><td style=''></td><td style=''></td><td colspan = '2' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
					}
					else {
						$html .=  "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					$html .=  "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
			}
			else {
					$html .=  "<tr>
								<th>#</th>
								<th>Customer Name</th>  
								<th>Category</th>
								<th>Service Name</th>
								<th>Date</th>  
								<th>No Of Visists</th>  
							</tr>";
						
					$html .=  "</thead><tbody>";
				if($customer == "ALL") {
					$QUEY = "SELECT count(a.invoice_no) as count , a.customer_id, b.Name, a.transaction_date,c.service_name,IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b , saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and   c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID GROUP BY a.customer_id,a.transaction_date,c.service_name ORDER BY a.transaction_date desc";
				}
				else {
					$QUEY = "SELECT count(a.invoice_no) as count, a.customer_id, b.Name, a.transaction_date,c.service_name,IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=c.service_id ),'-') as category FROM saloon_sale_transaction a, tblcustomers b , saloon_sale_service_cart c,tblservices d  WHERE  c.service_id=d.ID and c.cart_invoice_no = a.invoice_no and date(a.transaction_date) between '$startdate' and '$enddate' and  a.customer_id= b.ID and  a.customer_id = $customer GROUP BY a.customer_id,a.transaction_date,c.service_name ORDER BY a.transaction_date desc";
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
							
						$html .=  "<tr> 
								<th scope='row'>".$i."</th> 
								<td class='eve'>".$row['Name']."</td>
									<td class='eve'>".$row['category']."</td>
								<td class='eve'>".$row['service_name']."</td> 
								<td class='eve'>".$row['transaction_date']."</td> 
								<td class='eve'>".($row['count'])."</td> 
						</tr>";
							$i++;
					}
					$html .=  "<tr>
							<td style=''></td><td style=''></td><td style=''></td><td style=''></td><td colspan = '2' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr></tbody></table>";
					}
					else {
						$html .=  "<tr><th colspan='3'>No Data Found</th> </tr>";
					}
				}
				else {
					$html .=  "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
				}
		}}
}

$html .=  "</tbody> </table> ";
//error_log($html);
	$obj_pdf->writeHTMLCell(0, 0, '', '', $html , 0, 1, 0, true, '', true);
	$date = date('Ymdhs');
	$filereport_file_name = $report_file_name.$date;
 	$path = REPORT_SAVE_LOCATION.$date;
 	if (!file_exists($path)) {
	 	mkdir($path, 0777, true);
 	}
	
	$full_path = $path.$filereport_file_name.".pdf";
		ob_end_clean();
	$obj_pdf->Output($full_path, 'I');
	$obj_pdf->Output($full_path, 'F'); 
?>
