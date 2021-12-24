<?php
   include('includes/dbconnection.php');

    $json = array();
    $event_query = "SELECT b.Name,  a.transaction_date as start, CONCAT(b.Name,'-',a.total_amount) as title FROM saloon_sale_transaction a , tblcustomers b WHERE a.customer_id = b.ID";

    $result = mysqli_query($con, $event_query);
    $eventArray = array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($eventArray, $row);
    }
    mysqli_free_result($result);

    mysqli_close($con);
    echo json_encode($eventArray);
	
	
	
	
?>