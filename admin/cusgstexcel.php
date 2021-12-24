<?php
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
ERROR_REPORTING(E_ALL);
include("excelfunctions.php");
include('includes/dbconnection.php');
require_once __DIR__ . '/PhpSpreadsheet/samples/Bootstrap.php';

$helper = new Sample();
if ($helper->isCli()) {
    $helper->log('This example should only be run from a Web Browser' . PHP_EOL);

    return;
}
 $startdate =$_POST['startdate']; 
 $enddate =$_POST['enddate']; 
 
// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('Maarten Balliauw')
    ->setLastModifiedBy('Umar.Naturals')
    ->setTitle("Customer Gst Report ")
    ->setSubject('Naturals-Customer Gst Report')
    ->setDescription("Between $startdate to $enddate ")
    ->setKeywords('Customer Gst Report Nturals')
    ->setCategory('Customer Gst Report');

// Add some data
$heading = array("S.no","Bill No","Bill Date","With Tax","Without Tax","CGST","SGST","KFC");
			heading($heading,$spreadsheet,8);

$QUEY = "SELECT  invoice_no, transaction_date,gst_total,total_amount,product_total, coupen_discount,add_charge_total, discount_amount, price_discount FROM saloon_sale_transaction  WHERE  bill_type = 'C' and date(transaction_date) between '$startdate' and ' $enddate' ";
				
				//echo "</thead><tbody>";
				error_log($QUEY);
				$ret=mysqli_query($con,$QUEY );
				if($ret) {
					$co = mysqli_num_rows($ret);
					if($co > 0) {
						$i =2;					
							
						while ($row=mysqli_fetch_array($ret)) {
						//	error_log("isss".$i);
						$calcualte = ($row['product_total']  - ($row['price_discount'] + $row['coupen_discount'] )) * (84.0336134453782 / 100);
						
						$withouttax = $calcualte;
						$cgst = ($calcualte * 0.09);
						$sgst = ($calcualte * 0.09);
						$kfc = ($calcualte * 0.01);
						$withtax = ($calcualte + $cgst + $sgst + $kfc );
						$Header=array("A", "B", "C", "D", "E","F","G", "H", "I", "J", "K", "L");        
						$style = array(
						'alignment' => array(
						//    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							)
						);    
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
						//	  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						); 		
						     for($j=1; $j<11; $j++) {    
						
						$spreadsheet->getActiveSheet()->getColumnDimension("$Header[$j]")->setWidth(15);
						//$spreadsheet->getActiveSheet()->getColumnDimension("$Header[$j]")->setAutoSize(true);
						 $spreadsheet->setActiveSheetIndex(0)->setCellValue("$Header[0]"."$i",$i);
						  $spreadsheet->setActiveSheetIndex(0)->setCellValue("$Header[1]"."$i",$row['invoice_no']);
						   $spreadsheet->setActiveSheetIndex(0)->setCellValue("$Header[2]"."$i",$row['transaction_date']);
						     $spreadsheet->setActiveSheetIndex(0)->setCellValue("$Header[3]"."$i",number_format($withtax,2));
							   $spreadsheet->setActiveSheetIndex(0)->setCellValue("$Header[4]"."$i",number_format($withouttax,2));
							    $spreadsheet->setActiveSheetIndex(0)->setCellValue("$Header[5]"."$i",number_format($cgst,2));
								  $spreadsheet->setActiveSheetIndex(0)->setCellValue("$Header[6]"."$i",number_format($sgst,2));
								  $spreadsheet->setActiveSheetIndex(0)->setCellValue("$Header[7]"."$i",number_format($kfc,2));
								
						 
							 }
						 // $spreadsheet->getActiveSheet()->getColumnDimension($Header[$j])->setWidth(25);
						  //$spreadsheet->getActiveSheet()->getDefaultStyle()->applyFromArray($style);
						  //$spreadsheet->getActiveSheet()->getStyle("$Header[$j]"."$i")->applyFromArray($styleArray);		  
						$i++;
						}
				}
				else {
						//echo "<tr><th colspan='8'>No Data Found</th> </tr>";
					}
			}
			else {
					//echo "<tr><th colspan='8'>".mysqli_error($con)."</th> </tr>";
				}
// Miscellaneous glyphs, UTF-8

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle("CGRPTBW".date('ymd'));

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename="."GST REPORT .xlsx"."");
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
//exit;
