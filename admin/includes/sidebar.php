 <style>
 .sidebar ul li a {
    color: #FFFFFF;
    font-size: 16px;
}

.nav > li > a {
    position: relative;
    display: block;
    padding: 6px 15px;
}
 </style>
 <?php session_start();  $role = $_SESSION['role']; //ERROR_REPORTING(E_ALL); error_log(  $role);?>
  <div class=" sidebar" role="navigation">
            <div class="navbar-collapse">
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
          <ul class="nav" id="side-menu">
		  	<?php if($role =='A') { ?>
            <li>
              <a href="dashboard.php"><i class="fa fa-home nav_icon"></i>Dashboard</a>
            </li>
			<li>
              <a href="summary.php"><i class="fa fa-check-square-o nav_icon"></i>Summary<span class="fa arrow"></span></a>
             
              <!-- //nav-second-level -->
            </li>
			<li>
              <a href="dwsreport.php"><i class="fa fa-check-square-o nav_icon"></i>Day wise Summary Report<span class="fa arrow"></span></a>
             
              <!-- //nav-second-level -->
            </li>
			<li>
              <a href="#"><i class="fa fa-check-square-o nav_icon"></i>Settings<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                 <li><a href="add-gst.php">Add GST</a></li>                   
                 <li><a href="manage-gst.php">Manage Gst</a></li>
				 <li><a href="add-campaign.php">Add Campaign</a></li>    
				 <li><a href="campaign.php">Manage Campaign</a></li>
              </ul>
              <!-- //nav-second-level -->
            </li>
			<?php } if($role !='S' || $role =='O'|| $role =='A') { ?>
			<li>
              <a href="#"><i class="fa fa-check-square-o nav_icon"></i>Invoice<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                 <li><a href="geninvoice.php">Invoice</a></li>           
				<li><a href="invoicereport.php">Invoice Report</a></li>      		
<li><a href="cainvoicereport.php">Canceled Invoice Report</a></li>      						
              </ul>
              <!-- //nav-second-level -->
            </li>
			<li>
              <a href="#"><i class="fa fa-check-square-o nav_icon"></i>Incentive<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                 <li><a href="incentive.php">Incentive</a></li>           
				 <li><a href="manage-incentive.php">Manage Incentive</a></li>      		
				<li><a href="incenreport.php">Incentive Report</a></li>      				 
              </ul>
              <!-- //nav-second-level -->
            </li>
			<?php } if($role =='A') { ?>
            <li>
              <a href="add-services.php"><i class="fa fa-cogs nav_icon"></i>Services<span class="fa arrow"></span> </a>
              <ul class="nav nav-second-level collapse">
                <li>
                  <a href="add-services.php">Add Services</a>
                </li>
                <li>
                  <a href="manage-services.php">Manage Services</a>
                </li>
				<li>
                  <a href="add-category.php">Add Category</a>
                </li>
				<li>
                  <a href="categories.php">Manage Categories</a>
                </li>
              </ul>
              <!-- /nav-second-level -->
            </li>
			 <?php } if($role !='S' || $role =='O'|| $role =='A') { ?>
		   <li>
              <a href="#"><i class="fa fa-user nav_icon"></i>Customers<span class="fa arrow"></span> </a>
              <ul class="nav nav-second-level collapse">
               
				<li>
                 <a href="add-customer.php">Add Customer</a>
                </li>
				<?php } if($role =='A') { ?>
                <li>
					<a href="customer.php">Customer List</a>
                </li>
              </ul>
              <!-- /nav-second-level -->
            </li>
			
			 <li>
              <a href="#"><i class="fa fa-user nav_icon"></i>Staffs<span class="fa arrow"></span> </a>
              <ul class="nav nav-second-level collapse">
                <li>
                 <a href="add-staff.php">Add Staff</a>
                </li>
                <li>
					<a href="staff-list.php">Staff List</a>
                </li>
              </ul>
              <!-- /nav-second-level -->
            </li>
			
              <li>
			
            <li class="">
              <a href="about-us.php"><i class="fa fa-book nav_icon"></i>Pages <span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                <li>
                  <a href="about-us.php">About Us</a>
                </li>
                <li>
                  <a href="contact-us.php">Contact Us</a>
                </li>
              </ul>
              <!-- /nav-second-level -->
            </li>
          
            <li>
              <a href="all-appointment.php"><i class="fa fa-check-square-o nav_icon"></i>Appointment<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                <li>
                  <a href="all-appointment.php">All Appointment</a>
                </li>
                <li>
                  <a href="new-appointment.php">New Appointment</a>
                </li>
                <li>
                  <a href="accepted-appointment.php">Accepted Appointment</a>
                </li>
                <li>
                  <a href="rejected-appointment.php">Rejected Appointment</a>
                </li>
              </ul>
              <!-- //nav-second-level -->
            </li>
           
        <li>
            
              <a href="#"><i class="fa fa-check-square-o nav_icon"></i>Reports<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
			
			   <li><a href="serhistory.php">Service Report</a></li>
			   <li><a href="salhistory.php">Sales Report</a></li>
				<li><a href="cbvhistory.php">Customer Report</a></li>
				<li><a href="cushistory.php">Customer Sales Report</a></li>
				<li><a href="staffhistory.php">Staff Report</a></li>
					<li><a href="cgreport.php">GST Report</a></li>
				<!--<li><a href="pshistory.php">Product Sale Report</a></li>
				<li><a href="stareport.php">Staff Report</a></li>
				 <li><a href="bwdates-reports-ds.php"> B/w dates</a></li>                   
				<li><a href="sales-reports.php">Sales Reports</a></li>-->
              </ul>
              <!-- //nav-second-level -->
            </li>

			   <li>
            
              <a href="#"><i class="fa fa-check-square-o nav_icon"></i>Print All<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
			
			   <li><a href="printall.php">Print All</a></li>
			   
              </ul>
              <!-- //nav-second-level -->
            </li>
			
            <li>
              <a href="search-appointment.php" class="chart-nav"><i class="fa fa-search nav_icon"></i>Search Appointment</a>
            </li>
           <?php } ?>
        
          </ul>
          <div class="clearfix"> </div>
          <!-- //sidebar-collapse -->
        </nav>
      </div>
    </div>