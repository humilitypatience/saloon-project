<?php
error_reporting(0);
include('../includes/dbconnection.php');
$action = $_POST['action'];
 if($action == "load") {	
	 	echo "<table class='table table-bordered' id='table'> 
			<thead>
				<tr>
					<th>#</th>
					<th>Service</th>  
					<th>Incentive Amount</th>  					
					<th>Active</th>  		
					<th>Detail</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead> 
		<tbody>";
	$QUEY = "SELECT a.incentive_map_id as id,b.ServiceName as name, IF(a.active = 'Y','Yes','No') as active, IF(a.amount_factor = 'P',CONCAT(a.rate,' %'),CONCAT('Rs.',a.rate)) as rate FROM incentive_mapping a, tblservices b WHERE a.service_id = b.ID ORDER BY a.service_id";
	 error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	if($ret) {
		$co = mysqli_num_rows($ret);
		if($co > 0) {
			while ($row=mysqli_fetch_array($ret)) {
				
			echo "<tr> 
					<th scope='row'>".$row['id']."</th> 
					<td class='eve'>".$row['name']."</td> 
					<td class='eve'>".$row['rate']."</td> 
					<td class='eve'>".$row['active']."</td> 
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
	   $QUEY = "DELETE FROM incentive_mapping WHERE incentive_map_id = ".$id;
	 error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	if($ret) {
			echo  "0 [BRK] Incentive  Deleted Successfully";
		}
		else {
			echo "-1 [BRK] Incentive Deleted Failed..Please try again";
		}
   }
  if($action == "view") {
	 $id = $_POST['id'];
	 $query = "SELECT a.incentive_map_id as id,b.ServiceName as name,  IF(a.active = 'Y','Yes','No') as active,IF(a.amount_factor = 'P',CONCAT(a.rate,' %'),CONCAT('Rs.',a.rate)) as rate FROM incentive_mapping a, tblservices b WHERE a.service_id = b.ID and a.incentive_map_id = ".$id;
	error_log($query);
	$ret=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($ret);
	$id = $row['id'];
	$name = $row['name'];
	$rate = $row['rate'];
	$discount = $row['discount'];
	$active = $row['active'];
	$create_time = $row['create_time'];
	$update_time = $row['update_time'];
	$memcost = $row['member_cost'];
	echo "<div class='modal-body cusmodel'>						
					<table class='table table-bordered'>
						<thead>
							<tr>
								<th>Id : $id </th>
								<th style='color:red'>Name : $name </th>
							</tr>
							<tr>
								<th style='color:blue'>Amount : $rate</th>
								<th >Active : $active</th>	
							</tr>
							
							
							<tr>
								<th>Create Time  : $create_time</th>
								<th>Update Time : $update_time</th>
							</tr>
							
							
						</thead>
					</table>
				</div>";
 }
    if($action == "update") {
		$name = $_POST['name'];
		$id = $_POST['id'];
		$ratefactor = $_POST['ratefactor'];
		$discount = $_POST['discount'];
		$active = $_POST['active'];
		$cgst = $_POST['cgst'];
		$cat = $_POST['cat'];
		$sgst = $_POST['sgst'];
		$rate = $_POST['rate'];
		$cost = $_POST['cost'];
		$query = "UPDATE incentive_mapping SET service_id = $cat, rate = '$rate', amount_factor = '$ratefactor', active = '$active', update_time = now() WHERE incentive_map_id = ".$id;
		error_log($query);
		$ret=mysqli_query($con,$query);
		if($ret) {
			echo  "0 [BRK] Incenitve $name  Updated Successfully";
		}
		else {
			echo "-1 [BRK] Incenitve $name  Updated Failed..Please try again";
		}
	}
   if($action == "edit") {
	   $id = $_POST['id'];
	 $query = "SELECT a.incentive_map_id as id,b.ServiceName as name, b.ID, a.active,a.amount_factor, a.rate FROM incentive_mapping a, tblservices b WHERE a.service_id = b.ID and a.incentive_map_id =  ".$id;
	error_log($query);
	$ret=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($ret);	
	
	$id = $row['id'];
	$name = $row['name'];
	$service_id = $row['ID'];
	$amount_factor = $row['amount_factor'];
	$rate = $row['rate'];
	
	$qry = "SELECT ID, ServiceName FROM tblservices WHERE active = 'Y' and ID not in (SELECT service_id FROM incentive_mapping)";
	$qryresult=mysqli_query($con,$qry );
	
	
	$active = $row['active'];

	echo "<div class='modal-body cusmodel'>	
				<form action='' method='POST' name='updateform' id='UpdateForm'>
					<table class='table table-bordered'>
						<thead>
							<tr>
							    <input type='hidden' name='id' class='form-control' value='$id'/>
								<th style='text-align:center' colspan='2'><h3 style='color:red'>$name</h3></th>
								
								
								
							</tr>
							<tr>
							<th>Services : 
								
									<select name='cat' class='form-control' id='ServiceDropDown'>";
										
										while ($rowcat=mysqli_fetch_assoc($qryresult)) {				
											echo "<option "; if(trim($service_id) == $rowcat['ID']) { echo "selected"; } echo " value = '".$rowcat['ID']."'>".$rowcat['ServiceName']."</option>";
										}
									echo "</select>									
								</th>
								<th colspan='2' >Active :<select name='active' class='form-control' id='Active'>
										<option value='Y' "; if(trim($active) == 'Y') { echo "selected"; } echo ">Yes</option>
										<option value='N'  "; if(trim($active) == 'N') { echo "selected"; } echo ">No</option>
									</select></th>
							</tr>
							
							<tr>
								<th>Rate Factor : <p style='padding-top: 10px; font-size: 15px'> 
											<input type='radio' name='ratefactor' id='ratefactor' value='P'  "; if(trim($amount_factor) == 'P') { echo "checked='true'"; } echo " >
											Percentage
										</label>
										<label>
											<input type='radio' name='ratefactor' id='ratefactor' value='A' "; if(trim($amount_factor) == 'A') { echo "checked='true'"; } echo " >
											Amount
										</label>
										
										</th>
								<th>Incenitve Amount : <input type='text' name='rate' class='form-control' value='$rate'/></th>
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