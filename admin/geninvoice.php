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
<title>Naturals || Invoice</title>

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
<!-- Select2 CSS --> 
<link href="css/select2.min.css" rel="stylesheet" /> 


<!-- Select2 JS --> 
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
.bs-example {
   margin-top: 0px !important;
}
#page-wrapper {
    padding: 4.9em 0em 2.5em;
    background-color: #F1F1F1;
}
.charts, .row {
    margin: 1em 0 0;
}

#comtable > thead > tr > th, #comtable > tbody > tr > th, #comtable > tfoot > tr > th, #comtable > thead > tr > td, #comtable > tbody > tr > td, #comtable > tfoot > tr > td {
	
   
      font-size:14px;
   font-weight: 600;
    padding: 5px;
    line-height: 1;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
#serTable > thead > tr > th {
	 padding: 4px;
  }
.select2-container--focus ,.select2, .select2-container, .select2-container--default, .select2-container--focus {
	width:100% !important
}
.select2-container--default .select2-results__option--selected {
    background-color: #ddd;
    font-size: 14px !important;
}
.select2-results__option {
	font-size: 14px !important;
	padding:4px 0px;
	
}
#serTable input.form-control {
	padding-left:2px;
	padding-right:2px;
}
.select2-container .select2-selection--single .select2-selection__rendered {
    padding-left: 0px;
    padding-right: 00px;
}
.select2-container, .select2-container--default, .select2-container--focus {
    width: 150px !important;
}
#ServiceDropDown.select2-container, .select2-container--default, .select2-container--focus {
    width: 100% !important;
}
#loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 120px;
  height: 120px;
  margin: -76px 0 0 -76px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
  
}
</style>
</head> 
<body class="cbp-spmenu-push" onload="myFunction()" >

	<div class="main-content">
		<!--left-fixed -navigation-->
		 <?php include_once('includes/sidebar.php');?>
		<!--left-fixed -navigation-->
		<!-- header-starts -->
		 <?php include_once('includes/header.php');?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
		<div id="loader"></div>
			<div class="main-page" style="display:none;" id="myDiv">
			<div class="table-responsive bs-example widget-shadow">
				<div class='col-lg-9 col-sm-12 col-md-9'>
				<div class='row' style='padding:0px' >
				<div class='col-lg-12 col-md-12 col-sm-12' style='margin-bottom:1%;padding:0px'>
				
				
				<div class='col-lg-4 col-md-12 col-sm-12' style='padding:0px'>	
						<div id='CustomerDiv'>
							
						</div>
							
						</div>
						<div class='col-lg-8 col-md-12 col-sm-12'style='padding:0px'>	
						
						<input type='button'  style='float:right;margin-right:1%;' data-toggle='modal' data-target='#editmod' class='btn btn-primary editcus' value='Cus.Edit'/>
						<input type='button' style='float:right;margin-right:1%;' id='creewcust' data-toggle='modal' data-target='#newcustomer'  class='btn btn-dark' value='Create.Cus'/>
						<input type='button' style='float:right;margin-right:1%;;' id='getcustomerdet' data-toggle='modal' data-target='#getcustomer'  class='btn btn-primary getcustomer' value='Customer.Det'/>
						<input type='button' style='float:right;margin-right:1%;' id='getinvoicedet' data-toggle='modal' data-target='#getinvoice'  class='btn btn-danger getinvoice' value='GetIn.Det'/>
					
				
					
				</div>
			</div>
					<div class='col-lg-12 col-md-12 col-sm-12' style='margin-bottom:1%;padding:0px'>
					
						<div id='SerDiv'>
								
						</div>
					</div>
				</div>
 			
				
					<table class="table table-bordered" id='serTable' width="100%" border="1"> 
						<thead>
							
							<tr>
								<th style='width: 20%'>Service</th>
								<th style='width: 20%'>Service Person</th>
								<th>Cost</th>
								<th>Add.Charge</th>
								<th>Discount</th>
								<th>CGST</th>
								<th>SGST</th>
								<th>Total</th>
								<th style='font-size: 12px;width: 5%;padding: 0px;vertical-align: middle;padding: 0px;text-align: center;'><img src='images/cross.png' title='delete'/></th>
							</tr>
						</thead>
							<tbody id='tbody'>
						
							</tbody>
					</table>
				</div>
			<div class='col-lg-3 col-sm-12 col-md-3'>
				<table class="table table-bordered" id='comtable' style='margin-bottom:0px' width="100%" border="1">
					<tr><th style='text-align:right;width:30%' >Customer</th>
						<th colspan="2" style=';width:70%'><div class="radio">
					   <p style="font-size: 15px"> <strong>Bill For:</strong> <label>
							<input type="radio" name="type" id="type" value="C" >
							Customer
						</label>
						<label>
							<input type="radio" name="type" id="type2" value="S">
							Staffs
						</label>
						
						</p>
					</div></th>	
						
					</tr>
					
				
					<tr>
						<th colspan='2' style='text-align:right' >Total Cost:</th><th style='text-align:right'> <span id='TotalCostS'>0.00</span><input type='hidden' readonly class='form-control' id='TotalCost'/></th>
					</tr>
					<tr>
						<th colspan='2' style='text-align:right' >Add.Charge:</th><th style='text-align:right'> <span id='AddCharges'>0.00</span><input type='hidden' readonly class='form-control' id='AddCharge'/></th>
					</tr>
					<tr>
						<th colspan='2' style='text-align:right' >Total GST:</th><th style='text-align:right'>  <span id='TotalGSTS'>0.00</span><input type='hidden' readonly class='form-control' id='TotalGST'/></th>
					</tr>
					<tr>
						<th colspan='2' style='text-align:right' >Ser.Disc: </th><th style='text-align:right'> <span id='TotalDiscountS'>0.00</span><input type='hidden' readonly class='form-control' id='TotalDiscount'/><input type='hidden' readonly class='form-control' id='customerName'/></th>
					</tr>
					<tr class='colpr'>
					<th style='text-align:right;width:40%' >Promo</th>
						<th colspan="2"><div id='PromoDiv'>
							
						</div></th>	
						
					</tr>
						<tr>	
							<th colspan='2' style='text-align:right;width:40%' > Discount:</th><th style='text-align:right'> <input type='text' onkeyup='NumAndTwoDecimals(event , this);' value = '0.00'  style='text-align:right' name='wholediscount' class='form-control wholediscount' id='WholeDiscount'/></th>
						</tr>
						<tr class='colpaym'>	
							<th colspan='2' style='text-align:right;width:40%'><label>Pay Mode</label></th><th style='text-align:right'>
								<select class='form-control' id='PaymentMode'>
									<option value='CI'>CASH-IN-HAND</option>
									<option value='CA'>CARD</option>
								</select>
							</th>
						</tr>
					</table>
					<table class="table table-bordered" width="100%"  id='comtable'  border="1">
						<tr>	
							<th colspan='2'  style='text-align:right;width:40%' >Grand Total: </th><th style='text-align:right;'> <span style='text-align:right;font-size:25px;color:red;padding-right:10%'  id='TotalS'>0.00</span><input  style='text-align:right' type='hidden' readonly class='form-control' id='Total'/></th>
						</tr>	
						
						<tr>	
							<th colspan='2' style='text-align:right;width:40%' >Pay Amount</th><th style='text-align:right'><input type='text' onkeyup='NumAndTwoDecimals(event , this);' name='paymentamount' value='0.00' style='text-align:right;font-size:25px;color:red;' class='form-control payamt' id='PaymentAmount'/></th>
						</tr>						
						<tr>	
							<th colspan='2' style='text-align:right;width:40%' >Bal Amount</th><th style='text-align:right'><input onkeyup='NumAndTwoDecimals(event , this);' readonly='true' type='text' name='balanceamount' value='0.00' style='text-align:right;font-size:25px;color:red'  class='form-control balamt' id='BalanceAmount'/></th>
						</tr>
						<tr>	
							<th colspan='3' style='text-align:right;width:40%' ><input type='button' value='submit' id='submit' class='btn btn-primary'/></th>
						</tr>
					</table>
			</div>
			
			<div class="modal fade" id="getcustomer" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="view" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="eventDetail">Customer Detail</h5>
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
				
				<div class="modal fade" id="getinvoice" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="view" aria-hidden="true">
				  <div class="modal-dialog" role="document">
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
				
				<div class="modal fade" id="newcustomer" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="view" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="eventDetail">Create Customer</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					 <div class='modal-body cusmodel'>	
				<form method="post" action='' id='invoiceCustomerAddForm'>					 
					<table class='table table-bordered'>
						<thead>
							<tr>
								<th style='width:50%'>
									<div class="form-group"> <label for="exampleInputEmail1">Name</label> 
										<input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="" required="true"> 
									</div> 
								</th>
								
								<th>
									<div class="form-group"> <label for="exampleInputEmail1">Member</label> 
										<select class='form-control' name='membertype' id='MmeberType'>
											<option value='N'>Non-Member</option>
											<option value='Y'>Member</option>
										</select>
									</div>				
								</th>
							</tr>	
							<tr class='membershipdiv' style='display:none'>
								<th  >									
									<div class="form-group"> <label for="exampleInputPassword1">MemberShip From Date</label> 
										<input type="date" id="frommemdate" name="frommemdate" class="form-control" placeholder="MemberShip From Date" value="" > 
									</div>
								</th>
								<th>								
									<div class="form-group"> <label for="exampleInputPassword1">MemberShip To Date</label> 
										<input type="date" id="tomemdate" name="tomemdate" class="form-control" placeholder="MemberShip To Date" value="" >
									</div>						
								</th>							
							</tr>
							<tr>
								<th >									
									 <div class="form-group"> <label for="exampleInputEmail1">Mobile Number</label> 
										<input type="text" class="form-control" id="mobilenum" name="mobilenum" placeholder="Mobile Number" value="" required="true" maxlength="10" pattern="[0-9]+"> 
									 </div>
								</th>
								<th>								
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
								</th>							
							</tr>
							<tr>
								<th >									
									<div class="form-group"> <label for="exampleInputPassword1">DOB</label> 
										<input type="date" id="date" name="date" class="form-control" placeholder="DOB" value=""> 
									</div>
								</th>
								<th>								
									<div class="form-group"> <label for="exampleInputPassword1">Annivarsary Date</label> 
										<input type="date" id="adate" name="adate" class="form-control" placeholder="Annivarsary Date" value="" >
									</div>						
								</th>							
							</tr>
							<tr>
								<th >									
									<div class="form-group"> <label for="exampleInputEmail1">Memebership Details</label> <textarea type="text" class="form-control" id="details" name="details" placeholder="Details" required="true" rows="4" cols="4"></textarea> </div>
								</th>
								<th>								
									<div class="form-group"> <label for="exampleInputPassword1">Email</label> 
										<input type="email" id="email" name="email" class="form-control" placeholder="Email" value="" required="true"> 
									</div>						
								</th>							
							</tr>
							<tr>
								<th  colspan='2'>									
									<div class="form-group"> <label for="exampleInputEmail1">Address</label> <textarea type="text" class="form-control" id="address" name="address" placeholder="Please Enter the addresss" required="true" rows="4" cols="4"></textarea> </div>
								</th>
							</tr>	
							<tr><th colspan='2' style='text-align:center'>
								  <button type="button" id='add' name="submit" class="btn btn-primary">Add</button> 
								 
							</th></tr>
						</thead>
					</table>
					</form> 
				</div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					   
					  </div>
					</div>
				  </div>
				</div>
				
				<div class="modal fade" id="sucdiv" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="view" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="eventDetail">Invoice</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="insidebody3">
					   
					  </div>
					  <div class="modal-footer" style='text-align:center'>
						<button type="button" id='Ok'  class="btn btn-primary" >Ok</button>
					   
					  </div>
					</div>
				  </div>
				</div>
				
				
				<div class="modal fade" id="editmod" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="editmod" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="eventDetail">EDIT CUSTOMER</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="insidebody2">
					   
					  </div>
					  
					</div>
				  </div>
				</div>
  <!--<p style="margin-top:1%"  align="center">
  <i class="fa fa-print fa-2x" style="cursor: pointer;"  OnClick="CallPrint(this.value)" ></i>
