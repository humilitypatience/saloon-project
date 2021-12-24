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
					<th>Cost</th>  
					<th>Member Cost</th>  
					<th>Discount</th>  
					<th>Active </th>
					<th>Detail</th>
					<th>Edit Service</th>
					<th>Edit Incentive</th>
					<th>Delete</th>
				</tr>
			</thead> 
		<tbody>";
	$QUEY = "SELECT ID as id,ServiceName as name, Cost,member_cost, IF(discount_factor = 'P',CONCAT(discount,' %'),CONCAT('Rs.',discount)) as discount, IF(active = 'Y','Yes','No') as active FROM tblservices ORDER BY id";
	 error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	if($ret) {
		$co = mysqli_num_rows($ret);
		if($co > 0) {
			while ($row=mysqli_fetch_array($ret)) {
				
			echo "<tr> 
					<th scope='row'>".$row['id']."</th> 
					<td class='eve'>".$row['name']."</td> 
					<td class='eve'>".number_format($row['Cost'],2)."</td> 
						<td class='eve'>".number_format($row['member_cost'],2)."</td> 
					<td class='eve'>".$row['discount']."</td> 
					<td class='cla'>".$row['active']."</td>
					<td><input type='button' data-toggle='modal' data-target='#view' class='btn btn-warning view' id='".$row['id']."' value='view'/></td>
					<td><input type='button' data-toggle='modal' data-target='#editmod' class='btn btn-primary edit' id='".$row['id']."' value='Edit Service'/> </td>
						<td><input type='button' data-toggle='modal' data-target='#editinc' class='btn btn-warning editin' id='".$row['id']."' value='Edit Incentive'/> </td>
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
	    $QUEY = "DELETE FROM incentive_mapping WHERE service_id = ".$id;
	 error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	   $QUEY = "DELETE FROM tblservices WHERE ID = ".$id;
	 error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	if($ret) {
		 $id =$_POST['id'];
	  
			echo  "0 [BRK] SERVICE  Deleted Successfully";
		}
		else {
			echo "-1 [BRK] SERVICE Deleted Failed..Please try again";
		}
   }
   
   
  if($action == "view") {
	 $id = $_POST['id'];
	 $query = "SELECT create_time,update_time,member_cost, cgst, sgst, ID as id,ServiceName as name, Cost as cost, IF(discount_factor = 'P',CONCAT(discount,' %'),CONCAT('Rs. ',discount)) as discount, IF(active = 'Y','Yes','No') as active FROM tblservices WHERE ID = ".$id;
	error_log($query);
	$ret=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($ret);
	$id = $row['id'];
	$name = $row['name'];
	$cost = number_format($row['cost'],2);
	$discount = $row['discount'];
	$cgst = number_format($row['cgst'],2);
	$sgst = number_format($row['sgst'],2);
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
								<th style='color:blue'>Cost : $cost</th>
								<th style='color:blue'>Member Cost : $memcost</th>
							</tr>
							<tr>
								<th style='color:blue'>Discount : $discount</th>
								<th >Active : $active</th>								
							</tr>
							<tr>
								<th style='color:blue'>CGST : $cgst</th>
								<th style='color:blue'>SGST : $sgst</th>
							</tr>
							<tr>
								<th>Create Time  : $create_time</th>
								<th>Update Time : $update_time</th>
							</tr>
							
							
						</thead>
					</table>";
					
		 $query = "SELECT a.incentive_map_id as id,b.ServiceName as name,  IF(a.active = 'Y','Yes','No') as active,IF(a.amount_factor = 'P',CONCAT(a.rate,' %'),CONCAT('Rs.',a.rate)) as rate FROM incentive_mapping a, tblservices b WHERE a.service_id = b.ID and a.service_id = ".$id;
		error_log($query);
		$ret=mysqli_query($con,$query);
		
		$row=mysqli_fetch_assoc($ret);
		$count = mysqli_num_rows($ret);
		if($count > 0) {
			$id = $row['id'];
			$rate = $row['rate'];	
			$active = $row['active'];
			$create_time = $row['create_time'];
			$update_time = $row['update_time'];
		
				echo	"<br /><h3>Incentive Detail</h3><table class='table table-bordered'>
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
						</table>";
		}	
			echo	"</div>";
	}
    if($action == "update") {
		$name = $_POST['name'];
		$id = $_POST['id'];
		$discountfactor = $_POST['discountfactor'];
		$discount = $_POST['discount'];
		$active = $_POST['active'];
		$cgst = $_POST['cgst'];
		$cat = $_POST['cat'];
		$sgst = $_POST['sgst'];
		$memcost = $_POST['memcost'];
		$cost = $_POST['cost'];
		$query = "UPDATE tblservices SET categories_id = $cat, member_cost = '$memcost', ServiceName = '$name' , discount_factor = '$discountfactor', discount = '$discount', active = '$active', cost  = $cost,  cgst = '$cgst', sgst = '$sgst',update_time = now() WHERE ID = ".$id;
		error_log($query);
		$ret=mysqli_query($con,$query);
		if($ret) {
			echo  "0 [BRK] SERVICE $name  Updated Successfully";
		}
		else {
			echo "-1 [BRK] SERVICE $name  Updated Failed..Please try again";
		}
	}
   if($action == "edit") {
	   $id = $_POST['id'];
	 $query = "SELECT categories_id, cgst, sgst, ID as id,ServiceName as name, Cost as cost, member_cost, discount_factor, discount,  active FROM tblservices WHERE ID = ".$id;
	error_log($query);
	$ret=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($ret);
	
	$QUEY = "SELECT sgst, gst_name as name,cgst FROM saloon_gst ORDER BY id";
	error_log($QUEY);
	$ret2=mysqli_query($con,$QUEY );
	$ret3=mysqli_query($con,$QUEY );	
	$id = $row['id'];
	$name = $row['name'];
	$categories_id = $row['categories_id'];
	$discount_factor = $row['discount_factor'];
	$discount = $row['discount'];
	$cgst = $row['cgst'];
	$sgst = $row['sgst'];
	$member_cost = $row['member_cost'];
	$qry = "SELECT id, name FROM tblcategories ORDER BY id";
	$qryresult=mysqli_query($con,$qry );
	
	
	$active = $row['active'];
	$cost = $row['cost'];
	echo "<div class='modal-body cusmodel'>	
				<form action='' method='POST' name='updateform' id='UpdateForm'>
					<table class='table table-bordered'>
						<thead>
							<tr>
							    <input type='hidden' name='id' class='form-control' value='$id'/>
								<th >Name : <input type='text' name='name' class='form-control' value='$name'/></th>
								<th>Categories : 
								
									<select name='cat' class='form-control' id='CATDropDown'>";
										
										while ($rowcat=mysqli_fetch_assoc($qryresult)) {				
											echo "<option "; if(trim($categories_id) == $rowcat['id']) { echo "selected"; } echo " value = '".$rowcat['id']."'>".$rowcat['name']."</option>";
										}
									echo "</select>									
								</th>
								
								
							</tr>
							<tr>
								<th colspan='2' >Active :<select name='active' class='form-control' id='Active'>
										<option value='Y' "; if(trim($active) == 'Y') { echo "selected"; } echo ">Yes</option>
										<option value='N'  "; if(trim($active) == 'N') { echo "selected"; } echo ">No</option>
									</select></th>
							</tr>
							<tr>
								<th>Cost : <input type='text' name='cost' class='form-control' value='$cost'/></th>
								<th>Member Cost : <input type='text' name='memcost' class='form-control' value='$member_cost'/></th>
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
								<th>CGST : 
								
									<select name='cgst' class='form-control' id='CGST'>";
										while ($row=mysqli_fetch_assoc($ret2)) {				
											echo "<option "; if(trim($cgst) == $row['cgst']) { echo "selected"; } echo " value = '".$row['cgst']."'>".$row['name']."</option>";
										}
									echo "</select>									
								</th>
								<th>SGST: 
								<select name='sgst' class='form-control' id='SGST'>";
										while ($row=mysqli_fetch_assoc($ret3)) {				
											echo "<option "; if(trim($sgst) == $row['sgst']) { echo "selected"; } echo " value = '".$row['cgst']."'>".$row['name']."</option>";
										}
									echo "</select>	
								</th>								
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
 
    if($action == "updatein") {
		$name = $_POST['name'];
		$id = $_POST['id'];
		$ratefactor = $_POST['ratefactor'];
		$discount = $_POST['discount'];
		$active = $_POST['active'];
		$rate = $_POST['rate'];
		$cost = $_POST['cost'];
		$count = mysqli_num_rows($con);
		if($count > 0) {
			$query = "UPDATE incentive_mapping SET  rate = '$rate', amount_factor = '$ratefactor', active = '$active', update_time = now() WHERE incentive_map_id = ".$id;
		}
		else {
			$query = "INSERT INTO incentive_mapping(service_id, rate, amount_factor, active, create_time) 
												VALUE($id,'$rate','$ratefactor','$active',now())";
		}
		error_log($query);
		$ret=mysqli_query($con,$query);
		if($ret) {
			echo  "0 [BRK] Incenitve $name  Updated Successfully";
		}
		else {
			echo "-1 [BRK] Incenitve $name  Updated Failed..Please try again";
		}
	}
 
  if($action == "editin") {
	   $id = $_POST['id'];
	 $query = "SELECT a.incentive_map_id as id,b.ServiceName as name, b.ID, a.active,a.amount_factor, a.rate FROM incentive_mapping a, tblservices b WHERE a.service_id = b.ID and a.service_id =  ".$id;
	error_log($query);
	$ret=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($ret);	
	
	$ids = $row['id'];
	$name = $row['name'];
	$service_id = $row['ID'];
	$amount_factor = $row['amount_factor'];
	$rate = $row['rate'];
	
	
	
	$active = $row['active'];

	echo "<div class='modal-body cusmodel'>	
				<form action='' method='POST' name='updateform' id='UpdateForm'>
					<table class='table table-bordered'>
						<thead>
							<tr>
							    <input type='hidden' name='id' class='form-control' value='$ids'/>
								<input type='hidden' name='id' class='form-control' value='$id'/>
								<th style='text-align:center' colspan='2'><h3 style='color:red'>$name</h3></th>
								
								
								
							</tr>
							<tr>
							
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
						<button type='button' class='btn btn-primary updatein' >Update</button>
						<button type='button' class='btn btn-primary' data-dismiss='modal'>Close</button>
				   
				  </div>
				";
 }
 ?>