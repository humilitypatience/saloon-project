<?php
//ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/session'));
session_start();

error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['naturalsaid']==0)) {
  header('location:logout.php');
  } 
  $role = $_SESSION['role'];
  include 'Calendar.php';
$calendar = new Calendar(date('y-m-d'));
$birthquery = "SELECT Name, birth_date, IFNULL(annivarsary_date,'-') as annivarsary_date FROM tblcustomers ";
$birthresult = mysqli_query($con,$birthquery);
while($row = mysqli_fetch_assoc($birthresult)) {
	$calendar->add_event( $row['Name'].' Birthday', $row['birth_date'] , 1, 'green');
	$calendar->add_event($row['Name'].'Annivarsary ', $row['annivarsary_date'] , 1);
}



     ?>
<!DOCTYPE HTML>
<html>
<head>
<title>Naturals | Admin Dashboard</title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- font CSS -->
<!-- font-awesome icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
 <!-- js-->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/modernizr.custom.js"></script>
<!--webfonts-->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!--//webfonts--> 
<!--animate-->


<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!-- chart -->
<script src="js/Chart.js"></script>
<!-- //chart -->
<!--Calender-->

<!--End Calender-->
<!-- Metis Menu -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
<style>
h3 {
	text-align:center;
}
.stats-left {
    float: none;
    margin: auto;
    width: 100%;
    background-color: #4F52BA;
    text-align: center;
    padding: 10px ;
}
.col-md-6 {
    width: 50%;
    padding: 0px;
    border: 1px dotted;
}
.col-md-3 {
    width: 25%;
    padding: 1px;
}
.stats-left h4 {
    font-size: 1.5em;
    color: #fff;
    margin-top: 10px;
}
.calendar {
    display: flex;
    flex-flow: column;
}
.calendar .header .month-year {
    font-size: 20px;
    font-weight: bold;
    color: #636e73;
    padding: 20px 0;
}
.calendar .days {
    display: flex;
    flex-flow: wrap;
}
.calendar .days .day_name {
    width: calc(100% / 7);
    border-right: 1px solid #2c7aca;
    padding: 20px;
    text-transform: uppercase;
    font-size: 12px;
    font-weight: bold;
    color: #818589;
    color: #fff;
    background-color: #448cd6;
}
.calendar .days .day_name:nth-child(7) {
    border: none;
}
.calendar .days .day_num {
    display: flex;
    flex-flow: column;
    width: calc(100% / 7);
    border-right: 1px solid #e6e9ea;
    border-bottom: 1px solid #e6e9ea;
    padding: 15px;
    font-weight: bold;
    color: #7c878d;
    cursor: pointer;
    min-height: 100px;
}
.calendar .days .day_num span {
    display: inline-flex;
    width: 30px;
    font-size: 14px;
}
.calendar .days .day_num .event {
    margin-top: 10px;
    font-weight: 500;
    font-size: 14px;
    padding: 3px 6px;
    border-radius: 4px;
    background-color: #f7c30d;
    color: #fff;
    word-wrap: break-word;
}
.calendar .days .day_num .event.green {
    background-color: #51ce57;
}
.calendar .days .day_num .event.blue {
    background-color: #518fce;
}
.calendar .days .day_num .event.red {
    background-color: #ce5151;
}
.calendar .days .day_num:nth-child(7n+1) {
    border-left: 1px solid #e6e9ea;
}
.calendar .days .day_num:hover {
    background-color: #fdfdfd;
}
.calendar .days .day_num.ignore {
    background-color: #fdfdfd;
    color: #ced2d4;
    cursor: inherit;
}
.calendar .days .day_num.selected {
    background-color: #f1f2f3;
    cursor: inherit;
}
</style>
</head> 
<body class="cbp-spmenu-push">
<div class="main-content">
		
		 <?php include_once('includes/sidebar.php');?>
		
	<?php include_once('includes/header.php');?>
	<style>
	.widget {
		text-align:center
	}
	</style>
		<!-- main content start-->
		<div id="page-wrapper" class="row calender widget-shadow">
			<div class="main-page">
				
				<div class="row calender widget-shadow">
					<div class="row-one">
						<div class="col-md-3 " style='text-align:left'>
									<h3 style='text-align:left'>Staff</h3>
							</div>
							<div class="col-md-3 ">
								<h3>Today</h3>
							</div>
							<div class="col-md-3 ">
								<h3>This Month</h3>
							</div>
							<div class="col-md-3 ">
								<h3>Financial Year</h3>
							</div>
					</div><br />
					<div class="row-one">
					
					<div class="col-md-3  ">
						<h3>Total Bills </h3>
					</div>
						
					<div class="col-md-3 ">
						<div class="col-md-6 ">
