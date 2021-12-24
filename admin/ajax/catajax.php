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
					<th>Active </th>
					<th>Detail</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead> 
		<tbody>";
	$QUEY = "SELECT id, name, IF(active = 'Y','Yes','No') as active FROM tblcategories ORDER BY id";
	 error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	if($ret) {
		$co = mysqli_num_rows($ret);
		if($co > 0) {
			while ($row=mysqli_fetch_array($ret)) {
				
			echo "<tr> 
					<th scope='row'>".$row['id']."</th> 
					<td class='eve'>".$row['name']."</td> 
					<td class='cla'>".$row['active']."</td>
					<td><input type='button' data-toggle='modal' data-target='#view' class='btn btn-warning view' id='".$row['id']."' value='view'/></td>
					<td><input type='button' data-toggle='modal' data-target='#editmod' class='btn btn-primary edit' id='".$row['id']."' value='Edit'/> </td>
					<td><input type='button' class='btn btn-danger reject delete ' id='".$row['id']."' value='Delete'/></td>
				</tr>";
		}
		}
		else {
			echo "<tr><th colspan='6'>No Data Found</th> </tr>";
		}
	}
	else {
		echo "<tr><th colspan='6'>".mysqli_error($con)."</th> </tr>";
	}
echo "</tbody> </table> ";
 }
   if($action == "delete") {
	   $id =$_POST['id'];
	   $QUEY = "DELETE FROM tblcategories WHERE id = ".$id;
	 error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	if($ret) {
			echo  "0 [BRK] SERVICE  Deleted Successfully";
		}
		else {
			echo "-1 [BRK] SERVICE Deleted Failed..Please try again";
		}
   }
  if($action == "view") {
	$id = $_POST['id'];
	$query = "SELECT id, name, IF(active = 'Y','Yes','No') as active,create_time,update_time FROM tblcategories WHERE id = ".$id;
	error_log($query);
	$ret=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($ret);
	$id = $row['id'];
	$name = $row['name'];
	$active = $row['active'];
	$create_time = $row['create_time'];
	$update_time = $row['update_time'];
	echo "<div class='modal-body cusmodel'>						
					<table class='table table-bordered'>
						<thead>
							<tr>
								<th>id : $id </th>
								<th style='color:red'>Name : $name </th>
							</tr>
							 <th colspan='2'>Active : $active</th>
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
		$active = $_POST['active'];
		$query = "UPDATE tblcategories SET name = '$name', active = '$active', update_time = now() WHERE id = ".$id;
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
	 $query = "SELECT id, name,  active FROM tblcategories WHERE id = ".$id;
	error_log($query);
	$ret=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($ret);
	$name = $row['name'];
	$active = $row['active'];
	$cost = $row['cost'];
	echo "<div class='modal-body cusmodel'>	
				<form action='' method='POST' name='updateform' id='UpdateForm'>
					<table class='table table-bordered'>
						<thead>
							<tr>
							    <input type='hidden' name='id' class='form-control' value='$id'/>
								<th >Name : <input type='text' name='name' class='form-control' value='$name'/></th>
								<th >Active :<select name='active' class='form-control' id='Active'>
										<option value='Y' "; if(trim($active) == 'Y') { echo "selected"; } echo ">Yes</option>
										<option value='N'  "; if(trim($active) == 'N') { echo "selected"; } echo ">No</option>
									</select></th>
								
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