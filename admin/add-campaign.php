<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['naturalsaid']==0)) {
  header('location:logout.php');
  } else{

if(isset($_POST['submit']))
  {
    $name=$_POST['name'];
    $discountfactor=$_POST['discountfactor'];
    $discount=$_POST['discount'];
    $sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$details = $_POST['details'];
	$active = $_POST['active'];
     $Qy = "insert into  saloon_campaign(name,active,discount_factor,discount,start_date, end_date,detail, create_time) 
							value('$name','$active','$discountfactor', $discount,'$sdate','$edate', '$details',now())";
	 error_log($Qy);
	$query=mysqli_query($con, $Qy );
    if ($query) {
echo "<script>alert('CAMPAIGN has been added.');</script>"; 
echo "<script>window.location.href = 'add-campaign.php'</script>"; 
 } else {
echo "<script>alert('Something Went Wrong. Please try again.');</script>";  	
} }
  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>naturals | Add CAMPAIGN</title>

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
					<h3 class="title1">Add Campaign</h3>
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Parlour Campaign:</h4>
						</div>
						<div class="form-body">
							<form method="post">
								<p style="font-size:16px; color:red" align="center"> <?php if($msg){
    echo $msg;
  }  ?> </p>

  
							<div class='row'>
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									<div class="form-group"> <label for="exampleInputEmail1">Name</label> 
										<input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="" required="true"> 
									</div>
								</div>
								
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									<div class="form-group"> <label for="exampleInputPassword1">Active</label> 
										<select class='form-control' name='active' id='Active' required='true'>
											<option value='Y'>Y - Yes</option>
											<option value='N'>N - No</option>
										</select>
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
										<input type="text" class="form-control" id="discount" name="discount" placeholder="Discount" value="" required="true" maxlength="10" pattern="[0-9]+"> 
									 </div>
								</div>
								
								
							</div>
							
							<div class='row'>
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									<div class="form-group"> <label for="exampleInputPassword1">Start Date</label> 
										<input type="date" id="date" name="sdate" class="form-control" placeholder="Start Date" value="" required="true"> 
									</div>
								</div>	
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									<div class="form-group"> <label for="exampleInputPassword1">End Date</label> 
										<input type="date" id="adate" name="edate" class="form-control" placeholder="End Date" value="" required="true">
									</div>
								</div>
							</div>

							 <div class='row'>
								<div class='col-lg-12 col-sm-12 col-md-12 '>
									<div class="form-group"> <label for="exampleInputEmail1">Details</label> <textarea type="text" class="form-control" id="details" name="details" placeholder="Details" required="true" rows="4" cols="4"></textarea> </div>
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