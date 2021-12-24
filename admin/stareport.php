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
<title>naturals | Staff History</title>

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
	<link href="css/select2.min.css" rel="stylesheet" /> 


<!-- Select2 JS --> 
<script src="js/select2.min.js"></script>
<!--//end-animate-->
<!-- Metis Menu -->
  <link rel="stylesheet" href="css/jquery.dataTables.min.css">
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">

<style>

#comtable > thead > tr > th, #comtable > tbody > tr > th, #comtable > tfoot > tr > th, #comtable > thead > tr > td, #comtable > tbody > tr > td, #comtable > tfoot > tr > td {
	
   font-family:normal;
   font-weight: normal;
    padding: 5px;
    line-height: 1;
    vertical-align: top;
    border-top: 1px solid #ddd;
}

.bs-example {
   margin-top: 0px !important;
}

.charts, .row {
    margin: 1em 0 0;
}
#table th, #table td {
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
							<h4>Staff Report:</h4>
						</div>
						<div class="form-body">
			
							<form action='' target="_blank"  method='POST' id='StaffReportForm' name='customerreeportform'>
								<div class='row'>
									
										<div class='col-lg-3 col-md-6 col-sm-6'>
											<label>Category	</label>
											<select name='cate' id='cate' class='form-control'>
												<option value='CBW'> Staff Bill Wise Histotry</option>
												<option value='CNO'> Staff No of Visists Histotry</option>
											</select>
										</div>
										<div class='col-lg-3 col-md-6 col-sm-6'>
											<label>Staff	</label>
												<div id='StaffDiv'>
										
												</div>
										</div>
										<div class='col-lg-3 col-md-6 col-sm-6'>
											<label>Start Date</label>
											<input type='date' class='form-control' name='startdate' id='StartDate'/>
										</div>
										
										<div class='col-lg-3 col-md-6 col-sm-6'>
											<label>End Date</label>
											<input type='date' class='form-control' name='enddate' id='EndDate'/>
										</div>
									
								</div>
								<div class='row'>
									
										<div class='col-lg-12 col-md-6 col-sm-6' style='text-align:center'>
											<input type='button' class='btn btn-primary' id='Query' value='Query'/>
											<!--<input type='button' class='btn btn-primary' id='Print' value='Print'/>
											<input type='submit' class='btn btn-primary' id='Pdf' value='Pdf Download'/>
											<input type='submit' class='btn btn-primary' id='Excel' value='Excel Download'/>-->
										</div>
									
								</div>
						</form>
				</div>
				<div class='row'>
					<div class='col-lg-12 col-md-6 col-sm-6' style='text-align:center'>
						<div id='tablcont'>
							<table class='table table-bordered' id='table'> 
								<thead>
									<tr>
										<th>#</th>
										<th>Staff Name</th>  
										<th>Total Amount</th>  
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			
			
		</div>
		 <?php include_once('includes/footer.php');?>
	</div></div></div>
	<!-- Classie -->
		<script src="js/classie.js"></script>
		<script>
		
			function loadcus() {				
				var dataString = "action=loadstaffal";
				$.ajax({
					type: 'POST',
					url: 'ajax/load.php',
					timeout: 100000,
					data:dataString,	
					success: function(server_response){
						$("#StaffDiv").html(server_response);
						$("#StaffDropDown").select2();
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
		 loadcus();
		$(document).ready(function() {
			$("body").on("click","#Pdf",function() {				
				$("#StaffReportForm").attr("action","cuerepdf.php");
			});
			$("body").on("click","#Excel",function() {				
				$("#StaffReportForm").attr("action","cuerexcel.php");
			});
			$("body").on("click","#Query",function() {
				var dataString ="action=query&"+$("#StaffReportForm").serialize();
				//alert(dataString);
				$.ajax({
						type: 'POST',
						url: 'ajax/cusreajax.php',
						timeout: 100000,
						data:dataString,	
						success: function(server_response){
							$("#tablcont").html(server_response);
							//loadtab();
							$('#table').DataTable( {
								paging: true,
								ordering: true,
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
			});		});

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
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.js"> </script>
	<script src="js/jquery.nicescroll.js"></script>
	
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