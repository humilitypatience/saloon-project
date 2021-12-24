<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['naturalsaid']==0)) {
  header('location:logout.php');
  } else{

if(isset($_POST['submit']))
  {
    $name=trim($_POST['name']);
    $email=trim($_POST['email']);
	$mobilenum=trim($_POST['mobilenum']);
	$membertype = trim($_POST['membertype']);
	 $gender=trim($_POST['gender']);
    $details=trim($_POST['details']);
	$date=trim($_POST['date']);
	$adate = trim($_POST['adate']);
	$address = addslashes (mysqli_real_escape_string($con,$_POST['address']));
	
	$check_query = "SELECT MobileNumber FROM tblcustomers WHERE MobileNumber = '".trim($mobilenum)."'";
error_log($check_query);
	$check_result = mysqli_query($con,$check_query);
	if($check_result) {
		$count = mysqli_num_rows($check_result);	
		if($count <= 0 ) {		
				if($membertype == "Y") {
					$member_from_date =$_POST['frommemdate']; 
					$member_to_date =$_POST['tomemdate']; 
					if($date != null && $adate != null) {
					 $Qy = "insert into  tblcustomers(address, member, member_from_date, member_end_date, Name,Email,MobileNumber,Gender,Details, active,CreationDate, birth_date, annivarsary_date) 
										value('$address','$membertype','$member_from_date','$member_to_date','$name','$email','$mobilenum','$gender','$details','Y', now(),'$date','$adate')";
					}
					if($date != null && $adate == null) {
					 $Qy = "insert into  tblcustomers(address, member, member_from_date, member_end_date, Name,Email,MobileNumber,Gender,Details, active,CreationDate, birth_date, annivarsary_date) 
										value('$address','$membertype','$member_from_date','$member_to_date','$name','$email','$mobilenum','$gender','$details','Y', now(),'$date',null)";
					}
					if($date == null && $adate != null) {
					 $Qy = "insert into  tblcustomers(address, member, member_from_date, member_end_date, Name,Email,MobileNumber,Gender,Details, active,CreationDate, birth_date, annivarsary_date) 
										value('$address','$membertype','$member_from_date','$member_to_date','$name','$email','$mobilenum','$gender','$details','Y', now(),null,'$adate')";
					}
					if($date == null && $adate == null) {
					 $Qy = "insert into  tblcustomers(address, member, member_from_date, member_end_date, Name,Email,MobileNumber,Gender,Details, active,CreationDate) 
										value('$address','$membertype','$member_from_date','$member_to_date','$name','$email','$mobilenum','$gender','$details','Y', now())";
					}
				}
					
				if($membertype == "N") {
					$member_from_date =NULL;
					$member_to_date =NULL;
					if($date != null && $adate != null) {
						$Qy = "insert into  tblcustomers(address, member, Name,Email,MobileNumber,Gender,Details, active,CreationDate, birth_date, annivarsary_date) 
										value('$address','$membertype','$name','$email','$mobilenum','$gender','$details','Y', now(),'$date','$adate')";
					}
					if($date != null && $adate == null) {
						$Qy = "insert into  tblcustomers(address, member, Name,Email,MobileNumber,Gender,Details, active,CreationDate, birth_date) 
										value('$address','$membertype','$name','$email','$mobilenum','$gender','$details','Y', now(),'$date')";
					}
					if($date == null && $adate != null) {
						$Qy = "insert into  tblcustomers(address, member, Name,Email,MobileNumber,Gender,Details, active,CreationDate, annivarsary_date) 
										value('$address','$membertype','$name','$email','$mobilenum','$gender','$details','Y', now(),'$adate')";
					}
					if($date == null && $adate == null) {
						$Qy = "insert into  tblcustomers(address, member, Name,Email,MobileNumber,Gender,Details, active,CreationDate) 
										value('$address','$membertype','$name','$email','$mobilenum','$gender','$details','Y', now())";
					}
				}

				error_log($Qy);
				$query=mysqli_query($con, $Qy );
				if ($query) {
					echo "<script>alert('Customer has been added.');</script>"; 
					echo "<script>window.location.href = 'add-customer.php'</script>"; 
			 } else {
				echo "<script>alert('Something Went Wrong. Please try again.');</script>";  	
			}
		}
		else {
			echo "<script>alert('".$mobilenum." already available.');</script>";  
		}
		}	
		else {
			echo "<script>alert('"; echo (mysqli_error($con)); echo ".');</script>";  
		}
	
	}
  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>naturals | Add Services</title>

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
.form-body {
    padding: 0.5em 2em;
}
.form-group {
    margin-bottom: 5px;
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
							<h4>Parlour Customer:</h4>
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
									<div class="form-group"> <label for="exampleInputEmail1">Member</label> 
										<select class='form-control' name='membertype' id='MmeberType'>
											<option value='N'>Non-Member</option>
											<option value='Y'>Member</option>
										</select>
									</div>				
								</div>
							</div>
							<div class='row membershipdiv'  style='display:none'>
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									<div class="form-group"> <label for="exampleInputPassword1">MemberShip From Date</label> 
										<input type="date" id="frommemdate" name="frommemdate" class="form-control" placeholder="MemberShip From Date" value="" > 
									</div>
								</div>	
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									<div class="form-group"> <label for="exampleInputPassword1">MemberShip To Date</label> 
										<input type="date" id="tomemdate" name="tomemdate" class="form-control" placeholder="MemberShip To Date" value="" >
									</div>
								</div>
							</div>

							
							<div class='row'>
								<div class='col-lg-6 col-sm-12 col-md-12 '>																
									 <div class="form-group"> <label for="exampleInputEmail1">Mobile Number</label> 
										<input type="text" class="form-control" id="mobilenum" onkeyup='Numonly(event , this);' name="mobilenum" placeholder="Mobile Number" value="" required="true" maxlength="10" pattern="[0-9]+"> 
									 </div>
								</div>
								
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									<div class="radio">
									   <p style="padding-top: 20px; font-size: 15px"> <strong>Gender:</strong> <label>
											<input type="radio" name="gender" id="gender" value="Female" checked="true">
											Female
										</label>
										<label>
											<input type="radio" name="gender" id="gender" value="Male">
											Male
										</label>
										<label>
											<input type="radio" name="gender" id="gender" value="Transgender">
										   Transgender
										</label>
										</p>
									</div>
								</div>
							</div>
							
							<div class='row'>
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									<div class="form-group"> <label for="exampleInputPassword1">DOB</label> 
										<input type="date" id="date" name="date" class="form-control" placeholder="DOB" value=""> 
									</div>
								</div>	
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									<div class="form-group"> <label for="exampleInputPassword1">Annivarsary Date</label> 
										<input type="date" id="adate" name="adate" class="form-control" placeholder="Annivarsary Date" value="" >
									</div>
								</div>
							</div>

							 <div class='row'>
								<div class='col-lg-6 col-sm-12 col-md-12 '>
									<div class="form-group"> <label for="exampleInputEmail1">Memebership Details</label> <textarea type="text" class="form-control" id="details" name="details" placeholder="Details" required="true" rows="4" cols="4"></textarea> </div>
								</div>
									<div class='col-lg-6 col-sm-12 col-md-12 '>
									<div class="form-group"> <label for="exampleInputPassword1">Email</label> 
										<input type="email" id="email" name="email" class="form-control" placeholder="Email" value="" required="true"> 
									</div>
								</div>
							</div>
								 <div class='row'>
								<div class='col-lg-12 col-sm-12 col-md-12 '>
									<div class="form-group"> <label for="exampleInputEmail1">Address</label> <textarea type="text" class="form-control" id="address" name="address" placeholder="Please Enter Address" required="true" rows="4" cols="4"></textarea> </div>
								</div>
								<div class='col-lg-12 col-sm-12 col-md-12 '>
									 <button type="submit" id='add' name="submit" class="btn btn-default">Add</button>
								</div>
									
							</div>
							  </form> 
						</div>
						
					</div>
				
				
			</div>
		</div>
		 <?php include_once('includes/footer.php');?>
	</div>
	<!-- Classie -->
		<script src="js/classie.js"></script>
		<script>
		
function Numonly(e , field) {
   var val = field.value;
   if(parseInt(val)) {
	   var re = /^([0-9]+[]?[0-9]?[0-9]?|[0-9]+)$/g;
	   var re1 = /^([0-9]+[]?[0-9]?[0-9]?|[0-9]+)/g;
		if (re.test(val)) {  } 
		else {
		  val = re1.exec(val);
		 if (val) {
		  field.value = val[0];
		  window.alert("Its Not Valid");
		  field.value="0";
		   $(this).focus();
		  } else {
		  field.value = "0";
		  } 
		}
	}
   else {
	 field.value = "0";
   }
}
		$(document).ready(function() {
			$("#add").click(function() {
				var mobilenum = $("#mobilenum").val();
				if(mobilenum.length < 10) {
					alert("Please Enter Valid Mobile Number");
					$("#mobilenum").focus();
					return false;
				}
				else if(mobilenum.length > 10) {
					$("#mobilenum").focus();
					alert("Please Enter Valid Mobile Number");
					return false;
				}
				else {
					return true;
				}
			});
			$("#MmeberType").change(function() {
				var val = $(this).val();
				//alert(val);
				if(val == "-1") {
					$("#MmeberType").val("N");
				}
				if(val == "Y") {
					$(".membershipdiv").css("display","block");
				}
				if(val == "N") {
					$(".membershipdiv").css("display","none");
				}
			
			});
		});
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