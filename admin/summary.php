<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['naturalsaid']==0)) {
  header('location:logout.php');
  } else{


  ?>


<!DOCTYPE HTML>
<html>
<head>
<title>Naturals | SUMMARY</title>

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
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!-- Metis Menu -->
  <link rel="stylesheet" href="css/jquery.dataTables.min.css">
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<style>
td, th {
	text-align:center;
}
</style>
<!--//Metis Menu -->
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<!--left-fixed -navigation-->
		 <?php include_once('includes/sidebar.php');?>
		<!--left-fixed -navigation-->
		<!-- header-starts -->
	 <?php include_once('includes/header.php');?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="forms">
				
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>MANAGE  SUMMARY:</h4>
						</div>
						<table class="table">
							<thead>
								<tr>
								<?php $query1 = "SELECT IFNULL(SUM(total_amount),0) as cashtotal, count(*) as count  FROM saloon_sale_transaction  WHERE  date(transaction_date) between date(now()) and date(now())";
$result1 = mysqli_query($con, $query1 );
$row1 = mysqli_fetch_assoc($result1);
$cashtotal  = "";
$corow = mysqli_num_rows($result1);
if($corow > 0) {
	$cashtotal = $row1['cashtotal'];
	$count1 = $row1['count'];
	
	if(!$result) {
		error_log($query);
		echo mysqli_error($con);
	}
	else {

	}
	
}
else {
	$cashtotal = 0;
	$count1 = 0;
}


?>
									<th style='text-align:right'>Total Amount: <?php echo $cashtotal ?></th>
									<th>Total No Of BILLS:  <?php echo $count1 ?></th>
								</tr>
							</thead>
						</table>
						
<table class="table">
<thead>
	<tr>
		<th></th>
		<th>Customer</th>
		<th>Customer No of Bills	</th>
		<th>Staff</th>
		<th>Staff No Bills	</th>
		<th>Total	</th>
	</tr>
</thead> 
 <tbody>
    <tr>
      <th>Cash Collection Value & No</th>
      <td><?php $query1 = "SELECT IFNULL(SUM(a.total_amount),0) as cashtotal, count(*) as count1  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and date(a.transaction_date) between date(now()) and date(now()) and a.payment_mode = 'CI' and a.bill_type = 'C' GROUP BY bill_type";
$result1 = mysqli_query($con, $query1 );
$row1 = mysqli_fetch_assoc($result1);
$cusCashCollectionvale  = "";
$corow = mysqli_num_rows($result1);
if($corow > 0) {
	$cusCashCollectionvale = $row1['cashtotal'];
	$count1 = $row1['count1'];
	
	if(!$result) {
		error_log($query);
		echo mysqli_error($con);
	}
	else {

	}
	
}
else {
	$cusCashCollectionvale = 0;
	$count1 = 0;
}

echo $cusCashCollectionvale;
?></td>
      <td><?php echo $count1;?></td>
      <td><?php $query1 = " SELECT IFNULL(SUM(a.total_amount),0) as cashtotal, count(*) as count1  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and date(a.transaction_date) between date(now()) and date(now()) and a.payment_mode = 'CI' and a.bill_type = 'S' GROUP BY bill_type";
$result1 = mysqli_query($con, $query1 );
$row1 = mysqli_fetch_assoc($result1);
$cusCashCollectionvale2 = 0;
$corow = mysqli_num_rows($result1);
if($corow > 0) {
$cusCashCollectionvale2 = $row1['cashtotal'];
$count1 = $row1['count1'];

if(!$result) {
	error_log($query);
	echo mysqli_error($con);
}

}
else {
	$cusCashCollectionvale2 = 0;
}

echo $cusCashCollectionvale2;


?></td>
<td><?php echo $count1 ?></td>
<td><?php echo number_format($cusCashCollectionvale + $cusCashCollectionvale2,2) ?></td>
    </tr>
      <tr>
      <th>Card Collection Value & No</th>
      <td><?php $query1 = " SELECT IFNULL(SUM(a.total_amount),0) as cashtotal, count(*) as count1  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and date(a.transaction_date) between date(now()) and date(now()) and a.payment_mode = 'CA' and a.bill_type = 'C' GROUP BY bill_type";
$result1 = mysqli_query($con, $query1 );
$row1 = mysqli_fetch_assoc($result1);
$cusCashCollectionvale = 0;
$corow = mysqli_num_rows($result1);
if($corow > 0) {
	$cusCashCollectionvale = $row1['cashtotal'];
	$count1 = $row1['count1'];
	echo $cusCashCollectionvale;
	
}
else {
	$cusCashCollectionvale = 0;
	echo $cusCashCollectionvale ;
	$count1 = 0;
}
if(!$result) {
	error_log($query);
	echo mysqli_error($con);
}?></td>
      <td><?php echo $count1;?></td>
      <td><?php $query1 = " SELECT IFNULL(SUM(a.total_amount),0) as cashtotal, count(*) as count1  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and date(a.transaction_date) between date(now()) and date(now()) and a.payment_mode = 'CA' and a.bill_type = 'S' GROUP BY bill_type";
$result1 = mysqli_query($con, $query1 );
$cusCashCollectionvale2 = "";
$row1 = mysqli_fetch_assoc($result1);
$cusCashCollectionvale2 = $row1['cashtotal'];

$count1 = $row1['count1'];
$corow = mysqli_num_rows($result1);
if($corow > 0) {
	echo $cusCashCollectionvale2;
	//$count1  = 0;
}
else {
	 $cusCashCollectionvale2 = 0;
	echo $cusCashCollectionvale2;
	$count1  = 0;
}
if(!$result) {
	error_log($query);
	echo mysqli_error($con);
}?></td>
<td><?php echo $count1 ?></td>
<td><?php echo number_format($cusCashCollectionvale + $cusCashCollectionvale2,2) ?></td>
    </tr>
    <tr>
      <th>Total No Male Bills (Customer)	</th>
      <td><?php $query1 = "SELECT IFNULL(SUM(a.total_amount),0) as cashtotal,  count(*) as tocount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and date(a.transaction_date) between date(now()) and date(now()) and b.gender = 'Male' and a.bill_type = 'C' GROUP BY bill_type";
$result1 = mysqli_query($con, $query1 );
$cusCashCollectionvale2 = "";
$row1 = mysqli_fetch_assoc($result1);

$cashtotals = $row1['cashtotal'];

$corow = mysqli_num_rows($result1);
if($corow > 0) {
	$tocount = $row1['tocount'];
	//$tocount  = 0;
}
else {
	$tocount  = 0;
	 $cashtotals = 0;
}
if(!$result) {
	error_log($query);
	echo mysqli_error($con);
}echo $cashtotals;?></td>
      <td><?php echo $tocount ?></td>
       <td><?php $query1 = "SELECT  IFNULL(SUM(a.total_amount),0) as cashtotal,count(*) as tocount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and date(a.transaction_date) between date(now()) and date(now()) and b.gender = 'Male' and a.bill_type = 'S' GROUP BY bill_type";
$result1 = mysqli_query($con, $query1 );
$cusCashCollectionvale2 = "";
$row1 = mysqli_fetch_assoc($result1);


$corow = mysqli_num_rows($result1);
if($corow > 0) {
	$tocount2 = $row1['tocount'];
	$cashtotalc = $row1['cashtotal'];
	//$tocount  = 0;
}
else {
	$tocount2  = 0;
	$cashtotalc  = 0;
}
if(!$result) {
	error_log($query);
	echo mysqli_error($con);
}echo $cashtotalc ;?></td>
 <td><?php echo $tocount2 ?></td>
<td><?php echo number_format($cashtotals + $cashtotalc,2) ?></td>
    </tr>
        <tr>
      <th>Total No Female Bills (Customer)	</th>
       <td><?php $query1 = "SELECT IFNULL(SUM(a.total_amount),0) as cashtotal, count(*) as tocount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and date(a.transaction_date) between date(now()) and date(now()) and b.gender = 'Female' and a.bill_type = 'C' GROUP BY bill_type";
$result1 = mysqli_query($con, $query1 );
$cusCashCollectionvale2 = "";
$row1 = mysqli_fetch_assoc($result1);

$cashtotalfe = $row1['cashtotal'];
$corow = mysqli_num_rows($result1);
if($corow > 0) {
	$tocount = $row1['tocount'];
	
	//$tocount  = 0;
}
else {
	$tocount  = 0;
	 $cashtotalfe = 0;
}
if(!$result) {
	error_log($query);
	echo mysqli_error($con);
}echo $cashtotalfe;?></td>
      <td><?php echo $tocount ?></td>
       <td><?php $query1 = "SELECT IFNULL(SUM(a.total_amount),0) as cashtotal,  count(*) as tocount  FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID and date(a.transaction_date) between date(now()) and date(now()) and b.gender = 'Female' and a.bill_type = 'S' GROUP BY bill_type";
$result1 = mysqli_query($con, $query1 );
$cusCashCollectionvale2 = "";
$row1 = mysqli_fetch_assoc($result1);
$cashtotalfm = $row1['cashtotal'];

$corow = mysqli_num_rows($result1);
if($corow > 0) {
	$tocount2 = $row1['tocount'];
	//$tocount  = 0;
}
else {
	$tocount2  = 0;
	 $cashtotalfm = 0;
}
if(!$result) {
	error_log($query);
	echo mysqli_error($con);
}echo $cashtotalfm;?></td>
 <td><?php echo $tocount2 ?></td>
<td><?php echo number_format($cashtotalfe + $cashtotalfm,2) ?></td>
    </tr>
	
	
	
	     <tr>
      <th>Total Service of Male Bills		</th>
       <td><?php $query1 = "SELECT count(*) as tocount FROM saloon_sale_service_cart a , saloon_employee b, saloon_sale_transaction c WHERE c.invoice_no =a.cart_invoice_no and  a.employee_id = b.ID and date(c.transaction_date) between date(now()) and date(now()) and b.gender = 'Male' and c.bill_type = 'C'";
$result1 = mysqli_query($con, $query1 );
$cusCashCollectionvale2 = "";
$row1 = mysqli_fetch_assoc($result1);


$corow = mysqli_num_rows($result1);
if($corow > 0) {
	$tocount = $row1['tocount'];
	//$tocount  = 0;
	$count = $row1['count'];
}
else {
	$tocount  = 0;
	$count  = 0;
}
if(!$result) {
	error_log($query);
	echo mysqli_error($con);
}echo $tocount;?></td>
      <td><?php echo $tocount ?></td>
      <td><?php $query1 = "SELECT count(*) as tocount FROM saloon_sale_service_cart a , saloon_employee b, saloon_sale_transaction c WHERE c.invoice_no =a.cart_invoice_no and  a.employee_id = b.ID and date(c.transaction_date) between date(now()) and date(now()) and b.gender = 'Male' and c.bill_type = 'S'";
$result1 = mysqli_query($con, $query1 );
$cusCashCollectionvale2 = "";
$row1 = mysqli_fetch_assoc($result1);


$corow = mysqli_num_rows($result1);
if($corow > 0) {
	$tocount2 = $row1['tocount'];
	//$tocount  = 0;
}
else {
	$tocount2  = 0;
}
if(!$result) {
	error_log($query);
	echo mysqli_error($con);
}echo $tocount2;?></td>
 <td><?php echo $tocount2 ?></td>
<td><?php echo number_format($tocount2 + $tocount,2) ?></td>
    </tr>
	
	
		     <tr>
      <th>Total Service of FeMale Bills		</th>
       <td><?php $query1 = "SELECT count(*) as tocount FROM saloon_sale_service_cart a , saloon_employee b, saloon_sale_transaction c WHERE c.invoice_no =a.cart_invoice_no and  a.employee_id = b.ID and date(c.transaction_date) between date(now()) and date(now()) and b.gender = 'FeMale' and c.bill_type = 'C'";
$result1 = mysqli_query($con, $query1 );
$cusCashCollectionvale2 = "";
$row1 = mysqli_fetch_assoc($result1);


$corow = mysqli_num_rows($result1);
if($corow > 0) {
	$tocount = $row1['tocount'];
	//$tocount  = 0;
	$count = $row1['count'];
}
else {
	$tocount  = 0;
	$count  = 0;
}
if(!$result) {
	error_log($query);
	echo mysqli_error($con);
}echo $tocount;?></td>
      <td><?php echo $tocount ?></td>
      <td><?php $query1 = "SELECT count(*) as tocount FROM saloon_sale_service_cart a , saloon_employee b, saloon_sale_transaction c WHERE c.invoice_no =a.cart_invoice_no and  a.employee_id = b.ID and date(c.transaction_date) between date(now()) and date(now()) and b.gender = 'FeMale' and c.bill_type = 'S'";
$result1 = mysqli_query($con, $query1 );
$cusCashCollectionvale2 = "";
$row1 = mysqli_fetch_assoc($result1);


$corow = mysqli_num_rows($result1);
if($corow > 0) {
	$tocount2 = $row1['tocount'];
	//$tocount  = 0;
}
else {
	$tocount2  = 0;
}
if(!$result) {
	error_log($query);
	echo mysqli_error($con);
}echo $tocount2;?></td>
 <td><?php echo $tocount2 ?></td>
<td><?php echo number_format($tocount2 + $tocount,2) ?></td>
    </tr>
  </tbody>
</table>
			
			
		</div>
		 <?php include_once('includes/footer.php');?>
	</div>
	<!-- Classie -->
		<script src="js/classie.js"></script>
			<script>
		
			function loadtab() {
				
				
				var dataString = "action=load";
				$.ajax({
					type: 'POST',
					url: 'ajax/staffajax.php',
					timeout: 100000,
					data:dataString,	
					success: function(server_response){
						$("#tabletable").html(server_response);
						$('#table').DataTable( {
							 paging: true,
							  ordering: true,
        dom: 'Bfrtip',
         buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
	$(".dt-button").addClass('btn btn-primary');
	$(".dt-buttons").css('text-align','center');
	$(".dt-buttons").css('margin-top','-7.5%');
	$(".dataTables_filter").css('margin-top','-4%');
	$(".dataTables_filter").css('margin-bottom','4%');
	
						
						},
					error: function(xhr, status, error) {
						if(status === "timeout") {
							alert("<p>TimeOut error Please Try After some time</P>");
						} else {
						   alert("<p>"+xhr.responseText+"</p>");
						}
					}
				});
			}
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
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.js"> </script>
   		 <script src="js/jquery.dataTables.min.js"></script>
 <script src="js/dataTables.buttons.min.js"></script>
 <script src="js/buttons.flash.min.js"></script>
 <script src="js/jszip.min.js"></script>
 <script src="js/pdfmake.min.js"></script>
 <script src="js/vfs_fonts.js"></script>
 <script src="js/buttons.html5.min.js"></script>
 <script src="js/buttons.print.min.js"></script>
	
</body>
</html>
<?php } ?>