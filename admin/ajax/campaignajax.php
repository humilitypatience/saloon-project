<?php
error_reporting(0);
include('../includes/dbconnection.php');
$action = $_POST['action'];
 if($action == "load") {	
	 	echo "<table class='table table-bordered' id='table'> 
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>  
					<th>Discount</th>  
					<th>Start Date</th>  
					<th>End Date</th>  
					<th>Active </th>
					<th>Detail</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead> 
		<tbody>";
	$QUEY = "SELECT id,name, active, IF(discount_factor = 'P',CONCAT(discount,' %'),CONCAT('Rs. ',discount)) as discount, start_date, end_date,IF(active = 'Y','Yes','No') as active FROM saloon_campaign ORDER BY id";
	 error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	if($ret) {
		$co = mysqli_num_rows($ret);
		if($co > 0) {
			while ($row=mysqli_fetch_array($ret)) {
				
			echo "<tr> 
					<th scope='row'>".$row['id']."</th> 
					<td class='eve'>".$row['name']."</td> 
					<td class='eve'>".$row['discount']."</td> 
					<td class='eve'>".$row['start_date']."</td> 
					<td class='eve'>".$row['end_date']."</td> 
					<td class='cla'>".$row['active']."</td>
					<td><input type='button' data-toggle='modal' data-target='#view' class='btn btn-warning view' id='".$row['id']."' value='view'/></td>
					<td><input type='button' data-toggle='modal' data-target='#editmod' class='btn btn-primary edit' id='".$row['id']."' value='Edit'/> </td>
					<td><input type='button' class='btn btn-danger reject delete ' id='".$row['id']."' value='Delete'/></td>
				</tr>";
		}
		}
		else {
			echo "<tr><th colspan='9'>No Data Found</th> </tr>";
		}
	}
	else {
		echo "<tr><th colspan='9'>".mysqli_error($con)."</th> </tr>";
	}
echo "</tbody> </table> ";
 }
   if($action == "delete") {
	   $id =$_POST['id'];
	   $QUEY = "DELETE FROM saloon_campaign WHERE id = ".$id;
	 error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	if($ret) {
			echo  "0 [BRK] CAMPAIGN  Deleted Successfully";
		}
		else {
			echo "-1 [BRK] CAMPAIGN Deleted Failed..Please try again";
		}
   }
  if($action == "view") {
	 $id = $_POST['id'];
	 $query = "SELECT  detail, update_time, create_time, id,name, IF(discount_factor = 'P',CONCAT(discount,' %'),CONCAT('Rs. ',discount)) as discount, start_date, end_date,IF(active = 'Y','Yes','No') as active FROM saloon_campaign WHERE id = ".$id;
	error_log($query);
	$ret=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($ret);
	$id = $row['id'];
	$name = $row['name'];
	$discount = $row['discount'];
	$start_date = $row['start_date'];
	$end_date = $row['end_date'];
	$active = $row['active'];
	$create_time = $row['create_time'];
	$update_time = $row['update_time'];
	$detail = $row['detail'];
	echo "<div class='modal-body cusmodel'>						
					<table class='table table-bordered'>
						<thead>
							<tr>
								<th>Id : $id </th>
								<th style='color:red'>Name : $name </th>
							</tr>
							<tr>
								<th style='color:blue'>Discount : $discount</th>
								<th style='color:blue'>Active : $active</th>
							</tr>
							
							<tr>
								<th>Start Date : $start_date</th>			
								<th>End Date : $end_date</th>								
							</tr>
							
							<tr>
								<th>Create Time  : $create_time</th>
								<th>Update Time : $update_time</th>
							</tr>
							<tr>
								<th colspan='4'>Details  : $detail</th>
								
							</tr>
							
						</thead>
					</table>
				</div>";
 }
    if($action == "update") {
		$name = $_POST['name'];
		$id = $_POST['id'];
		$discountfactor = $_POST['discountfactor'];
		$discount = $_POST['discount'];
		$active = $_POST['active'];
		$gender = $_POST['gender'];
		$sdate = $_POST['sdate'];
		$edate = $_POST['edate'];
		$details = $_POST['details'];
		$query = "UPDATE saloon_campaign SET detail = '$details' , discount_factor = '$discountfactor', discount = '$discount', name = '$name', active = '$active',  start_date = '$sdate', end_date = '$edate',update_time = now() WHERE id = ".$id;
		error_log($query);
		$ret=mysqli_query($con,$query);
		if($ret) {
			echo  "0 [BRK] CAMPAIGN $name  Updated Successfully";
		}
		else {
			echo "-1 [BRK] CAMPAIGN $name  Updated Failed..Please try again";
		}
	}
   if($action == "edit") {
	   $id = $_POST['id'];
	 $query = "SELECT  detail,id, name, discount_factor, discount, start_date, end_date,IF(active = 'Y','Yes','No') as active FROM saloon_campaign WHERE id = ".$id;
	error_log($query);
	$ret=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($ret);
	$id = $row['id'];
	$name = $row['name'];
	$discount_factor = $row['discount_factor'];
	$discount = $row['discount'];
	$start_date = $row['start_date'];
	$end_date = $row['end_date'];
	$active = $row['active'];
	$detail = $row['detail'];
	echo "<div class='modal-body cusmodel'>	
				<form action='' method='POST' name='updateform' id='UpdateForm'>
					<table class='table table-bordered'>
						<thead>
							<tr>
							    <input type='hidden' name='id' class='form-control' value='$id'/>
								<th colspan='4'>Name : <input type='text' name='name' class='form-control' value='$name'/></th>
								
							</tr>
							<tr>
								<th>Discount Factor : <p style='padding-top: 10px; font-size: 15px'> 
											<input type='radio' name='discountfactor' id='discountfactor' value='P'  "; if(trim($discount_factor) == 'P') { echo "checked='true'"; } echo " >
											Percentage
										</label>
										<label>
											<input type='radio' name='discountfactor' id='discountfactor' value='A' "; if(trim($discount_factor) == 'A') { echo "checked='true'"; } echo " >
											Amount
										</label>
										
										</th>
								<th>Discount : <input type='text' name='discount' class='form-control' value='$discount'/></th>
							</tr></tr>
								<th>Start Date : <input type='date' name='sdate' class='form-control' value='$start_date'/></th>
								<th>End Date : <input type='date' name='edate' class='form-control' value='$end_date'/></th>								
							</tr>
							<tr>	
								<th style='vertical-align: initial;'>Active : 
									<select name='active' class='form-control' id='Active'>
										<option value='Y' "; if(trim($active) == 'Y') { echo "selected"; } echo ">Yes</option>
										<option value='N'  "; if(trim($active) == 'N') { echo "selected"; } echo ">No</option>
									</select>									
								</th>
								<th> Details <textarea value='sd' type='text' class='form-control' id='details' name='details' placeholder='Details' required='true' rows='4' cols='4'>$detail</textarea></th>
							</tr>
						</thead>
					</table>
				</form>
			</div>
			<div class='modal-footer' style='text-align:center'>
						<button type='button' class='btn btn-primary update' >Update</button>
						<button type='button' class='btn btn-primary' data-dismiss='modal'>Close</button>
				   
				  </div>
				";
 }
 ?>