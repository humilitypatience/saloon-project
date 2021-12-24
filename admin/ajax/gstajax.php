<?php
error_reporting(0);
include('../includes/dbconnection.php');
$action = $_POST['action'];
 if($action == "load") {	
	 	echo "<table class='table table-bordered' id='table'> 
			<thead>
				<tr>
					<th>#</th>
					<th>GST Type</th>  
					<th>CGST</th>  
					<th>SGST</th>  
					<th>Active </th>
					<th>Create Time</th>
					<th>Detail</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead> 
		<tbody>";
	$QUEY = "SELECT id,gst_name, cgst, sgst, IF(active = 'Y','Yes','No') as active, create_time FROM saloon_gst ORDER BY id";
	 error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	if($ret) {
		$co = mysqli_num_rows($ret);
		if($co > 0) {
			while ($row=mysqli_fetch_array($ret)) {
				
			echo "<tr> 
					<th scope='row'>".$row['id']."</th> 
					<td class='eve'>".$row['gst_name']."</td> 
					<td class='eve'>".$row['cgst']."</td> 
					<td class='eve'>".$row['sgst']."</td> 
					<td class='eve'>".$row['active']."</td> 
					<td class='cla'>".$row['create_time']."</td>
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
	   $QUEY = "DELETE FROM saloon_gst WHERE id = ".$id;
	 error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	if($ret) {
			echo  "0 [BRK] Gst $gstname  Deleted Successfully";
		}
		else {
			echo "-1 [BRK] Gst $gstname  Deleted Failed..Please try again";
		}
   }
  if($action == "view") {
	   $id = $_POST['id'];
	 $query = "SELECT id, gst_name, cgst, sgst, IF(active = 'Y','Yes','No') as active, create_time, update_time FROM saloon_gst WHERE id = ".$id;
	error_log($query);
	$ret=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($ret);
	$id = $row['id'];
	$gst_name = $row['gst_name'];
	$cgst = $row['cgst'];
	$sgst = $row['sgst'];
	$active = $row['active'];
	$create_time = $row['create_time'];
	$update_time = $row['update_time'];
	echo "<div class='modal-body cusmodel'>						
					<table class='table table-bordered'>
						<thead>
							<tr>
								<th>Id : $id </th>
								<th style='color:red'>Name : $gst_name </th>
							</tr>
							<tr>
								<th style='color:blue'>CGST(%) : $cgst</th>
								<th style='color:blue'>SGST(%) : $sgst</th>
							</tr>
							
							<tr>
								<th colspan='4'>Active : $active</th>
								
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
		$gstname = $_POST['gstname'];
		$id = $_POST['id'];
		$cgst = $_POST['cgst'];
		$sgst = $_POST['sgst'];
		$active = $_POST['active'];
		$query = "UPDATE saloon_gst SET gst_name = '$gstname', cgst = '$cgst', sgst = '$sgst', active = '$active', update_time = now() WHERE id = ".$id;
		error_log($query);
		$ret=mysqli_query($con,$query);
		if($ret) {
			echo  "0 [BRK] Gst $gstname  Updated Successfully";
		}
		else {
			echo "-1 [BRK] Gst $gstname  Updated Failed..Please try again";
		}
	}
   if($action == "edit") {
	   $id = $_POST['id'];
	 $query = "SELECT id, gst_name, cgst, sgst,  active, create_time, update_time FROM saloon_gst WHERE id = ".$id;
	error_log($query);
	$ret=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($ret);
	$id = $row['id'];
	$gst_name = $row['gst_name'];
	$cgst = $row['cgst'];
	$sgst = $row['sgst'];
	$active = $row['active'];
	$create_time = $row['create_time'];
	$update_time = $row['update_time'];
	error_log($active);
	echo "<div class='modal-body cusmodel'>	
				<form action='' method='POST' name='updateform' id='UpdateForm'>
					<table class='table table-bordered'>
						<thead>
							<tr>
							 <input type='hidden' name='id' class='form-control' value='$id'/>
								<th>Name : <input type='text' name='gstname' class='form-control' value='$gst_name'/></th>
							</tr>
							<tr>
								<th>CGST : <input type='text' name='cgst' class='form-control' value='$cgst'/></th>
							</tr>
							<tr>
								<th>SGST : <input type='text' name='sgst' class='form-control' value='$sgst'/></th>
							</tr>
							<tr>
								<th>Active : 
									<select name='active' class='form-control' id='Active'>
										<option value='Y' "; if(trim($active) == 'Y') { echo "selected"; } echo ">Yes</option>
										<option value='N'  "; if(trim($active) == 'N') { echo "selected"; } echo ">No</option>
									</select>									
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
 ?>