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
<title>naturals | STAFFS</title>

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
							<h4>MANAGE  STAFFS:</h4>
						</div>
						<div id='tabletable' class="form-body">
						</div>
				
				<div class="modal fade" id="view" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="view" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="eventDetail">EDIT STAFFS</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="insidebody">
					   
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					   
					  </div>
					</div>
				  </div>
				</div>
				<div class="modal fade" id="editmod" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="editmod" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="eventDetail">EDIT STAFFS</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="insidebody2">
					   
					  </div>
					  
					</div>
				  </div>
				</div>
				
					<div class="modal fade" id="passwordview" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="passwordview" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="eventDetail">ADMIN SETUP</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <form action='' method = 'POST' id='AdminSetupForm'>
					 <div class='modal-body cusmodel'>	
					 
						
						<input type='hidden' id='pid' name='pid'/>
							<div class='row'>
								<div class='col-lg-12'>
									<label>Password</label>
									<input type='password' name='password' class='form-control' required id='Password'/>
								</div>
							</div>
							<div class='row'>
								<div class='col-lg-12'>
									<label>Re-Password</label>
									<input type='password' name='repassword' class='form-control' required id='RePassword'/>
								</div>
							</div>
						
					  <div class='modal-footer' style='text-align:center'>
						<button type='button' class='btn btn-primary adminsetup' >SETUP</button>
						<button type='button' class='btn btn-primary' data-dismiss='modal'>Close</button>
				   
				  </div>
					  </div></form>

					</div>
				  </div>
				</div>
			
		</div>
		 <?php include_once('includes/footer.php');?>
	</div>
	<!-- Classie -->
		<script src="js/classie.js"></script>
			<script>
		$(document).ready(function() {
			$("body").on("click",".delete",function() {
				var con = confirm("Are you sure want to delete ?");
				if(con) {
					var id =$(this).attr('id');
					var dataString = "id="+id+"&action=delete";
					//alert(id);	alert(dataString);
					$.ajax({
							type: 'POST',
							url: 'ajax/staffajax.php',
							timeout: 100000,
							data:dataString,	
							success: function(server_response){
								var spl = server_response.split('[BRK]');
								var code =spl[0]; 
								var msg =spl[1];
								alert(msg);		
								loadtab();
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
			});
			
			$("body").on("click",".passwordview",function() {
				var id = $(this).attr('id');
				//alert(id);
				$("#pid").val(id);
			});
			$("body").on("click",".update",function() {
				var dataString = $("#UpdateForm").serialize()+"&action=update";
				$.ajax({
						type: 'POST',
						url: 'ajax/staffajax.php',
						timeout: 100000,
						data:dataString,	
						success: function(server_response){
							var spl = server_response.split('[BRK]');
							var code =spl[0]; 
							var msg =spl[1];
							alert(msg);		
							if(code.trim() == 0) {													
								$("#editmod").modal('hide');
								loadtab();
							}
							else {
								
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
			loadtab();
			$("body").on("click",".view",function() {
					var id=$(this).attr('id');
					//alert(id);
					var dataString  = "action=view&id="+id;
					$.ajax({
						type: 'POST',
						url: 'ajax/staffajax.php',
						timeout: 100000,
						data:dataString,	
						success: function(server_response){
							if(server_response.trim() != ""){
								$(".insidebody").html(server_response);
								loadtab();
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
				$("body").on("click",".adminsetup",function() {
					var id = $("#pid").val();
					var fo = $("#AdminSetupForm").serialize();
					var dataString  = "action=submit&"+fo;
					//alert(dataString);
					$.ajax({
						type: 'POST',
						url: 'ajax/staffajax.php',
						timeout: 100000,
						data:dataString,	
						success: function(server_response){
							if(server_response.trim() != ""){
								var spl = server_response.split('[BRK]');
								var code =spl[0]; 
								var msg =spl[1];
								alert(msg);
								if(code.trim() == 0) {													
									$("#passwordview").modal('hide');
									loadtab();
								}
							}
							else {
								
							}
								
						},
						error: function(xhr, status, error) {
							if(status === "timeout") {
								alert("<p>TimeOut error Please Try After some time</P>");
							} else {
							   alert("<p>"+status+"</p>");
							}
						}
					});
				});
				$("body").on("click",".edit",function() {
					var id=$(this).attr('id');
					//alert(id);
					var dataString  = "action=edit&id="+id;
					$.ajax({
						type: 'POST',
						url: 'ajax/staffajax.php',
						timeout: 100000,
						data:dataString,	
						success: function(server_response){
							if(server_response.trim() != ""){
								$(".insidebody2").html(server_response);
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
		});
	
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