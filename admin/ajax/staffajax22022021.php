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
					<th>Mobile Number</th>  
					<th>Gender</th>  
					<th>Active </th>
					<th>Password</th>
					<th>Detail</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead> 
		<tbody>";
	$QUEY = "SELECT ID,Name, MobileNumber, Gender, IF(active = 'Y','Yes','No') as active, role as rarole, CreationDate,IF(role!='S',(SELECT count(*) FROM tbladmin WHERE UserName = Name and MobileNumber = MobileNumber ),0) as count, IF(role = 'A','Admin',IF(role='S','Service Person','Others')) as role FROM saloon_employee ORDER BY ID";
	 error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	if($ret) {
		$co = mysqli_num_rows($ret);
		if($co > 0) {
			while ($row=mysqli_fetch_array($ret)) {
				
			echo "<tr> 
					<th scope='row'>".$row['ID']."</th> 
					<td class='eve'>".$row['Name']."(<b><span style='color:red'>".$row['role']."</span></b>)"."</td> 
					<td class='eve'>".$row['MobileNumber']."</td> 
					<td class='eve'>".$row['Gender']."</td> 
					<td class='eve'>".$row['active']."</td> 
					<td style='text-align:center' class='eve'>"; if($row['rarole'] !="S" && $row['count'] =='0') { echo "<input type='button' data-toggle='modal' data-target='#passwordview' class='btn btn-info passwordview' id='".$row['ID']."' value='ADMIN SETUP'/>"; } else {echo "-";} echo "</td> 
					<td><input type='button' data-toggle='modal' data-target='#view' class='btn btn-warning view' id='".$row['ID']."' value='view'/></td>
					<td><input type='button' data-toggle='modal' data-target='#editmod' class='btn btn-primary edit' id='".$row['ID']."' value='Edit'/> </td>
					<td><input type='button' class='btn btn-danger reject delete ' id='".$row['ID']."' value='Delete'/></td>
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
	   $QUEY = "DELETE FROM saloon_employee WHERE ID = ".$id;
	 error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	if($ret) {
			echo  "0 [BRK] Customers  Deleted Successfully";
		}
		else {
			echo "-1 [BRK] Customers Deleted Failed..Please try again";
		}
   }
	if($action == "submit") {
		$id = $_POST['pid'];
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];
		$query = "SELECT ID, Name, Email, MobileNumber, active, role FROM saloon_employee WHERE ID = ".$id;
		$ret=mysqli_query($con,$query );
		error_log($query);
		if($ret) {
			$num_rows = mysqli_num_rows($ret);
			if($num_rows > 0) {
				$row = mysqli_fetch_assoc($ret);
				$name = $row['Name'];
				$MobileNumber = $row['MobileNumber'];
				$Email = $row['Email'];
				$role = $row['role'];
				if($password == $repassword) {
					$password = md5($_POST['password']);
					$repassword = md5($_POST['repassword']);
					
					$insert_query = "INSERT INTO tbladmin(role,AdminName, UserName, MobileNumber, Email, Password) 
									 VALUES ('$role','$name','$name','$MobileNumber','$Email','$password')";
					$result=mysqli_query($con,$insert_query );
					error_log($insert_query);
					if($result) {
						echo "0 [BRK] Admin Setup Crated Successfully";
					}
					else {
						echo "-1 [BRK] ".mysqli_error($con);
					}
				}
				else {
					echo "-1 [BRK] Password mismatch";
				}
			}
			else {
				echo "-1 [BRK] No Data Found";
			}
		}
	}
  if($action == "view") {
	 $id = $_POST['id'];
	 $query = "SELECT ID, Name, Email, MobileNumber, Gender, IF(active = 'Y','Yes','No') as active, IF(role = 'A','Admin',IF(role='S','Service Person','Others')) as role, CreationDate, birth_date, annivarsary_date, UpdationDate FROM saloon_employee WHERE ID = ".$id;
	error_log($query);
	$ret=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($ret);
	$id = $row['ID'];
	$Name = $row['Name'];
	$Email = $row['Email'];
	$MobileNumber = $row['MobileNumber'];
	$Gender = $row['Gender'];
	$active = $row['active'];
	$role = $row['role'];
	$CreationDate = $row['CreationDate'];
	$birth_date = $row['birth_date'];
	$annivarsary_date = $row['annivarsary_date'];
	$UpdationDate = $row['UpdationDate'];
	echo "<div class='modal-body cusmodel'>						
					<table class='table table-bordered'>
						<thead>
							<tr>
								<th>Id : $id </th>
								<th>Name : $Name <span  style='color:red'>($role)</span></th>
							</tr>
							<tr>
								<th >Email : $Email</th>
								<th >Mobile Number : $MobileNumber</th>
							</tr>
							
							<tr>
								<th>Gender : $Gender</th>			
								<th>Active : $active</th>								
							</tr>
							
							<tr>
								<th>Birth Date : $birth_date</th>			
								<th>Annivarsary Date : $annivarsary_date</th>								
							</tr>
							
							<tr>
								<th>Create Time  : $CreationDate</th>
								<th>Update Time : $UpdationDate</th>
							</tr>
							
						</thead>
					</table>
				</div>";
 }
    if($action == "update") {
		$Name = $_POST['name'];
		$id = $_POST['id'];
		$email = $_POST['email'];
		$mobile = $_POST['mobile'];
		$role = $_POST['role'];
		$active = $_POST['active'];
		$gender = $_POST['gender'];
		$date = $_POST['date'];
		$adate = $_POST['adate'];
		$details = $_POST['details'];
		$query = "UPDATE saloon_employee SET role = '$role', Details = '$details' , birth_date = '$date', annivarsary_date = '$adate',  Name = '$Name', Gender = '$gender',  Email = '$email', MobileNumber = '$mobile', active = '$active', UpdationDate = now() WHERE ID = ".$id;
		error_log($query);
		$ret=mysqli_query($con,$query);
		if($ret) {
			echo  "0 [BRK] Customers $Name  Updated Successfully";
		}
		else {
			echo "-1 [BRK] Customers $Name  Updated Failed..Please try again";
		}
	}
   if($action == "edit") {
	   $id = $_POST['id'];
	 $query = "SELECT ID, Name, Email, MobileNumber, Gender, active, role,CreationDate, birth_date, Details, annivarsary_date FROM saloon_employee WHERE ID = ".$id;
	error_log($query);
	$ret=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($ret);
	$id = $row['ID'];
	$Name = $row['Name'];
	$Email = $row['Email'];
	$MobileNumber = $row['MobileNumber'];
	$Gender = $row['Gender'];
	$active = $row['active'];
	$CreationDate = $row['CreationDate'];
	$birth_date = $row['birth_date'];
	$annivarsary_date = $row['annivarsary_date'];
	$Details = $row['Details'];
	$role = $row['role'];
	echo "<div class='modal-body cusmodel'>	
				<form action='' method='POST' name='updateform' id='UpdateForm'>
					<table class='table table-bordered'>
						<thead>
							<tr>
							    <input type='hidden' name='id' class='form-control' value='$id'/>
								<th>Name : <input type='text' name='name' class='form-control' value='$Name'/></th>
								<th>E- mail : <input type='text' name='email' class='form-control' value='$Email'/></th>
							</tr>
							<tr>
								<th>Mobile : <input type='text' name='mobile' class='form-control' value='$MobileNumber'/></th>
								<th>Gender : <p style='padding-top: 20px; font-size: 15px'> 
											<input type='radio' name='gender' id='gender' value='Female'  "; if(trim($Gender) == 'Female') { echo "checked='true'"; } echo " >
											Female
										</label>
										<label>
											<input type='radio' name='gender' id='gender' value='Male' "; if(trim($Gender) == 'Male') { echo "checked='true'"; } echo " >
											Male
										</label>
										<label>
											<input type='radio' name='gender' id='gender' value='Transgender' "; if(trim($Gender) == 'Transgender') { echo "checked='true'"; } echo " >
										   Transgender
										</label>
										</p></th>
							</tr>
								<th>
									Role: <select class='form-control' name='role' id='role'>
										<option value='A' "; if(trim($role) == 'A') { echo "selected"; } echo ">Admin</option>
										<option value='S' "; if(trim($role) == 'S') { echo "selected"; } echo ">Service Person</option>
										<option value='O' "; if(trim($role) == 'O') { echo "selected"; } echo ">Others</option>
									</select>
								</th>
								<th>Active : 
									<select name='active' class='form-control' id='Active'>
										<option value='Y' "; if(trim($active) == 'Y') { echo "selected"; } echo ">Yes</option>
										<option value='N'  "; if(trim($active) == 'N') { echo "selected"; } echo ">No</option>
									</select>									
								</th>
								
							<tr>
								<th>Birth Date : <input type='date' name='date' class='form-control' value='$birth_date'/></th>
								<th>Annivarsary Date : <input type='date' name='adate' class='form-control' value='$annivarsary_date'/></th>
								
							</tr>
							<tr>
								
									<th colspan='2'> Memebership Details <textarea value='sd' type='text' class='form-control' id='details' name='details' placeholder='Details' required='true' rows='4' cols='4'>$Details</textarea></th>
								
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