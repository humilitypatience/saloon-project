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
					<th>Create Time</th>
					<th>Detail</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead> 
		<tbody>";
	$QUEY = "SELECT ID,Name, MobileNumber, Gender, IF(active = 'Y','Yes','No') as active, CreationDate FROM tblcustomers ORDER BY ID";
	 error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	if($ret) {
		$co = mysqli_num_rows($ret);
		if($co > 0) {
			while ($row=mysqli_fetch_array($ret)) {
				
			echo "<tr> 
					<th scope='row'>".$row['ID']."</th> 
					<td class='eve'>".$row['Name']."</td> 
					<td class='eve'>".$row['MobileNumber']."</td> 
					<td class='eve'>".$row['Gender']."</td> 
					<td class='eve'>".$row['active']."</td> 
					<td class='cla'>".$row['CreationDate']."</td>
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
 
   if($action == "createch") {
		$name = trim($_POST['name']);
		$id =  trim($_POST['id']);
		$email =  trim($_POST['email']);
		$mobilenum =  trim($_POST['mobilenum']);
		$active =  trim($_POST['active']);
		$gender =  trim($_POST['gender']);
		$date =  trim($_POST['date']);
		$adate =  trim($_POST['adate']);
		$address = addslashes (mysqli_real_escape_string($con,$_POST['address']));
		$details =  trim($_POST['details']);
		$membertype =  trim($_POST['membertype']);
		
	$check_query = "SELECT MobileNumber FROM tblcustomers WHERE MobileNumber = '".trim($mobilenum)."'";
	error_log($check_query);
	$check_result = mysqli_query($con,$check_query);
	if($check_result) {
		$count = mysqli_num_rows($check_result);	
		if($count <= 0 ) {		
			if($membertype == "Y") {
					$member_from_date =$_POST['frommemdate']; 
					$member_to_date =$_POST['tomemdate']; 
					if($date != null && $adate != null && $date != "" && $adate != "" && !empty($date) && !empty($adate)) {
					 $Qy = "insert into  tblcustomers(address, member, member_from_date, member_end_date, Name,Email,MobileNumber,Gender,Details, active,CreationDate, birth_date, annivarsary_date) 
										value('$address','$membertype','$member_from_date','$member_to_date','$name','$email','$mobilenum','$gender','$details','Y', now(),'$date','$adate')";
					}
					if( ($date != "" &&  $adate == "") || ($date != null &&  $adate == null) || !empty($date) &&   empty($adate)) {
					 $Qy = "insert into  tblcustomers(address, member, member_from_date, member_end_date, Name,Email,MobileNumber,Gender,Details, active,CreationDate, birth_date, annivarsary_date) 
										value('$address','$membertype','$member_from_date','$member_to_date','$name','$email','$mobilenum','$gender','$details','Y', now(),'$date',null)";
					}
					if( ($date == "" &&  $adate != "") || ($date == null &&  $adate != null) || empty($date) &&  !empty($adate)) {
					 $Qy = "insert into  tblcustomers(address, member, member_from_date, member_end_date, Name,Email,MobileNumber,Gender,Details, active,CreationDate, birth_date, annivarsary_date) 
										value('$address','$membertype','$member_from_date','$member_to_date','$name','$email','$mobilenum','$gender','$details','Y', now(),null,'$adate')";
					}
					if( ($date == "" &&  $adate == "") || ($date == null &&  $adate == null) || empty($date) &&   empty($adate)) {
					 $Qy = "insert into  tblcustomers(address, member, member_from_date, member_end_date, Name,Email,MobileNumber,Gender,Details, active,CreationDate) 
										value('$address','$membertype','$member_from_date','$member_to_date','$name','$email','$mobilenum','$gender','$details','Y', now())";
					}
				}
				//error_log($membertype);
				if($membertype == "N") {
					error_log($date);error_log($adate);
				if($date != null && $adate != null && $date != "" && $adate != "" && !empty($date) && !empty($adate)) {
						$Qy = "insert into  tblcustomers(address, member, Name,Email,MobileNumber,Gender,Details, active,CreationDate, birth_date, annivarsary_date) 
										value('$address','$membertype','$name','$email','$mobilenum','$gender','$details','Y', now(),'$date','$adate')";
					}
					if( ($date != "" &&  $adate == "") || ($date != null &&  $adate == null) || !empty($date) &&   empty($adate)) {
						$Qy = "insert into  tblcustomers(address, member, Name,Email,MobileNumber,Gender,Details, active,CreationDate, birth_date) 
										value('$address','$membertype','$name','$email','$mobilenum','$gender','$details','Y', now(),'$date')";
					}
					if( ($date == "" &&  $adate != "") || ($date == null &&  $adate != null) || !empty($date) &&  !empty($adate)) {
						$Qy = "insert into  tblcustomers(address, member, Name,Email,MobileNumber,Gender,Details, active,CreationDate, annivarsary_date) 
										value('$address','$membertype','$name','$email','$mobilenum','$gender','$details','Y', now(),'$adate')";
					}
					if( ($date == "" &&  $adate == "") || ($date == null &&  $adate == null) || empty($date) &&   empty($adate)) {
						$Qy = "insert into  tblcustomers(address, member, Name,Email,MobileNumber,Gender,Details, active,CreationDate) 
										value('$address','$membertype','$name','$email','$mobilenum','$gender','$details','Y', now())";
					}
				}


		
		
			error_log($Qy);
			$ret=mysqli_query($con,$Qy);
			$id = mysqli_insert_id($con);
		//	error_log("sd".$id);
			if($ret) {
				echo  "0 [BRK] Customers $name - $mobilenum INSERTED Successfully  [BRK] $id";
			}
			else {
				echo "-1 [BRK] Customers $name - $mobilenum  INSERTED Failed..Please try again";
			}
			}
		else {
			echo "-1 [BRK] $mobilenum.already available.";  
		}
		}	
		else {
			echo "-1 [BRK]".(mysqli_error($con));  
		}
	
  }
  if($action == "create") {
		$name = trim($_POST['name']);
		$id =  trim($_POST['id']);
		$email =  trim($_POST['email']);
		$mobile =  trim($_POST['mobilenum']);
		$active =  trim($_POST['active']);
		$gender =  trim($_POST['gender']);
		$date =  trim($_POST['date']);
		$adate =  trim($_POST['adate']);
		$address = addslashes (mysqli_real_escape_string($con,$_POST['address']));
		$details =  trim($_POST['details']);
		$membertype =  trim($_POST['membertype']);
		if($membertype == "Y") {
					$member_from_date =$_POST['frommemdate']; 
					$member_to_date =$_POST['tomemdate']; 
					if($date != null && $adate != null) {
					 $Qy = "insert into  tblcustomers(address, member, member_from_date, member_end_date, Name,Email,MobileNumber,Gender,Details, active,CreationDate, birth_date, annivarsary_date) 
										value('$address','$membertype','$member_from_date','$member_to_date','$name','$email','$mobilenum','$gender','$details','Y', now(),'$date','$adate')";
					}
					if($date != null && $adate == null) {
					 $Qy = "insert into  tblcustomers(address, member, member_from_date, member_end_date, Name,Email,MobileNumber,Gender,Details, active,CreationDate, birth_date, annivarsary_date) 
										value('$address','$membertype','$member_from_date','$member_to_date','$name','$email','$mobilenum','$gender','$details','Y', now(),'$date',null)";
					}
					if($date == null && $adate != null) {
					 $Qy = "insert into  tblcustomers(address, member, member_from_date, member_end_date, Name,Email,MobileNumber,Gender,Details, active,CreationDate, birth_date, annivarsary_date) 
										value('$address','$membertype','$member_from_date','$member_to_date','$name','$email','$mobilenum','$gender','$details','Y', now(),null,'$adate')";
					}
					if($date == null && $adate == null) {
					 $Qy = "insert into  tblcustomers(address, member, member_from_date, member_end_date, Name,Email,MobileNumber,Gender,Details, active,CreationDate) 
										value('$address','$membertype','$member_from_date','$member_to_date','$name','$email','$mobilenum','$gender','$details','Y', now())";
					}
				}
					
				if($membertype == "N") {
					$member_from_date =NULL;
					$member_to_date =NULL;
					error_log($date);
					error_log($adate);
					if($date != null && $adate != null && $date != "" && $adate != "" && !empty($date) && !empty($adate)) {
						$Qy = "insert into  tblcustomers(address, member, Name,Email,MobileNumber,Gender,Details, active,CreationDate, birth_date, annivarsary_date) 
										value('$address','$membertype','$name','$email','$mobilenum','$gender','$details','Y', now(),'$date','$adate')";
					}
					if($date != null && !empty($date) && $date != "" &&  $adate == null && empty($adate) && $date == "") {
						$Qy = "insert into  tblcustomers(address, member, Name,Email,MobileNumber,Gender,Details, active,CreationDate, birth_date) 
										value('$address','$membertype','$name','$email','$mobilenum','$gender','$details','Y', now(),'$date')";
					}
					if($date == null && empty($date) && $date == "" &&  $adate != null && !empty($adate) && $date != "") {
						$Qy = "insert into  tblcustomers(address, member, Name,Email,MobileNumber,Gender,Details, active,CreationDate, annivarsary_date) 
										value('$address','$membertype','$name','$email','$mobilenum','$gender','$details','Y', now(),'$adate')";
					}
					if($date == null && empty($date) && $date == "" &&  $adate != null && !empty($adate) && $date != "") {
						$Qy = "insert into  tblcustomers(address, member, Name,Email,MobileNumber,Gender,Details, active,CreationDate) 
										value('$address','$membertype','$name','$email','$mobilenum','$gender','$details','Y', now())";
					}
				}

		
		error_log($query);
		$ret=mysqli_query($con,$query);
		if($ret) {
			echo  "0 [BRK] Customers $name  INSERTED Successfully";
		}
		else {
			echo "-1 [BRK] Customers $name  INSERTED Failed..Please try again";
		}
  }
   if($action == "delete") {
	   $id =$_POST['id'];
	   $QUEY = "DELETE FROM tblcustomers WHERE ID = ".$id;
	 error_log($QUEY);
	$ret=mysqli_query($con,$QUEY );
	if($ret) {
			echo  "0 [BRK] Customers  Deleted Successfully";
		}
		else {
			echo "-1 [BRK] Customers Deleted Failed..Please try again";
		}
   }
  if($action == "view") {
	 $id = $_POST['id'];
	 $query = "SELECT address, Details,ID, Name, Email, MobileNumber, Gender, member, date(member_from_date) as member_from_date, address, date(member_end_date) as member_end_date, IF(active = 'Y','Yes','No') as active, CreationDate, birth_date, annivarsary_date, UpdationDate FROM tblcustomers WHERE ID = ".$id;
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
	$UpdationDate = $row['UpdationDate'];
	$membertype = $row['member'];		
	$member_from_date =$row['member_from_date']; 
	$member_to_date =$row['member_end_date']; 	
	$address =$row['address']; 	
	$Details =$row['Details']; 	
	echo "<div class='modal-body cusmodel'>						
					<table class='table table-bordered'>
						<thead>
							<tr>
								<th>Id : $id </th>
								<th style='color:red'>Name : $Name </th>
							</tr>";
						if($membertype == "Y") {
							$sty = "style='display:contents'";
						}
						if($membertype == "N") {
							$sty = "style='display:none'";
						}
						echo "<tr class='membershipdiv' $sty>
								<th>MemberShip From Date : $member_from_date</th>
								<th>MemberShip To Date : $member_to_date</th>
								</tr>";
							
					
						
						echo	"
							<tr>
								<th style='color:blue'>Email : $Email</th>
								<th style='color:blue'>Mobile Number : $MobileNumber</th>
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
							
							<tr>
								<th>Details : $Details</th>
								<th>Address : $address</th>
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
		$active = $_POST['active'];
		$gender = $_POST['gender'];
		$date = $_POST['date'];
		$adate = $_POST['adate'];
		$details = $_POST['details'];
		$membertype = $_POST['membertype'];
		$address = $_POST['address'];
		if($membertype == "Y") {
			$member_from_date =$_POST['frommemdate']; 
			$member_to_date =$_POST['tomemdate']; 	
			if($date != null && $adate != null) {
				$query = "UPDATE tblcustomers SET address = '$address', member_from_date = '$member_from_date', member_end_date = '$member_to_date', member = '$membertype', Details = '$details' , Name = '$Name', Gender = '$gender',  Email = '$email', MobileNumber = '$mobile', active = '$active', UpdationDate = now() WHERE ID = ".$id;
			}
			else if($date != null && $adate == null) {
				$query = "UPDATE tblcustomers SET address = '$address', member_from_date = '$member_from_date', member_end_date = '$member_to_date', member = '$membertype', Details = '$details' , birth_date = '$date',  Name = '$Name', Gender = '$gender',  Email = '$email', MobileNumber = '$mobile', active = '$active', UpdationDate = now() WHERE ID = ".$id;
			}
			else if($date == null && $adate != null) {
				$query = "UPDATE tblcustomers SET address = '$address', member_from_date = '$member_from_date', member_end_date = '$member_to_date', member = '$membertype', Details = '$details' , annivarsary_date  = '$adate',  Name = '$Name', Gender = '$gender',  Email = '$email', MobileNumber = '$mobile', active = '$active', UpdationDate = now() WHERE ID = ".$id;
			}
			else if($date != null && $adate != null) {
				$query = "UPDATE tblcustomers SET address = '$address', member_from_date = '$member_from_date', member_end_date = '$member_to_date', member = '$membertype', Details = '$details' , annivarsary_date  = '$adate', birth_date  = '$ddate', Name = '$Name', Gender = '$gender',  Email = '$email', MobileNumber = '$mobile', active = '$active', UpdationDate = now() WHERE ID = ".$id;
			}
			else {
				$query = "UPDATE tblcustomers SET address = '$address', member_from_date = '$member_from_date', member_end_date = '$member_to_date', member = '$membertype', Details = '$details' , birth_date = '$date', annivarsary_date = '$adate',  Name = '$Name', Gender = '$gender',  Email = '$email', MobileNumber = '$mobile', active = '$active', UpdationDate = now() WHERE ID = ".$id;
			}
		}	
		if($membertype == "N") {
			$member_from_date =NULL;
			$member_to_date =NULL;
			if($date != null && $adate != null) {
				$query = "UPDATE tblcustomers SET address = '$address',  member = '$membertype', Details = '$details' , Name = '$Name', Gender = '$gender',  Email = '$email', MobileNumber = '$mobile', active = '$active', UpdationDate = now() WHERE ID = ".$id;
			}
			else if($date != null && $adate == null) {
				$query = "UPDATE tblcustomers SET address = '$address', member = '$membertype', Details = '$details' , birth_date = '$date',  Name = '$Name', Gender = '$gender',  Email = '$email', MobileNumber = '$mobile', active = '$active', UpdationDate = now() WHERE ID = ".$id;
			}
			else if($date == null && $adate != null) {
				$query = "UPDATE tblcustomers SET address = '$address', member = '$membertype', Details = '$details' , annivarsary_date  = '$adate',  Name = '$Name', Gender = '$gender',  Email = '$email', MobileNumber = '$mobile', active = '$active', UpdationDate = now() WHERE ID = ".$id;
			}
			else if($date != null && $adate != null) {
				$query = "UPDATE tblcustomers SET address = '$address', member = '$membertype', Details = '$details' , annivarsary_date  = '$adate', birth_date  = '$ddate', Name = '$Name', Gender = '$gender',  Email = '$email', MobileNumber = '$mobile', active = '$active', UpdationDate = now() WHERE ID = ".$id;
			}
			else {
				$query = "UPDATE tblcustomers SET address = '$address', Details = '$details' , birth_date = '$date', annivarsary_date = '$adate',  Name = '$Name', Gender = '$gender',  Email = '$email', MobileNumber = '$mobile', active = '$active', UpdationDate = now() WHERE ID = ".$id;
			}
		}
		
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
	 $query = "SELECT ID, Name, Email, MobileNumber, address, Gender, active, member, date(member_from_date) as member_from_date, date(member_end_date) as member_end_date, CreationDate, birth_date, Details, annivarsary_date FROM tblcustomers WHERE ID = ".$id;
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
	$member = $row['member'];
	$member_from_date = $row['member_from_date'];
	$member_end_date = $row['member_end_date'];
	$Details = $row['Details'];
	$address = $row['address'];
	echo "<div class='modal-body cusmodel'>	
				<form action='' method='POST' name='updateform' id='UpdateForm'>
					<table class='table table-bordered'>
						<thead>
							<tr>
							    <input type='hidden' name='id' class='form-control' value='$id'/>
								<th>Name : <input type='text' name='name' class='form-control' value='$Name'/></th>
								<th>Member : 
									<select class='form-control' name='membertype' id='MmeberType'>
										<option value='Y' "; if(trim($member) == 'Y') { echo "selected"; } echo ">Yes</option>
										<option value='N'  "; if(trim($member) == 'N') { echo "selected"; } echo ">No</option>
									</select>									
								</th>
								
								
							</tr>";
						if($member == "Y") {
							$sty = "style='display:contents'";
						}
						if($member == "N") {
							$sty = "style='display:none'";
						}
						echo "<tr class='membershipdiv' $sty>
								<th>MemberShip From Date : <input type='date' name='frommemdate' class='form-control' value='$member_from_date'/></th>
								<th>MemberShip To Date : <input type='date' name='tomemdate' class='form-control' value='$member_end_date'/></th>
								</tr>";
							
					
						
						echo	"<tr><th>Mobile : <input type='text' id='mobilenum' name='mobile' class='form-control' value='$MobileNumber'/></th>
						<th>E- mail : <input type='text' name='email' class='form-control' value='$Email'/></th></tr>
							<tr>
								
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
								<th > Memebership Details <textarea class='form-control' id='details' name='details' placeholder='Details'  cols='4'>$Details</textarea></th>
								<th > Address <textarea class='form-control' id='address' name='address' placeholder='Please Enter Address' required='true' rows='4' cols='4'>$address</textarea></th>
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