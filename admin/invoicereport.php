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
<title>Naturals |  Invoice Report</title>

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
table.dataTable tbody th, table.dataTable tbody td {
    padding: 2px 10px;
}
.form-body {
    padding: 0.5em 2em;
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
							<h4> Invoice Report:</h4>
						</div>
						<div class="form-body">
			
							<form action='' target="_blank"  method='POST' id='InvoiceReportForm' name='customerreeportform'>
								<div class='row'>
										<div class='col-lg-2 col-md-6 col-sm-6'>
												<label>Report For</label>	
											<select class='form-control' name='reportfor' id='ReportFor'>
												<option value='ALL'>ALL</option>
												<option value='S'>Staff</option>
												<option value='C'>Customer</option>
											</select>
										</div>									
										<div class='col-lg-3 col-md-6 col-sm-6'>
											
											<label><input type="radio" name="typeselect" id="In" value="in" style="padding-left:10px" checked /></label>Invoice	
												<div   id='InvoiceDiv'>
										<input name='invoice' value='All' id='invoice' />
												</div>
										</div>
										<div class='col-lg-3 col-md-6 col-sm-6'>
											<label><input type="radio"  name="typeselect" id="To" value="da" style="padding-left:10px"  /></label>
											<label>Start Date</label>
											<input type='date' disabled  class='form-control ' value='' name='startdate' id='StartDate'/>
										</div>
										
										<div class='col-lg-3 col-md-6 col-sm-6'>
											<label>End Date</label>
											<input type='date' disabled class='form-control' name='enddate' id='EndDate'/>
										</div>
										<div class='col-lg-1 col-md-6 col-sm-6'>
											<br />
											<input type='button' class='btn btn-primary' id='Query' value='Query'/>
											
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
									<th>Total Item</th>  
									<th>Transaction Date</th>  
									<th>Total Amount</th> 
									<th>Customer Name</th>
									<th>Detail</th>
									<th>Edit</th>
									<th>Cancel</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			<div class="modal fade" id="getinvoice" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="view" aria-hidden="true">
				  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="eventDetail">Invoice Detail</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="insidebody2">
					   
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					   
					  </div>
					</div>
				  </div>
				</div>
				
			
		</div>
		 <?php include_once('includes/footer.php');?>
	</div></div></div>
	<!-- Classie -->
		<script src="js/classie.js"></script>
		<script>
		function convert(str) {
  var date = new Date(str),
    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
    day = ("0" + date.getDate()).slice(-2);
	alert([date.getFullYear(), mnth, day].join("-"));
  return [date.getFullYear(), mnth, day].join("-");
}
function setInputDate(_id){
    var _dat = document.querySelector(_id);
    var hoy = new Date(),
        d = hoy.getDate(),
        m = hoy.getMonth()+1, 
        y = hoy.getFullYear(),
        data;

    if(d < 10){
        d = "0"+d;
    };
    if(m < 10){
        m = "0"+m;
    };

    data = y+"-"+m+"-"+d;
	data2 = d+"-"+m+"-"+y;
	//alert(data);
    ///console.log("ddd"+data2);
    _dat.value = data;
};

setInputDate("#StartDate");
setInputDate("#EndDate");
			function loadin() {				
				var dataString = "action=loadinv";
				$.ajax({
					type: 'POST',
					url: 'ajax/load.php',
					timeout: 100000,
					data:dataString,	
					success: function(server_response){
						$("#InvoiceDiv").html(server_response);
						$("#InvoiceDropDown").select2();
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
		 loadin();
		$(document).ready(function() {
			$("input[name=typeselect]").click(function () {
			if($("#In").is(":checked")){
				$("#StartDate, #EndDate").attr("disabled",true);
				$("#InvoiceDropDown").attr("disabled",false);
				$("#StartDate, #EndDate").val("");
     		}
     		else if($("#To").is(":checked")){
				$("#StartDate, #EndDate").attr("disabled",false);
				$("#InvoiceDropDown").attr("disabled",true);
     		}
         });
		// $("#StartDate").val(new Date());
		 
			$("body").on("click","#Pdf",function() {				
				$("#InvoiceReportForm").attr("action","cuerepdf.php");
			});
			
			$("body").on("click",".getinvoice",function() {
				var val = $(this).attr('id');
			//	alert(val);
				var dataString ="id="+val+"&action=getinvoicem";
				
					$.ajax({
							type: 'POST',
							url: 'ajax/prInvoiceajax.php',
							timeout: 100000,
							data:dataString,	
							success: function(server_response){
								//alert(server_response);
								$(".insidebody2").html(server_response);	
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
			$('body').on('click', '.delete', function(e) {
			 var btn =$(this);
			 var id = $(this).attr('id');
			 $('#table').DataTable().destroy();
				$.ajax({
					type: 'POST',
					url: 'ajax/updatebillajax.php',
					timeout: 100000,
					data:{
						"action":"delete",
							"id":id						
					},	
					success: function(server_response){
						alert(server_response);
						btn.closest('tr').remove();	
						$('#table').DataTable( {
								paging: true,
								ordering: true,
							} );
							$(".dt-button").addClass('btn btn-primary');
							$(".dt-buttons").css('text-align','center');
							$(".dt-buttons").css('margin-top','-7.5%');
						
//alert($(this).parent().parent().closest('tr').html());
								//window.location.reload();
							},
							error: function(xhr, status, error) {
								$(".insidebody3").html("Something Went Wrong..Please try again");
								$('#sucdiv').modal('show');
								if(status === "timeout") {
									alert("<p>TimeOut error Please Try After some time</P>");
								} else {
								   alert("<p>"+xhr.responseText+"</p>");
								}
							}
						});	
			})
			$("body").on("click","#Excel",function() {				
				$("#InvoiceReportForm").attr("action","cuerexcel.php");
			});
			$("body").on("click","#Query",function() {
				var dataString ="action=query&"+$("#InvoiceReportForm").serialize();
				//alert(dataString);
				$.ajax({
						type: 'POST',
						url: 'ajax/prInvoiceajax.php',
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
						//	$(".dataTables_length").css("float","right");
							//$(".dataTables_length").css("margin-right","2%");
							//$(".dataTables_length").css("margin-left","2%");
							//$(".dataTables_length, .dataTables_filter").css('margin-top','-10.5%');
						//	$(".dataTables_filter").css('margin-bottom','4%');
						//	$(".um").html($("#table_wrapper").html());
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