<?php $query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(total_amount),'0.00') as total_amount  FROM saloon_sale_transaction WHERE bill_type='S' and date(transaction_date) between date(now()) and date(now())");
	$row = mysqli_fetch_assoc($query1);
?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
<div class="col-md-3 ">
						<div class="col-md-6 ">
<?php $query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(total_amount),'0.00') as total_amount  FROM saloon_sale_transaction WHERE bill_type='S' and month(transaction_date) between month(now()) and month(now())");
	$row = mysqli_fetch_assoc($query1);
?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
						
					<div class="col-md-3 ">
						<div class="col-md-6 ">
						
<?php 
$query1 = "";
$getcuremnth = "SELECT month(now()) as month";
$result2 = mysqli_query($con,$getcuremnth);
if($result2 ){
	$row2 = mysqli_fetch_assoc($result2);
		$MN = $row2['month'];
		error_log($MN);
	if($MN <= 3) {
		$query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(total_amount),'0.00') as total_amount  FROM saloon_sale_transaction WHERE bill_type='S' and date(transaction_date) between CONCAT(YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)),'-03','-01') and CONCAT(YEAR(CURDATE()),'-03','-31')");
	}
	else {
		$query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(total_amount),'0.00') as total_amount  FROM saloon_sale_transaction WHERE bill_type='S' and date(transaction_date) between CONCAT(YEAR(CURDATE()),'-04','-01') and  CONCAT(YEAR(DATE_ADD(CURDATE(), INTERVAL 1 YEAR)),'-03','-31') ");
	}
	error_log($query1);

$row = mysqli_fetch_assoc($query1);
}


?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
				</div>	
				
				
				
			<div class="row-one">
					
					<div class="col-md-3  ">
						<h3>Male Clients</h3>
					</div>
						
					<div class="col-md-3 ">
						<div class="col-md-6 ">
<?php $query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='S' and b.gender = 'Male' and date(a.transaction_date) between date(now()) and date(now())");
	$row = mysqli_fetch_assoc($query1);
?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
<div class="col-md-3 ">
						<div class="col-md-6 ">
<?php $query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='S' and b.gender = 'Male' and month(a.transaction_date) between month(now()) and month(now())");
	$row = mysqli_fetch_assoc($query1);
?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
						
					<div class="col-md-3 ">
						<div class="col-md-6 ">
						
<?php 
$query1 = "";
$getcuremnth = "SELECT month(now()) as month";
$result2 = mysqli_query($con,$getcuremnth);
if($result2 ){
	$row2 = mysqli_fetch_assoc($result2);
		$MN = $row2['month'];
		error_log($MN);
	if($MN <= 3) {
		$query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='S' and b.gender = 'Male' and date(a.transaction_date) between CONCAT(YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)),'-03','-01') and CONCAT(YEAR(CURDATE()),'-03','-31')");
	}
	else {
		$query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='S' and b.gender = 'Male' and date(a.transaction_date) between CONCAT(YEAR(CURDATE()),'-04','-01') and  CONCAT(YEAR(DATE_ADD(CURDATE(), INTERVAL 1 YEAR)),'-03','-31') ");
	}
	error_log($query1);

$row = mysqli_fetch_assoc($query1);
}


