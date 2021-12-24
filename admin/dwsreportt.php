 <?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['naturalsaid']==0)) {
  header('location:logout.php');
  } else{

   include 'Calendar.php';
$sdate = $_POST['fromdate'];
$edate = $_POST['todate'];

$calendar = new Calendar(date('y-m-d'));
$customerquery = "SELECT date(a.transaction_date) as transaction_date, total_amount FROM saloon_sale_transaction a, saloon_sales b, tblcustomers c WHERE a.invoice_no = b.invoice_no and date(a.transaction_date) between '$sdate' and '$edate' and b.customer_id = c.ID and a.bill_type = 'C' GROUP BY date(a.transaction_date)";
error_log("query ".$customerquery);
$customerresult = mysqli_query($con,$customerquery);
while($row = mysqli_fetch_assoc($customerresult)) {
	
	$calendar->add_event('Customer - '.$row['total_amount'],$row['transaction_date'] , 1, 'green');
	//$calendar->add_event($row['Name'].'Annivarsary ', $row['annivarsary_date'] , 1);
}

$staffquery = "SELECT date(a.transaction_date) as transaction_date, total_amount FROM saloon_sale_transaction a, saloon_sales b, tblcustomers c WHERE a.invoice_no = b.invoice_no and date(a.transaction_date) between '$sdate' and '$edate' and b.customer_id = c.ID and a.bill_type = 'S' GROUP BY date(a.transaction_date)";
error_log("query ".$staffquery);
$staffreslt = mysqli_query($con,$staffquery);
while($row = mysqli_fetch_assoc($staffreslt)) {
	
	$calendar->add_event('Staff - '.$row['total_amount'],$row['transaction_date'] , 1, 'green');
	//$calendar->add_event($row['Name'].'Annivarsary ', $row['annivarsary_date'] , 1);
}
	//$calendar->add_event('Customer', "2021-05-11" , 1, 'green');
  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>Naturals |  Date Wise Summary Reports</title>

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
<style>
h3 {
	text-align:center;
}
.stats-left {
    float: none;
    margin: auto;
    width: 100%;
    background-color: #4F52BA;
    text-align: center;
    padding: 10px ;
}
.col-md-6 {
    width: 50%;
    padding: 0px;
    border: 1px dotted;
}
.col-md-3 {
    width: 25%;
    padding: 1px;
}
.stats-left h4 {
    font-size: 1.5em;
    color: #fff;
    margin-top: 10px;
}
.calendar {
    display: flex;
    flex-flow: column;
}
.calendar .header .month-year {
    font-size: 20px;
    font-weight: bold;
    color: #636e73;
    padding: 20px 0;
}
.calendar .days {
    display: flex;
    flex-flow: wrap;
}
.calendar .days .day_name {
    width: calc(100% / 7);
    border-right: 1px solid #2c7aca;
    padding: 20px;
    text-transform: uppercase;
    font-size: 12px;
    font-weight: bold;
    color: #818589;
    color: #fff;
    background-color: #448cd6;
}
.calendar .days .day_name:nth-child(7) {
    border: none;
}
.calendar .days .day_num {
    display: flex;
    flex-flow: column;
    width: calc(100% / 7);
    border-right: 1px solid #e6e9ea;
    border-bottom: 1px solid #e6e9ea;
    padding: 15px;
    font-weight: bold;
    color: #7c878d;
    cursor: pointer;
    min-height: 100px;
}
.calendar .days .day_num span {
    display: inline-flex;
    width: 30px;
    font-size: 14px;
}
.calendar .days .day_num .event {
    margin-top: 10px;
    font-weight: 500;
    font-size: 14px;
    padding: 3px 6px;
    border-radius: 4px;
    background-color: #f7c30d;
    color: #fff;
    word-wrap: break-word;
}
.calendar .days .day_num .event.green {
    background-color: #51ce57;
}
.calendar .days .day_num .event.blue {
    background-color: #518fce;
}
.calendar .days .day_num .event.red {
    background-color: #ce5151;
}
.calendar .days .day_num:nth-child(7n+1) {
    border-left: 1px solid #e6e9ea;
}
.calendar .days .day_num:hover {
    background-color: #fdfdfd;
}
.calendar .days .day_num.ignore {
    background-color: #fdfdfd;
    color: #ced2d4;
    cursor: inherit;
}
.calendar .days .day_num.selected {
    background-color: #f1f2f3;
    cursor: inherit;
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
					<h3 class="title1"> Date Wise Summary Reports</h3>
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4> Date Wise Summary Reports:</h4>
						</div>
						<div class="form-body">
							<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="js/fullcalendar.min.css" />
<script src="js/lib/jquery.min.js"></script>
<script src="js/lib/moment.min.js"></script>
<script src="js/lib/fullcalendar.min.js"></script>

<script>

$(document).ready(function () {
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        events: "event.php",
        displayEventTime: false,
        eventRender: function (event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        },
    });
});

function displayMessage(message) {
	    $(".response").html("<div class='success'>"+message+"</div>");
    setInterval(function() { $(".success").fadeOut(); }, 1000);
}
</script>

<style>
body {
    margin-top: 50px;
    text-align: center;
    font-size: 12px;
    font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
}

#calendar {
    width: 700px;
    margin: 0 auto;
}

.response {
    height: 60px;
}

.success {
    background: #cdf3cd;
    padding: 10px 60px;
    border: #c3e6c3 1px solid;
    display: inline-block;
}
</style>
</head>
<body>
    <h2>Calendar Event Management </h2>

    <div class="response"></div>
    <div id='calendar'></div>
</body>


</html>
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