</p>
-->
				
				</div>
			</div>
		</div>
		<!--footer-->
		 <?php include_once('includes/footer.php');?>
        <!--//footer-->
	</div>
	<!-- Classie -->
		<script src="js/classie.js"></script>
		
		<script>		
			$("#sidebar").toggleClass("toggled");
			//loadcus();loadser();
			loadall();
			function loadall() {	
				var dataString = "action=loadall";
				$.ajax({
					type: 'POST',
					url: 'ajax/billajax.php',
					timeout: 100000,
					data:dataString,	
					success: function(server_response){
						var spl = server_response.split("[BRK]");
						$("#CustomerDiv").html(spl[0]);					
						$("#SerDiv").html(spl[1]);						
						$("#PromoDiv").html(spl[2]);						
						setTimeout(function(){
							$("#PromoDropDown").select2();
							$("#ServiceDropDown").select2();
							$("#CustomerDropDown").select2();
						},1000);
						
					},
					error: function(xhr, status, error) {
						if(status === "timeout") {
							alert("<p>TimeOut error Please Try After some time</P>");
						} else {
						   alert("<p>"+xhr.responseText+"</p>");
						}
					}
				},3000);
			}
			function loadcus() {				
				var dataString = "action=loadcustomers";
				$.ajax({
					type: 'POST',
					url: 'ajax/billajax.php',
					timeout: 100000,
					data:dataString,	
					success: function(server_response){
						$("#CustomerDiv").html(server_response);
						$("#CustomerDropDown").select2();
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
			function loadcusnew() {				
				var dataString = "action=loadcustomers";
				$.ajax({
					type: 'POST',
					url: 'ajax/billajax.php',
					timeout: 100000,
					data:dataString,	
					success: function(server_response){
						$("#CustomerDiv").html(server_response);
						
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
			function loadcus2(valsel) {				
				var dataString = "action=loadcustomers";
				$.ajax({
					type: 'POST',
					url: 'ajax/billajax.php',
					timeout: 100000,
					data:dataString,	
					success: function(server_response){
						$("#CustomerDiv").html(server_response);
						$("#CustomerDropDown").select2();
					//	alert(valsel);
						//$('#CustomerDropDown').val(valsel); // Change the value or make some change to the internal state
						//$('#CustomerDropDown').val(valsel).trigger('change'); // Notify only Select2 of changes
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
			function loadser() {				
				var dataString = "action=loadservices";
				$.ajax({
					type: 'POST',
					url: 'ajax/billajax.php',
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
			$("body").on("click",".update",function() {
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
				
				var dataString = $("#UpdateForm").serialize()+"&action=update";
				var cid = $("#CustomerDropDown").val();
			//	alert(cid)
				$.ajax({
						type: 'POST',
						url: 'ajax/customerajax.php',
						timeout: 100000,
						data:dataString,	
						success: function(server_response){
							var spl = server_response.split('[BRK]');
							var code =spl[0]; 
							var msg =spl[1];
							alert(msg);		
							if(code.trim() == 0) {													
								$("#editmod").modal('hide');
								loadcusnew();
								setTimeout(function(){							
									$("#CustomerDropDown").select2();
									$('#CustomerDropDown').val(cid).select2();
								},100);
								//$('#CustomerDropDown').select2();
								//
							}
							else {
								
							}
							$('#CustomerDropDown').select2();
								
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
			$("body").on("click",".editcus",function() {
					
					var id = $("#CustomerDropDown").val();
					 if(id < 0 || id == "-1") {
						alert("Customer Should be Selected");
					
						$("#CustomerDropDown").select2('open');
						$("#editmod").modal('close');
					}
					else {
						var dataString  = "action=edit&id="+id;
						$.ajax({
							type: 'POST',
							url: 'ajax/customerajax.php',
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
					}
				});
			$('body').on('click', '#submit', function(e) {
				//alert("s");
				var tablelen = $("#serTable tbody tr").length;
				if (!validatform(1.5)) {				
				}
				else if (!validate_form2()) {
				}
				else {
				
					//alert("s");
					e.preventDefault();
					//alert("sa");
					var rowCount = $('#serTable tr').length;
					var customerName = $("#customerName").val(); 
					//alert(customerName);
					if(customerName.trim() != "") {
		//						alert("sa");
						var namearray = new Array(); 
						var idarray = new Array(); 
						var costarray = new Array();
						var cgstarray = new Array();
						var sgstarray = new Array();
						var totalarray = new Array();
						var discountarray = new Array();
						var employeearray = new Array();
						var addchargearray = new Array();
						var catego = new Array();
						var categ="";var addcharge = "";var employee = "";var name = "";var id = "";var cost = "";var discount = "";var cgst = "";var sgst = "";var total = "";
						$('#serTable tbody tr').each(function() {			
	//alert("saa");					
							name =  $(this).find('.serviceName').val();
							id =  $(this).find('.id').val();
							cost =  $(this).find('.cost').val();
							discount =  $(this).find('.discount').val();
							cgst =  $(this).find('.cgst').val();
							sgst =  $(this).find('.sgst').val();
							total =  $(this).find('.total').val();
							employee =  $(this).find('.EmployeeDropDown').val();
							addcharge =  $(this).find('.adchar').val();
							categ = $(this).find('.catet').val();
							///alert(employee);
							namearray.push(name); 
							idarray.push(id); 
							costarray.push(cost); 
							discountarray.push(discount); 
							cgstarray.push(cgst); 
							catego.push(categ); 
							sgstarray.push(sgst); 
							totalarray.push(total); 
							employeearray.push(employee); 
							addchargearray.push(addcharge);
						});
						var sendName = JSON.stringify(namearray); 
						var ids = JSON.stringify(idarray);
						var costs = JSON.stringify(costarray);
						var discountss = JSON.stringify(discountarray);
						var cgsts = JSON.stringify(cgstarray);
						var sgsts = JSON.stringify(sgstarray);
						var totals = JSON.stringify(totalarray);
						var addcharges = JSON.stringify(addchargearray);
						var catidcat = JSON.stringify(catego);
						var employees = JSON.stringify(employeearray);
						var customer = $("#CustomerDropDown").val();
						var coupen = $("#PromoDropDown").val();
						var codi =$("#campval").val(); 
						var PaymentAmount = $("#PaymentAmount").val();
						var ProTotalAmount = $("#TotalCost").val();
						var add_ch_amt = $("#AddCharge").val();
						var WholeDiscount = $("#WholeDiscount").val();
						var prodis = $("#TotalDiscount").val();						
						var BalanceAmount = $("#BalanceAmount").val(); 
						var total = $("#Total").val(); 
						var tgs =  $("#TotalGST").val(); 
						var totalDiscount = $("#TotalDiscount").val(); 
						var PaymentMode =  $("#PaymentMode").val(); 				
						var type =  $("input[name='type']:checked").val(); 
						var txref =  $("#txref").val(); 
					//	alert(tgs);
						var subbtn =$(this);
						subbtn.hide();
						$(".main-page").css("opacity"," 0.1");
						$("#loader").css("display","block");
						$.ajax({
							type: 'POST',
							url: 'ajax/billajax.php',
							timeout: 100000,
							data:{
								"action":"submit",
								"serviceName":sendName,
								"ids":ids,
								"prodis":prodis,
								"catidcat":catidcat,
								"pridis":WholeDiscount,
								"type":type,
								"tgs":tgs,
								"paymentamount":PaymentAmount,
								"proTotalAmt":ProTotalAmount,
								"addcha":add_ch_amt,
								"balanceamount":BalanceAmount,
								"paymentMode":PaymentMode,
								"costs":costs,
								"adcharge":addcharges,
								"discounts":discountss,
								"totalDiscount":totalDiscount,
								"cgsts":cgsts,
								"sgsts":sgsts,
								"totals":totals,
								"cus":customer,
								"coupen":coupen,
								"codi":codi,
								"txref":txref,
								"total":total,
								"customerName":customerName,
								"employees":employees
								
							},	
							success: function(server_response){
								//alert("dddd");
								subbtn.show();
								$(".main-page").css("opacity","1.0");
								$("#loader").css("display","none");
								$(".insidebody3").html(server_response+'<p style="margin-top:1%"  align="center"><i class="fa fa-print fa-2x" style="cursor: pointer;"  id="Print" ></i></p>');
								$('#sucdiv').modal('show');
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
					}
					else {
						alert("Customer should be selected");
						return false;
					}
				}
				
			});
			$("body").on("change","#ServiceDropDown",function() {
				var val =$(this).val();		
				var cid = $("#CustomerDropDown").val();
				
					if(val < 0 || val == "-1") {
						alert("Service Name is required");
						name[i].focus();
						return false
					}
				 
				else if(cid < 0 || cid == "-1") {
					alert("Customer Should be Selected");
					//$("#CustomerDropDown").focus();
					//$("#ServiceDropDown").val("-1");
					$('#ServiceDropDown').select2('close');
					$("#CustomerDropDown").select2('open');
				//	$("#ServiceDropDown").val(-1).trigger('change');;
					$('#ServiceDropDown').select2('destroy');
					$('#ServiceDropDown').val('-1').select2();

					return false;
				}
				else {
					var tablelen = $("#serTable tbody tr").length;
					if (!validatform(tablelen)) {
				
					}else {	
						
						var dataString ="cid="+cid+"&id="+val+"&action=getser";
						$.ajax({
							type: 'POST',
							url: 'ajax/billajax.php',
							timeout: 100000,
							data:dataString,	
							success: function(server_response){
								$("#tbody").append(server_response);	
								$("#EmployeeDropDown, .EmployeeDropDown").select2();
								update_cost();
								update_gst();
								update_dis();
								total_amt();
								 add_chars();
								 $('#ServiceDropDown').select2('destroy');
$('#ServiceDropDown').val('-1').select2();
								// $('#ServiceDropDown').select2("val", "null");
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
				}					
			});
			$("body").on("change","#PaymentMode",function() {
				var val= $(this).val();
				
				if(val.trim() == "CI") {
					$(".colpaym2").remove();
				}
				else {
				 $('.colpaym').parent().append("<tr class='colpaym2'><th  style='text-align:right;width:40%'>Tx Ref.No </th><th colspan='2' style='text-align:right'><input type='text' name='txref' id='txref' value='' class='form-control'/></th></tr>");
				}
			});
			$("body").on("change","#PromoDropDown",function() {
				$(".adrw").remove();
				var val =$(this).val();
				 var wholediscount = $(".wholediscount").val();
				if(val=="-1") {
					$("#campval").val(0.00);
					dis = "0.00";
					total_amt_with_promo(dis);
				//	$("#Total, #TotalS").val(parseFloat(total.trim())-parseFloat(0.00)-parseFloat(wholediscount));	
				}
				else {
					
					//alert(total);
					  var total =$("#Total").val();
					var dataString ="total="+total+"&id="+val+"&action=promodiscount";
					$.ajax({
						type: 'POST',
						url: 'ajax/billajax.php',
						timeout: 100000,
						data:dataString,	
						success: function(server_response){
						   var dis =  parseFloat(server_response).toFixed(2);
						  // alert(dis);
						   total_amt_with_promo(dis);
							$("#Total, #TotalS").val( Math.round(parseFloat(total.trim())-parseFloat(server_response.trim())-parseFloat(wholediscount)));
							
						//	alert($('.colpr').parent().find('.tr').html());
							$('.colpr').parent().append("<tr class='adrw'><th  style='text-align:right;width:40%'>Camp.Disc </th><th colspan='2' style='text-align:right'><input type='hidden' name='camp' id='campval' value='"+dis+"' />"+dis+"</th></tr>");
							
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
			function addCommas(nStr)
			{
				nStr += '';
				x = nStr.split('.');
				x1 = x[0];
				x2 = x.length > 1 ? '.' + x[1] : '';
				var rgx = /(\d+)(\d{3})/;
				while (rgx.test(x1)) {
					x1 = x1.replace(rgx, '$1' + ',' + '$2');
				}
				return x1 + x2;
			}
			$("body").on("click",".getcustomer",function() {
				var cid = $("#CustomerDropDown").val();
				if(cid < 0){
					alert("Customer should be selcted");
					 $("#CustomerDropDown").focus();
					return false;
				}
			});
			$("body").on("click",".getinvoice",function() {
				var val = $(this).attr('id');
				var cid = $("#CustomerDropDown").val();
				var dataString ="cid="+cid+"&id="+val+"&action=getinvoicem";
				if(cid > 0){
					$.ajax({
							type: 'POST',
							url: 'ajax/billajax.php',
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
				}
				else {
					alert("Customer should be selcted");
					$("#CustomerDropDown").focus();
					return false;
				}
			});
				$("body").on("change","#CustomerDropDown",function() {
					var val =$(this).val();
					var tablelen = $("#serTable tbody tr").length;
					//alert(tablelen);
					if(parseInt(tablelen) <= 0) {
						var text =$(this).find('option:selected').text();
					//	var val = $(this).attr('id');
					var dataString ="id="+val+"&action=getcusdet";
					$("#lastinid").val("");
					$.ajax({
							type: 'POST',
							url: 'ajax/billajax.php',
							timeout: 100000,
							data:dataString,	
							success: function(server_response){
							//	alert(server_response);
								$(".insidebody").html(server_response);								
								$(".getinvoice").attr("id",$("#lastinid").val());					
								
							},
							error: function(xhr, status, error) {
								if(status === "timeout") {
									alert("<p>TimeOut error Please Try After some time</P>");
								} else {
								   alert("<p>"+xhr.responseText+"</p>");
								}
							}
						});
					
						$("#customerName").val(text);
					$("#getcustomerdet").attr('id',val);
					}
					else {
						//	alert(tablelen);
						var co = confirm("Are you sure want to reset all services ?");
						if(co) {
							$("#serTable tbody tr, .adrw").remove();
							$("#WholeDiscount").val(0);
							$("#WholeDiscount, #campval").val(0);
							$("#PromoDiv").val("-1");
							update_cost();
							update_gst();
							update_dis();
							total_amt();
							add_chars();							
						}
						else {
							
						}
					}
			});
			
	function update_cost()
	{
		$('#TotalCost').val("");
		$('#TotalCostS').text("");
			var sum = 0.0;var cost =0.00;
			$('#serTable tbody tr').each(function() {				
				cost =  parseFloat($(this).find('.cost').val());
			//	alert(cost);
				sum+=cost
		});
		$('#TotalCost').val( (sum));
		$('#TotalCostS').text( (sum));
	}
	function add_chars()
	{
		$('#AddCharge').val("");
		$('#AddCharges').text("");
			var sum = 0.0;var adchar =0.00;
			$('#serTable tbody tr').each(function() {				
				adchar =  parseFloat($(this).find('.adchar').val());
			//	alert(cost);
				sum+=adchar
		});
		$('#AddCharge').val( (sum));
		$('#AddCharges').text( (sum));
	}
	function update_gst()
	{
			$('#TotalGST').val("");
			$('#TotalGSTS').text("");
			var sum = 0.0;var sum2 = 0.0;var cgst = 0.0;var sgst = 0.0;var cost = 0.0;
			$('#serTable tbody tr').each(function() {				
				var cgst = parseFloat($(this).find('.cgst').val());
				var sgst = parseFloat($(this).find('.sgst').val());
				var cost = parseFloat($(this).find('.cost').val());
				
				sum+=parseFloat(cgst) + parseFloat(sgst);
			});
			
		//just update the total to sum  
		$('#TotalGST').val( sum);
		$('#TotalGSTS').text( sum);
	}
	function validatform(length) {
		//alert(length);
		<!--var tablelen = $("#serTable tbody tr").length;
		/*alert(tablelen);
		if(tablelen <= 0) {
			 return true;
		}
		else {
			for(var i=0;i < tablelen;i++) {
				var name = $("#serTable tbody tr td input.serviceName");
				var EmployeeDropDown = $("#serTable tbody tr td select.EmployeeDropDown["+i+"]");
				alert("EmployeeDropDown"+"["+i+"]");
				if(name.val() == "") {
					alert("Service Name is required");
					name[i].focus();
					return false
				}
				else if(EmployeeDropDown.val().trim() == -1) {
					alert("Service Person Should be Selected");
					EmployeeDropDown.focus();
					return false;
				}
				else {
					return true;
				}
				
			}
		}*/
		
			var tablelen = $("#serTable tbody tr").length+1;
			var type =  $("input[name='type']:checked").val(); 
			var message = "";
			if(length == 1.5) {
				if(tablelen == 1) {
					alert("Please Selected Any Product First");
					focuscolor("#ServiceDropDown");
					message =  false;
				}

			}
			
			if(length <= 0) {
				 message =  true;
			}
			else {
				
				
				$('#serTable tbody tr').each(function() {						
					var servicePersion = $(this).find('.EmployeeDropDown');
					var cost =$(this).find('.cost'); 
					var discount  =$(this).find('.discount'); 
					var cgst  =$(this).find('.cgst'); 
					var sgst  =$(this).find('.sgst'); 
					var total  =$(this).find('.total'); 
					var addcharge  =$(this).find('.adchar'); 
					//alert(servicePersion.val());
					if(servicePersion.val() == "-1") {
						alert("Service Person Should be Selected");
						focuscolor(servicePersion);
						message =  false;
						$('#ServiceDropDown').select2('destroy');
						$('#ServiceDropDown').val('-1').select2();
					}
					else if(cost.val() == "" || cost.val() == null) {
						alert("Cost is Required");
						focuscolor(cost);
						window.location.reload();
						message =  false;
					}
					else if(addcharge.val() == "" || addcharge.val() == null) {
						alert("Cost is Required");
						focuscolor(addcharge);
						addcharge.val("0.00")
						message =  false;
					}
					else if(discount .val() == "" || discount .val() == null) {
						alert("Discount is Required");
						focuscolor(discount );
						discount .val("0.00")
						message =  false;
					}
					else if(cgst.val() == "" || cgst.val() == null) {
						alert("CGST is Required");
						focuscolor(cgst );
						cgst.val("0.00")
						message =  false;
					}
					else if(sgst.val() == "" || sgst.val() == null) {
						alert("SGST is Required");
						focuscolor(sgst );
						sgst.val("0.00")
						message =  false;
					}
					else if(total.val() == "" || total.val() == null) {
						alert("SGST is Required");
						focuscolor(sgst );
						window.location.reload();
						message =  false;
					}
					else {
						message = true;
					}
				});
				
		   }
		
		//alert(message);
	   return message; 
	}
	function validate_form2() {
		var customer = $("#CustomerDropDown").val();
		var codi =$("#campval").val(); 
	   var ser = $("#ServiceDropDown").val();
		var type =  $("input[name='type']:checked").val(); 
		//alert(type);
		var prom = $("#PromoDropDown").val(); 
		var paymentmode = $("#PaymentMode").val(); 
		var txref = $("#txref").val(); 
		var message = "";
		//alert(message);
		var type =  $("input[name='type']:checked").val(); 
		if((type != null) ||(type = "undefined") ) {
			
			if(((type.trim() != "S") && (type.trim() != "C")) || (type.trim() == 'undefined') || (type.trim() ==null)) {
				alert("Bill Type (Customer/Staff) should be selected");
				focuscolor("#type" );
				$("#type, #type2").focus();
				message =  false;
				
			}
			else if(customer.trim() == -1 || customer.trim() == "-1" || customer.trim() ==null ) {
				alert("Customer should be selected");
				focuscolor("#CustomerDropDown" );
				message =  false;
			}
			else if(prom.trim() != -1 || prom.trim() != "-1" ) {
				if(codi == "") {
					window.location.reload();
				}
				else {
					message =  true;
				}
			}
			
			else if(paymentmode != "CI") {
				if(txref == "") {
					//window.location.reload();		
					focuscolor("#txref" );
					alert("Transaction Reference Required");
					message =  false;
				}
				else {
					message =  true;
				}
			}
			else {
				message =  true;
			}
		//	alert(message);
			
		}
		else {
			alert("Bill Type (Customer/Staff) should be selected");
			focuscolor("#type" );
			$("#type, #type2").focus();
			message =  false;
		}	
		return message; 
	}
	function focuscolor(id)	{
    	$(id).focus();
    	$(id).css("background-color","#ffb3b3");
    }

	function total_amt()
	{
			$('#Total').val("");
			$('#TotalS').text("");
			var payamt = $(".payamt").val();
			var val =$("#PromoDropDown").val();
			var camp = $("#campval").val();
			//alert(camp);
			//var TotalDiscount =  $("#TotalDiscount").val();
			if(val=="-1" ||val=="undefined" ) {
				camp = 0.00;
			}
			//alert(camp);
			var wholediscount = parseFloat($(".wholediscount").val());
			var sum = 0.0;var sum2 = 0.0;var cgst = 0.0;var sgst = 0.0;var cost = 0.0;
			$('#serTable tbody tr').each(function() {				
				var total = parseFloat($(this).find('.total').val());
				sum+=parseFloat(total);
			});			
		//just update the total to sum  
		$('#Total').val( Math.round(sum-wholediscount-parseFloat(camp)));
		$('#TotalS').text( Math.round(sum-wholediscount-parseFloat(camp)));
		$(".balamt").val( Math.round(sum-wholediscount-parseFloat(camp)-payamt));
	}
		function total_amt_after_promo(dis)
	{
			$('#Total').val("");
			$('#TotalS').text("");
			var payamt = $(".payamt").val();
			var TotalDiscount =  $("#TotalDiscount").val();
			var val =$("#PromoDropDown").val();
			//alert(camp);
			var wholediscount = parseFloat($(".wholediscount").val());
			var sum = 0.0;var sum2 = 0.0;var cgst = 0.0;var sgst = 0.0;var cost = 0.0;
			$('#serTable tbody tr').each(function() {				
				var total = parseFloat($(this).find('.total').val());
				sum+=parseFloat(total);
			});			
		//just update the total to sum  
		$('#Total').val( Math.round(sum-wholediscount-parseFloat(dis)));;
		$('#TotalS').text( Math.round(sum-wholediscount-parseFloat(dis)));;
		$(".balamt").val( Math.round(sum-wholediscount-parseFloat(dis)-payamt));;
	}
	function total_amt_pay(payamt)
	{
			$('#Total').val("");
			$('#TotalS').text("");
			var val =$("#PromoDropDown").val();
			var camp = $('#campval').val();
			if(val=="-1") {
				camp = 0.00;
			}
			
			
			payamt = $(".payamt").val()
			var wholediscount = $(".wholediscount").val();
			var sum = 0.0;var sum2 = 0.0;var cgst = 0.0;var sgst = 0.0;var cost = 0.0;
			$('#serTable tbody tr').each(function() {				
				var total = parseFloat($(this).find('.total').val());
				sum+=parseFloat(total);
			});			
		//just update the total to sum  
		$('#Total').val(Math.round(sum-camp-wholediscount));
		$('#TotalS').text(Math.round(sum-camp-wholediscount));
		$(".balamt").val(Math.round(sum-camp-wholediscount-payamt));
	}
		function total_amt_with_promo(dis)
	{
		
			total_amt_after_promo(dis);
			var wholediscount = $(".wholediscount").val();
			var sum = 0.0;var sum2 = 0.0;var cgst = 0.0;var sgst = 0.0;var cost = 0.0;
			$('#serTable tbody tr').each(function() {				
				var total = parseFloat($(this).find('.total').val());
				sum+=parseFloat(total);
			});			
			
			$('#Total').val(Math.round(sum-dis-wholediscount));
			$('#TotalS').text(Math.round(sum-dis-wholediscount));
	}
	function update_dis()	{
		var sum = 0.0;var discount =0.00;
		$('#serTable tbody tr').each(function() {				
			discount =  parseFloat($(this).find('.discount').val());
			//alert(cost);
			sum+=discount
		});
		$('#TotalDiscount').val(sum);
		$('#TotalDiscountS').text(sum);
	}
		
	
		$("table").on('click',".delete", function (e) {
			$(this).parent().parent().parent().remove();	
			$("#ServiceDropDown option:selected").removeAttr('selected');
			update_cost();
			update_gst();
			update_dis();
			total_amt();
			 add_chars();
		});
		$("table").on('keyup',".discount", function (e) {
			var discount = $(this).val();		
			
			var trlength = $("#serTable tbody tr").length;
			//alert(trlength);
			if(trlength >0) {
				$("#submit").attr("disabled",false);
			}
			else {
				$("#submit").attr("disabled",true);
			}
		
			var cost = $(this).parent().parent().find('td input.cost').val();	
			var adchar = $(this).parent().parent().find('td input.adchar').val();	
			var sgst = $(this).parent().parent().find('td input.cg').val();	
			var cgst = $(this).parent().parent().find('td input.sg').val();	
			var codfin = parseFloat(cost) ;
			var adcharpars = parseFloat(adchar) ;
			//alert(cgst);
			var cgfin = ((parseFloat(cost) + parseFloat(adcharpars) - parseFloat(discount)) * (cgst/100));
			//alert(cgfin);
			var sgfin = ((parseFloat(cost) + parseFloat(adcharpars) - parseFloat(discount)) * (sgst/100));
			total = codfin + adcharpars + cgfin + sgfin;
			total = total- 	discount;
			$(this).parent().parent().find('td input.cgst').val(cgfin.toFixed(2));	
			$(this).parent().parent().find('td input.sgst').val(sgfin.toFixed(2));	
			$(this).parent().parent().find('td input.total').val(total.toFixed(2));	
			update_cost();
			update_gst();
			update_dis();
			total_amt();
			 add_chars();
		});
		
		
		$("table").on('keyup',".adchar", function (e) {
			var adchar = $(this).val();		
			//alert(adchar);
			var trlength = $("#serTable tbody tr").length;
			//alert(trlength);
			if(trlength >0) {
				$("#submit").attr("disabled",false);
			}
			else {
				$("#submit").attr("disabled",true);
			}
				
			var cost = $(this).parent().parent().find('td input.cost').val();	
			var discount = $(this).parent().parent().find('td input.discount').val();	
			var sgst = $(this).parent().parent().find('td input.cg').val();	
			var cgst = $(this).parent().parent().find('td input.sg').val();	
			var codfin = parseFloat(cost) ;
			var adcharpars = parseFloat(adchar) ;
			//alert((((parseFloat(cost) + parseFloat(adcharpars)))));
			var cgfin = (((parseFloat(cost) + parseFloat(adcharpars)) - parseFloat(discount)) * (cgst/100));
			//alert(cgfin);
			var sgfin = (((parseFloat(cost) + parseFloat(adcharpars)) - parseFloat(discount)) * (sgst/100));
			total = codfin + adcharpars+ cgfin + sgfin;
			total = total - discount;
			$(this).parent().parent().find('td input.cgst').val(cgfin.toFixed(2));	
			$(this).parent().parent().find('td input.sgst').val(sgfin.toFixed(2));	
			$(this).parent().parent().find('td input.total').val(total.toFixed(2));	
			update_cost();
			update_gst();
			update_dis();
			total_amt();
			 add_chars();
		});
		
	
	$("table").on('keyup',".payamt, .wholediscount", function (e) {
		total_amt_pay();
		
	});
	$("table").on('keyup',".sgst", function (e) {
			var trlength = $("#serTable tbody tr").length;
			//alert(trlength);
			if(trlength >0) {
				$("#submit").attr("disabled",false);
			}
			else {
				$("#submit").attr("disabled",true);
			}
			var discount = $(this).parent().parent().find('td input.discount').val();			
			var cost = $(this).parent().parent().find('td input.cost').val();	
			var sgst = $(this).val();	
			var cgst = $(this).parent().parent().find('td input.cgst').val();	
			var total = cost + (sgst) +  (cgst);
			total = total- 	discount;
			$(this).parent().parent().find('td input.total').val(total.toFixed(2));	
			update_cost();
			update_gst();
			update_dis();
			total_amt();
			 add_chars();
	});
	$("#Ok").click(function() {
		window.location.reload();
	});
	$(".select2-container--focus ,.select2, .select2-container, .select2-container--default, .select2-container--focus").css("width","2000px !important");	

	$("table").on('keyup',".cgst", function (e) {
			var trlength = $("#inVoiceOrderTable tbody tr").length;
			//alert(trlength);
			if(trlength >0) {
				$("#GenerateOrder").attr("disabled",false);
			}
			else {
				$("#GenerateOrder").attr("disabled",true);
			}
			var discount = $(this).parent().parent().find('td input.discount').val();			
			var cost = $(this).parent().parent().find('td input.cost').val();	
			var sgst = $(this).parent().parent().find('td input.sgst').val();	
			var cgst = $(this).val();
			var total = cost + (sgst) +  (cgst);
			total = total- 	discount;
			$(this).parent().parent().find('td input.total').val(total.toFixed(2));	
			update_cost();
			update_gst();
			update_dis();
			total_amt();
			 add_chars();
	});
		$("table").on('keyup',".cost", function (e) {
			var trlength = $("#inVoiceOrderTable tbody tr").length;
			//alert(trlength);
			if(trlength >0) {
				$("#GenerateOrder").attr("disabled",false);
			}
			else {
				$("#GenerateOrder").attr("disabled",true);
			}
			var discount = $(this).val();			
			var cost = $(this).parent().parent().find('td input.cost').val();	
			var sgst = $(this).parent().parent().find('td input.sgst').val();	
			var cgst = $(this).parent().parent().find('td input.cgst').val();
			var total = cost + (sgst) +  (cgst);
			total = total- 	discount;
			$(this).parent().parent().find('td input.total').val(total.toFixed(2));	
			update_cost();
			update_gst();
			update_dis();
			total_amt();
			 add_chars();
	});
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
					var dataString = $("#invoiceCustomerAddForm").serialize();
					dataString = dataString+"&action=createch"
				//	alert(dataString);
					$.ajax({
						type: 'POST',
						url: 'ajax/customerajax.php',
						timeout: 100000,
						data:dataString,	
						success: function(server_response){
						  var spl = server_response.split("[BRK]");
						   var spl1 = spl[1];
							var spl2 = spl[2];	
							var spl0 = spl[0];
							alert(spl1);
								//alert(spl2);
						  if(spl0 == 0 ) {
								loadcus2(spl2);
									  $("#newcustomer").modal('hide');
						  }
						   //$("#CustomerDropDown").val(spl2).change('tigger');
						 // $('#CustomerDropDown').val(spl2).trigger('change');// Change the value or make some change to the internal state
						//	$('#CustomerDropDown') //
						},
						error: function(xhr, status, error) {
							if(status === "timeout") {
								alert("<p>TimeOut error Please Try After some time</P>");
							} else {
							   alert("<p>"+xhr.responseText+"</p>");
							}
						}
					});	
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
					$(".membershipdiv").css("display","contents");
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
var myVar;

function myFunction() {
  myVar = setTimeout(showPage, 2000);
}


function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
}
function showPage2() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
}
function NumAndTwoDecimals(e , field) {
   var val = field.value;
   if(parseInt(val)) {
	   var re = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)$/g;
	   var re1 = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)/g;
		if (re.test(val)) {  } 
		else {
		  val = re1.exec(val);
		 if (val) {
		  field.value = val[0];
		  window.alert("Its Not Valid");
		  field.value="";
		   field.value = "0";
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

	</script>
	<!--scrolling js-->
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.js"> </script>
	<script src="js/jquery.nicescroll.js"></script>
<script type="text/javascript" src="./assets/scripts/main.js"></script>
	  <script>

	$("body").on("click","#Print",function() {
		var img ='<html>'+'<head>'+'<link rel="stylesheet" href="css/popup.css" type="text/css" media="screen" />'+
			'<link rel="stylesheet" type="text/css" href="css/default1.css"/>'+'<link rel="stylesheet" type="text/css" href="css/layout.css" media="screen" />'+
			'<style>table {font-size:14px;padding: 0.5%;font-size: 12px;} td {padding:5px;font-size:11px;font-family: monospace;}  hr {  border: 0;  clear:both;  display:block;  width: 100%; background-color:black;  height: 2px;border-bottom: 2px dotted #ccc; }p{margin:5px 0px}'+'#footer {'+'position: absolute;'+'bottom: 0;'+'width: 100%;'+'height: 100px;'+'}'+'</style>'+'<span class="header">'+'<p style="float:right;margin-top:0.4px"><?php echo date("Y-m-d H:i:s"); ?></p>'+'<p style="text-align:center;width:120px;margin:auto" ><img id ="myimg" src=\"logo/logo.png\" width="100px" height="40px"/></p>'+
			'<p style="text-align: center;font-size: 14px;font-weight: 100;">1st Floor</p>'+'<p style="text-align: center;font-size: 14px;font-weight: 100;"> Skyline Citadel, Kottayam - Kumily Rd,</p>'+'<p style="text-align: center;font-size: 14px;font-weight: 100;"> Opposite Plantation Corporation Junction, Kanjikuzhi, Kottayam, Kerala 686004</p>'+'<p style="text-align: center;font-size: 14px;font-weight: 100;">Phone: +91 9656400156</p>'+'</p>'+'<p style="text-align: center;font-size: 14px;font-weight: bold;">Tax Invoice</p>'+'</span>'+'</head>'+'<body>'+'<br>'+'<hr style="clear:both">';
			var inno = $("#inno").html();
			
			var dataString = "id="+inno+"&action=print";
			//alert(dataString);
			$.ajax({
				type: 'POST',
				url: 'ajax/printajax.php',
				
				timeout: 100000,
				data:dataString,	
				success: function(server_response){
				var win=window.open("","height=1000","width=1000");
				with(win.document){
				
				 open();
				  write(img+server_response+'<script>window.print();window.close();<\/script>');
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
</script>
</body>
</html>
<?php }  ?>