?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
				</div>	
				
				
				
					<div class="row-one">
					
					<div class="col-md-3  ">
						<h3>FeMale Clients</h3>
					</div>
						
					<div class="col-md-3 ">
						<div class="col-md-6 ">
<?php $query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='S' and b.gender = 'Female' and date(a.transaction_date) between date(now()) and date(now())");
	$row = mysqli_fetch_assoc($query1);
?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
<div class="col-md-3 ">
						<div class="col-md-6 ">
<?php $query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='S' and b.gender = 'Female' and month(a.transaction_date) between month(now()) and month(now())");
	$row = mysqli_fetch_assoc($query1);
?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
						
					<div class="col-md-3 ">
						<div class="col-md-6 ">
						
<?php 
$query1 = "";
$getcuremnth = "SELECT month(now()) as month";
$result2 = mysqli_query($con,$getcuremnth);
if($result2 ){
	$row2 = mysqli_fetch_assoc($result2);
		$MN = $row2['month'];
		error_log($MN);
	if($MN <= 3) {
		$query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='S' and b.gender = 'Female' and date(a.transaction_date) between CONCAT(YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)),'-03','-01') and CONCAT(YEAR(CURDATE()),'-03','-31')");
	}
	else {
		$query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='S' and b.gender = 'Female' and date(a.transaction_date) between CONCAT(YEAR(CURDATE()),'-04','-01') and  CONCAT(YEAR(DATE_ADD(CURDATE(), INTERVAL 1 YEAR)),'-03','-31') ");
	}
	error_log($query1);

$row = mysqli_fetch_assoc($query1);
}


?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
					
					
				</div>	
				
				
				<div class="row-one">
						<h3 style='text-align:left'>Customer</h3><br />
					</div>
					<div class="row-one">
					
					<div class="col-md-3  ">
						<h3>Total Bills </h3>
					</div>
						
					<div class="col-md-3 ">
						<div class="col-md-6 ">
<?php $query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(total_amount),'0.00') as total_amount  FROM saloon_sale_transaction WHERE bill_type='C' and date(transaction_date) between date(now()) and date(now())");
	$row = mysqli_fetch_assoc($query1);
?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
<div class="col-md-3 ">
						<div class="col-md-6 ">
<?php $query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(total_amount),'0.00') as total_amount  FROM saloon_sale_transaction WHERE bill_type='C' and month(transaction_date) between month(now()) and month(now())");
	$row = mysqli_fetch_assoc($query1);
?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
						
					<div class="col-md-3 ">
						<div class="col-md-6 ">
						
<?php 
$query1 = "";
$getcuremnth = "SELECT month(now()) as month";
$result2 = mysqli_query($con,$getcuremnth);
if($result2 ){
	$row2 = mysqli_fetch_assoc($result2);
		$MN = $row2['month'];
		error_log($MN);
	if($MN <= 3) {
		$query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(total_amount),'0.00') as total_amount  FROM saloon_sale_transaction WHERE bill_type='C' and date(transaction_date) between CONCAT(YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)),'-03','-01') and CONCAT(YEAR(CURDATE()),'-03','-31')");
	}
	else {
		$query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(total_amount),'0.00') as total_amount  FROM saloon_sale_transaction WHERE bill_type='C' and date(transaction_date) between CONCAT(YEAR(CURDATE()),'-04','-01') and  CONCAT(YEAR(DATE_ADD(CURDATE(), INTERVAL 1 YEAR)),'-03','-31') ");
	}
	error_log($query1);

$row = mysqli_fetch_assoc($query1);
}


?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
				</div>	
				
				
				
			<div class="row-one">
					
					<div class="col-md-3  ">
						<h3>Male Clients</h3>
					</div>
						
					<div class="col-md-3 ">
						<div class="col-md-6 ">
<?php $query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='C' and b.gender = 'Male' and date(a.transaction_date) between date(now()) and date(now())");
	$row = mysqli_fetch_assoc($query1);
