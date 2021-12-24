<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['naturalsaid']==0)) {
  header('location:logout.php');
  } else{

if(isset($_POST['submit']))
  {
    $service=$_POST['service'];
    $amount=$_POST['amount'];
	$amountfactor = $_POST['amountfactor'];
	$active = $_POST['active'];
	$query = "INSERT INTO incentive_mapping(service_id, rate, amount_factor, active, create_time) 
												VALUE($service,'$amount','$amountfactor','$active',now())";
	error_log($query);
    $result=mysqli_query($con, $query);
    if ($result) {
    	echo "<script>alert('Incentive Rate has been added.');</script>"; 
    		echo "<script>window.location.href = 'incentive.php'</script>";   
    $msg="";
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
<link href="css/select2.min.css" rel="stylesheet" /> 
<script src="js/select2.min.js"></script>
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
					
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Incentive Mapping:</h4>
						</div>
						<div class="form-body">
							<form method="post">
								<p style="font-size:16px; color:red" align="center"> <?php if($msg){
    echo $msg;
  }  ?> </p>

							<div class='row'>
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									 <div class="form-group"> 
										
										<div id='SerDiv'>
								
										</div>
									</div> 
								</div>
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									<div class="form-group"> <label for="exampleInputPassword1">Active</label> 
										<select class='form-control' name='active' id='active'>
											<option value='Y'>Yes</option>
											<option value='N'>No</option>
										</select>
									</div>
								</div>	
								
							</div>
							
							
							
							<div class='row'>							
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									<div class="radio">
									   <p style="padding-top: 20px; font-size: 15px"> <strong>Amount Factor:</strong> <label>
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
									 <div class="form-group"> <label for="exampleInputEmail1">Amount</label> 
										<input type="text" class="form-control" id="amount" name="amount"  onkeyup="NumAndTwoDecimals(event , this);" placeholder="amount" value="0" required="true" maxlength="10" pattern="[0-9]+"> 
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
			 loadser();
			function loadser() {				
				var dataString = "action=loadservices";
				$.ajax({
					type: 'POST',
					url: 'ajax/load.php',
					timeout: 100000,
					data:dataString,	
					success: function(server_response){
						$("#SerDiv").html(server_response);
						$("#ServiceDropDown").select2();
					},
					error: function(xhr, status, error) {
						if(status === "timeout") {
							alert("<p>TimeOut error Please Try After some time</P>");
						} else {
						   alert("<p>"+xhr.responseText+"</p>");
						}
					}
				}, 5000);
			}
			
			 function NumAndTwoDecimals(e , field) {
   var val = field.value;
   var re = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)$/g;
   var re1 = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)/g;
    if (re.test(val)) {  } 
	else {
	  val = re1.exec(val);
     if (val) {
      field.value = val[0];
	  window.alert("Its Not  Valid  Amount");
	  field.value="";
	   $('#amount').focus();
      } else {
      field.value = "";
      } 
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