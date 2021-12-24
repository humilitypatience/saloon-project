<?php

	function generate_seq_num($seq, $con){
		$seq_no = -1;
		$seq_no_query = "SELECT get_invoice_sequence_num($seq) as seq_no";
		error_log("seq_no_query = ".$seq_no_query);
		$seq_no_result = mysqli_query($con, $seq_no_query);
		if(!$seq_no_result) {
			error_log("Error: get_invoice_sequence_num = ".mysqli_error($con));
			$seq_no = -1;
		}
		else {
			$seq_no_row = mysqli_fetch_assoc($seq_no_result);
			$seq_no = $seq_no_row['seq_no'];			
		}
		error_log("seq_no = ".$seq_no);
		return $seq_no;
	}
?>