?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
<div class="col-md-3 ">
						<div class="col-md-6 ">
<?php $query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='C' and b.gender = 'Male' and month(a.transaction_date) between month(now()) and month(now())");
	$row = mysqli_fetch_assoc($query1);
?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
						
					<div class="col-md-3 ">
						<div class="col-md-6 ">
						
<?php 
$query1 = "";
$getcuremnth = "SELECT month(now()) as month";
$result2 = mysqli_query($con,$getcuremnth);
if($result2 ){
	$row2 = mysqli_fetch_assoc($result2);
		$MN = $row2['month'];
		error_log($MN);
	if($MN <= 3) {
		$query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='C' and b.gender = 'Male' and date(a.transaction_date) between CONCAT(YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)),'-03','-01') and CONCAT(YEAR(CURDATE()),'-03','-31')");
	}
	else {
		$query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='C' and b.gender = 'Male' and date(a.transaction_date) between CONCAT(YEAR(CURDATE()),'-04','-01') and  CONCAT(YEAR(DATE_ADD(CURDATE(), INTERVAL 1 YEAR)),'-03','-31') ");
	}
	error_log($query1);

$row = mysqli_fetch_assoc($query1);
}


?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
				</div>	
				
				
				
					<div class="row-one">
					
					<div class="col-md-3  ">
						<h3>FeMale Clients</h3>
					</div>
						
					<div class="col-md-3 ">
						<div class="col-md-6 ">
<?php $query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='C' and b.gender = 'Female' and date(a.transaction_date) between date(now()) and date(now())");
	$row = mysqli_fetch_assoc($query1);
?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
<div class="col-md-3 ">
						<div class="col-md-6 ">
<?php $query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='C' and b.gender = 'Female' and month(a.transaction_date) between month(now()) and month(now())");
	$row = mysqli_fetch_assoc($query1);
?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
						
					<div class="col-md-3 ">
						<div class="col-md-6 ">
						
<?php 
$query1 = "";
$getcuremnth = "SELECT month(now()) as month";
$result2 = mysqli_query($con,$getcuremnth);
if($result2 ){
	$row2 = mysqli_fetch_assoc($result2);
		$MN = $row2['month'];
		error_log($MN);
	if($MN <= 3) {
		$query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='C' and b.gender = 'Female' and date(a.transaction_date) between CONCAT(YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)),'-03','-01') and CONCAT(YEAR(CURDATE()),'-03','-31')");
	}
	else {
		$query1=mysqli_query($con,"SELECT count(*) as count,IFNULL(SUM(a.total_amount),'0.00') as total_amount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and a.bill_type='C' and b.gender = 'Female' and date(a.transaction_date) between CONCAT(YEAR(CURDATE()),'-04','-01') and  CONCAT(YEAR(DATE_ADD(CURDATE(), INTERVAL 1 YEAR)),'-03','-31') ");
	}
	error_log($query1);

$row = mysqli_fetch_assoc($query1);
}


?>
						<div class="stats-left ">
							<h5>No Of Bills</h5>
							<h4><?php echo $row['count'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
							<div class="col-md-6 ">
						<div class="stats-left ">
							<h5>Value</h5>
							<h4><?php echo  $row['total_amount'];?></h4>
						</div>
						
						<div class="clearfix"> </div>	
					</div>
					
					</div>
				</div>	
				
					
						
						
						<div class="clearfix"> </div>	
						
						
						

					</div>
					<div class="content home">
			<?=$calendar?>
		</div>
					<div class="clearfix"> </div>	
				</div>
						
					</div>
				</div>
				<div class="clearfix"> </div>
				
			</div>
			
		</div>
		   
		<!--footer-->
		<?php include_once('includes/footer.php');?>
        <!--//footer-->
	</div>
	<!-- Classie -->
		<script src="js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			

			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
	<!--scrolling js-->
	
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.js"> </script>
   	<script src="js/jquery.nicescroll.js"></script>
</body>
</html>