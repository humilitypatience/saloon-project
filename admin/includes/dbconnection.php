<?php
$con=mysqli_connect("localhost", "root", "M00nracker$1", "bpmsdb");
if(mysqli_connect_errno()){
echo "Connection Fail".mysqli_connect_error();
}
define("REPORT_SAVE_LOCATION",'E:/LOGSUMAR/');
  ?>
