 <?php
//error_reporting(0);
require('tcpdf/tcpdf.php'); 
include('includes/dbconnection.php');
 ini_set("memory_limit",-1);
ERROR_REPORTING(0);
 //$cate = $_POST['cate'];
 $type =$_POST['tygs']; 
 $startdate =$_POST['startdate']; 
 $enddate =$_POST['enddate']; 
 $detail =$_POST['detail']; 
 $datewise =$_POST['datewise']; 
 $QUEY = "";
 $msg = "";
$tithead = "Customer Sale Report";

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
				$html .= "<table style='width: 100%;position: relative;' id='table'><thead>";
	

				 $msg  = "CUSTOMER SALE REPORT  Date $startdate and $enddate";
					$html .=  "<tr>
							<th>#</th>
								
									<th>Customer Name</th>
									<th>Category</th> 
									<th>Service Name</th>  
									<th>Total Cost</th>  
									<th>Total Disount</th>  
									<th>GST Amount</th>  
									<th>Net Total</th>   		
					</tr>";
					$QUEY = "SELECT c.price_discount as tradisscount, a.cart_invoice_no,c.invoice_no, c.coupen_discount, a.service_name as sername, b.Name as name,sum(a.actual_price) as cost,sum(a.total) as total,sum(a.discount_price) as discount_price, a.cart_invoice_no, sum(a.cgst+a.sgst) as gst, IFNULL(( select name from tblcategories x,tblservices y where x.id=y.categories_id and y.id=a.service_id ),'-') as category FROM saloon_sale_service_cart a, tblcustomers b,saloon_sale_transaction c, tblservices d  WHERE a.service_id = d.ID and a.cart_invoice_no = c.invoice_no and a.customer_id = b.ID   and date(c.transaction_date) between '$startdate' and '$enddate'  and  c.bill_type='C'  GROUP BY a.cart_invoice_no,c.invoice_no, a.customer_id,sername";
				$html .=  "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =1;
						 $wholeto =  0;
						while ($row=mysqli_fetch_array($ret)) {
							$wholeto += $row['total'];
							
						$html .=  "<tr> 
								<th scope='row'>".$i."</th> 
							
								<td class='eve'>".$row['name']."</td> 
								<td class='eve'>".$row['category']."</td> 
								<td class='eve'>".$row['sername']."</td> 
								<td class='eve'>".$row['cost']."</td> 
								<td class='eve'>".$row['discount_price']."</td> 
								<td class='eve'>".$row['gst']."</td> 
								<td class='eve'>".$row['total']."</td> 
						</tr>";
							$i++;
					}
					$QUEY2 = "SELECT  sum(price_discount) as sprice_discount, sum(IFNULL(coupen_discount,0.00)) as  scoupen_discount FROM  saloon_sale_transaction WHERE  date(transaction_date) between '$startdate' and '$enddate'  and  bill_type='C' and invoice_no in (SELECT DISTINCT cart_invoice_no FROM saloon_sale_service_cart )  ";
					error_log($QUEY2);
					$ret2=mysqli_query($con,$QUEY2 );
					if($ret2) {
						$co2 = mysqli_num_rows($ret2);
						$row2=mysqli_fetch_array($ret2);
						$sprice_discount = $row2['sprice_discount'];
						$scoupen_discount = $row2['scoupen_discount'];
					}
					else {
						echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
					}
					$html .= "<tr>
							<td style=''></td><td style=''></td><td style=''></td><td style=''></td><td style=''></td><td style=''></td><td colspan = '7' style='text-align:right'>Total Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto,2)."</b></td>
						</tr>
						<tr>
							<td style=''></td><td style=''></td><td style=''></td><td style=''></td><td style=''></td><td style=''></td><td colspan = '7' style='text-align:right'>Total Coupen Disount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($scoupen_discount,2)."</b></td>
							
						</tr>
						<tr>
							<td style=''></td><td style=''></td><td style=''></td><td style=''></td><td style=''></td><td style=''></td><td colspan = '7' style='text-align:right'>Total Whole Disount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($sprice_discount,2)."</b></td>
							
						</tr>
						<tr>
							<td style='border:none'></td><td style=''></td><td style=''></td><td style=''></td><td style=''></td><td style=''></td><td colspan = '7' style='text-align:right'>Total Net Amount</td>
							<td colspan = '1' style='text-align:center;color:blue;font-size:20px;font-family:bold;'><b>".number_format($wholeto - ($sprice_discount + $scoupen_discount),2)."</b></td>
							
						</tr>
						
						</tbody></table>";
					}
					else {
						$html .=  "<tr><th colspan='7'>No Data Found</th> </tr>";
					}
				}
				else {
					$html .=  "<tr><th colspan='7'>".mysqli_error($con)."</th> </tr>";
				}
	//$html .=  "</tbody> </table> <p style='text-align:left;color:red;font-size:14px'>Count: $co</p>";
	$html .= "</tbody></table>";
//error_log($html);
	$obj_pdf->writeHTMLCell(0, 0, '', '', $html , 0, 1, 0, true, '', true);
	$date = date('Ymdhs');
	$filereport_file_name = $report_file_name.$date;
 	$filereport_file_name = $report_file_name.$date;
 	$path = REPORT_SAVE_LOCATION.$date;
 	if (!file_exists($path)) {
	 	mkdir($path, 0777, true);
 	}
	
	$full_path = $path ."/".$filereport_file_name.".pdf";
		ob_end_clean();
	$obj_pdf->Output($full_path, 'I');
	$obj_pdf->Output($full_path, 'F'); 
?>
