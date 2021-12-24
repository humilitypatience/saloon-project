<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['naturalsaid']==0)) {
  header('location:logout.php');
  } else{

if(isset($_POST['submit']))
  {
    $sername=$_POST['sername'];
    $cost=$_POST['cost'];
	$cgst = $_POST['cgst'];
	$sgst = $_POST['sgst'];
	$sgst = $_POST['sgst'];
	$discountfactor = $_POST['discountfactor'];
   $amount=$_POST['amount'];
	$amountfactor = $_POST['amountfactor'];
	$active = $_POST['active'];
    $discount = $_POST['discount'];
	$cats = $_POST['cats'];
	$nonmembercost =  $_POST['nonmembercost'];
	$query = "INSERT INTO tblservices(member_cost, ServiceName,Cost, cgst, sgst, discount, discount_factor, create_time, categories_id, active) 
												VALUE($nonmembercost,'$sername','$cost', $cgst, $sgst, '$discount','$discountfactor',now(),$cats,'$active')";
	error_log($query);
    $result=mysqli_query($con, $query);
    if ($result) {
		$service = mysqli_insert_id($con);
		$query = "INSERT INTO incentive_mapping(service_id, rate, amount_factor, active, create_time) 
												VALUE($service,'$amount','$amountfactor','$active',now())";
		error_log($query);
		$result=mysqli_query($con, $query);
		 if ($result) {
			echo "<script>alert('Service has been added.');</script>"; 
    		echo "<script>window.location.href = 'add-services.php'</script>";   
			$msg="";
		 }
		 else {
			   echo "<script>alert('Something Went Wrong... Please try again.');</script>";  	
		 }
  }
  else
    {
    echo "<script>alert('Something Went Wrong. Please try again.');</script>";  	
    }

  
}
  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>Naturals | Add Services</title>

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
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
<style>
.row {
	margin:0.2em 0 0;
}
.form-title {
    padding: 0em 2em;
    background-color: #EAEAEA;
    border-bottom: 1px solid #D6D5D5;
}
.form-body {
    padding: 0.5em 2em;
}
</style>
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
							<h4>Parlour Services:</h4>
						</div>
						<div class="form-body">
							<form method="post">
								<p style="font-size:16px; color:red" align="center"> <?php if($msg){
    echo $msg;
  }  ?> </p>

							<div class='row'>
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									 <div class="form-group"> 
										 <label for="exampleInputEmail1">Service Name</label> 
										<input type="text" class="form-control" id="sername" name="sername" placeholder="Service Name" value="" required="true"> 
									</div> 
								</div>
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									 <div class="form-group"> 
										 <label for="exampleInputEmail1">Categories</label> 
										<div id='CATDiv'>
								</div>
									</div> 
								</div>
								
							</div>
							<div class='row'>
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									 <div class="form-group"> 
										<label for="exampleInputPassword1">Non-Member Cost</label>
											<input type="text" id="cost" name="cost" class="form-control" placeholder="Cost" value="0.00" required="true"> 
									</div>
								</div>
								
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									 <div class="form-group"> 
										<label for="exampleInputPassword1">Member Cost</label>
											<input type="text" id="nonmembercost" name="nonmembercost" class="form-control" placeholder="Enter Non Member Cost" value="0.00" required="true"> 
									</div>
								</div>
							</div>
							<div class='row'>
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									 <div class="form-group"> 
										 <label for="exampleInputEmail1">CGST</label> 
										<div id='CGTSDiv'>
								</div>
									</div> 
								</div>
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									 <div class="form-group"> 
										<label for="exampleInputPassword1">SGST</label>
											<div id='SGSTDiv'>
								</div>
									</div>
								</div>
							</div>
							
							<div class='row'>							
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									<div class="radio">
									   <p style="padding-top: 20px; font-size: 15px"> <strong>Discount Factor:</strong> <label>
											<input type="radio" name="discountfactor" id="discountfactor" value="P" checked="true">
											Percentage
										</label>
										<label>
											<input type="radio" name="discountfactor" id="discountfactor" value="A">
											Amount
										</label>
										
										</p>
									</div>
								</div>
								<div class='col-lg-6 col-sm-12 col-md-12 '>																
									 <div class="form-group"> <label for="exampleInputEmail1">Discount</label> 
										<input type="text" class="form-control" id="discount" name="discount" placeholder="Discount" value="0" required="true" maxlength="10" pattern="[0-9]+"> 
									 </div>
								</div>
								
								
							</div>
							
							<div class='row'>							
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									<div class="radio">
									   <p style="padding-top: 20px; font-size: 15px"> <strong>Incentive Amount Factor:</strong> <label>
											<input type="radio" name="amountfactor" id="amountfactor" value="P" checked="true">
											Percentage
										</label>
										<label>
											<input type="radio" name="amountfactor" id="amountfactor" value="A">
											Amount
										</label>
										
										</p>
									</div>
								</div>
								<div class='col-lg-6 col-sm-12 col-md-12 '>																
									 <div class="form-group"> <label for="exampleInputEmail1">Incentive Amount</label> 
										<input type="text" class="form-control" id="amount" name="amount"  onkeyup="NumAndTwoDecimals(event , this);" placeholder="amount" value="0" required="true" maxlength="10" pattern="[0-9]+"> 
									 </div>
								</div>
								
								
							</div>
							<div class='row'>	
							
							<div class='col-lg-12 col-sm-12 col-md-12 '>
									<div class="form-group"> <label for="exampleInputPassword1">Active</label> 
										<select class='form-control' name='active' id='active'>
											<option value='Y'>Yes</option>
											<option value='N'>No</option>
										</select>
									</div>
								</div>	
							</div>
							  <button type="submit" name="submit" class="btn btn-default">Add</button> </form> 
						</div>
						
					</div>
				
				
			</div>
		</div>
		 <?php include_once('includes/footer.php');?>
	</div>
	<!-- Classie -->
		<script src="js/classie.js"></script>
		<script>
		
		loadgst();loadcat();
			function loadgst() {				
				var dataString = "action=loadgst";
				$.ajax({
					type: 'POST',
					url: 'ajax/load.php',
					timeout: 100000,
					data:dataString,	
					success: function(server_response){
						var sp = server_response.split("[BRK]");
						//alert(sp);
						//alert(sp[0]);	alert(sp[1]);
						$("#CGTSDiv").html(sp[0]);
						$("#SGSTDiv").html(sp[1]);
						$("#CGSTDropDown").select2();
						$("#SGSTDropDown").select2();
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
			function loadcat() {				
				var dataString = "action=loadcat";
				$.ajax({
					type: 'POST',
					url: 'ajax/load.php',
					timeout: 100000,
					data:dataString,	
					success: function(server_response){
						var sp = server_response.split("[BRK]");
						//alert(sp);
						//alert(sp[0]);	alert(sp[1]);
						$("#CATDiv").html(sp[0]);
						$("#CATDropDown").select2();
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
</body>
</html>
<?php } ?>