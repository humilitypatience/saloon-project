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
<title>Naturals | Invoice All Print</title>

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
							<h4>Invoice All Print:</h4>
						</div>
						<div class="form-body">
			
							<form action='' target="_blank"  method='POST' id='PrintAllForm' name='prntallform'>
								<div class='row'>
									
										<div class='col-lg-3 col-md-12 col-sm-12'>
											<label>Start Date</label>
											<input type='date' class='form-control' name='startdate' id='StartDate'/>
										</div>
										
										<div class='col-lg-3 col-md-12 col-sm-12'>
											<label>End Date</label>
											<input type='date' class='form-control' name='enddate' id='EndDate'/>
										</div>
										
										<div class='col-lg-6 col-md-12 col-sm-12' style='text-align:center'>
										<br />
											<input type='button' class='btn btn-primary' id='Query' value='Query'/>
											<input type='submit' class='btn btn-primary' id='Pdf' value='Print'/>
											<!--<input type='button' class='btn btn-primary' id='Print' value='Print'/>
											<input type='submit' class='btn btn-primary' id='Pdf' value='Pdf Download'/>
											<input type='submit' class='btn btn-primary' id='Excel' value='Excel Download'/>-->
										</div>
									
								</div>
								
						</form>
						<div class='row'>
					<div class='col-lg-12 col-md-12 col-sm-12' style='text-align:center'>
						<div id='tablcont'>
							<table class='table table-bordered' id='table'> 
								<thead>
									<tr>
										
										<th>Total Invoice Count</th>  
										<th>Print</th>  
									</tr>
								</thead>
							</table>
							<input type='button' class='btn btn-primary' id='Print' value='Print All'/>
						</div>
					</div>
				</div>
				</div>
				
			
			
		</div>
		 <?php include_once('includes/footer.php');?>
	</div></div></div></div>
	<!-- Classie -->
		<script src="js/classie.js"></script>
		<script>
		
			
		
		$(document).ready(function() {
			$("body").on("click","#Print",function() {
				var img ='<html>'+'<head>'+'<link rel="stylesheet" href="css/popup.css" type="text/css" media="screen" />'+
					'<link rel="stylesheet" type="text/css" href="css/default1.css"/>'+'<link rel="stylesheet" type="text/css" href="css/layout.css" media="screen" />'+
					'<style>table {font-size:14px;padding: 0.5%;font-size: 12px;} td {padding:5px;font-size:11px;font-family: monospace;}  hr {  border: 0;  clear:both;  display:block;  width: 100%; background-color:black;  height: 2px;border-bottom: 2px dotted #ccc; }p{margin:5px 0px}'+'#footer {'+'position: absolute;'+'bottom: 0;'+'width: 100%;'+'height: 100px;'+'}'+'</style>'+'<span class="header">'+'<p style="float:right;margin-top:0.4px"><?php echo date("Y-m-d H:i:s"); ?></p>'+'<p style="text-align:center;width:120px;margin:auto" ><img id ="myimg" src=\"logo/logo.png\" width="100px" height="40px"/></p>'+
					'<p style="text-align: center;font-size: 14px;font-weight: 100;">1st Floor</p>'+'<p style="text-align: center;font-size: 14px;font-weight: 100;"> Skyline Citadel, Kottayam - Kumily Rd,</p>'+'<p style="text-align: center;font-size: 14px;font-weight: 100;"> Opposite Plantation Corporation Junction, Kanjikuzhi, Kottayam, Kerala 686004</p>'+'<p style="text-align: center;font-size: 14px;font-weight: 100;">Phone: +91 9656400156</p>'+'</p>'+'<p style="text-align: center;font-size: 14px;font-weight: bold;">Tax Invoice</p>'+'</span>'+'</head>'+'<body>'+'<br>'+'<hr style="clear:both">';
					var sdate = $("#StartDate").val();
					var edate = $("#EndDate").val();
					//alert(sdate);	alert(edate);
					var dataString = "sdate="+sdate+"&edate="+edate+"&action=print";
					//alert(dataString);
					$.ajax({
						type: 'POST',
						url: 'ajax/printallajax.php',
						
						timeout: 100000,
						data:dataString,	
						success: function(server_response){
						//alert(server_response);
						var ser_plit = server_response.split("BRK");
						var len = ser_plit[0];
						var res_Strr = "";
					
						for(var i=1;i<=len;i++) {
						  res_Strr +=img+ ser_plit[i];
						//  res_Strr +=  res_Strr;
						}
						//alert(len);
						var win=window.open("","height=1000","width=1000");
						with(win.document){
						
						 open();
						  write(res_Strr+'<script>window.print();window.close();<\/script>');
						  close();
						 }
								},
								error: function(xhr, status, error) {
									if(status === "timeout") {
										alert("<p>TimeOut error Please Try After some time</P>");
									} else {
									   alert("<p>"+xhr.responseText+"</p>");
									}
								}
							});	
			
		  });
			$("body").on("click","#Query",function() {
				var dataString ="action=query&"+$("#PrintAllForm").serialize();
			//	alert(dataString);
				$.ajax({
						type: 'POST',
						url: 'ajax/printallajax.php',
						timeout: 100000,
						data:dataString,	
						success: function(server_response){
							$("#tablcont").html(server_response);
							//loadtab();
						//	$('#table').DataTable( {
							//	paging: true,
								//ordering: true,
							//} );
							$(".dt-button").addClass('btn btn-primary');
							$(".dt-buttons").css('text-align','center');
							$(".dt-buttons").css('margin-top','-7.5%');
							$(".dataTables_filter").css('margin-top','-22%');
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