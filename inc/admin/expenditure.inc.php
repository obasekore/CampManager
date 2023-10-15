<?php

$err = isset($_REQUEST['err']) ? $_REQUEST['err'] : NULL;
$errmsg = "";
$successmsg = "";

switch ($err) {
	case "successWithdrawn": {
		$successmsg = "Withdrawal Successfully Recorded";
		break;
	}
	case "failWithdrawal": {
		$errmsg = "Error occurred! Unable to record Withdrawal. Please try again";
		break;
	}
	case "updateSuccessWithdrawn": {
		$successmsg = "Withdrawal Successfully Updated.";
		break;
	}
	case "updateFailWithdrawal": {
		$errmsg = "Error occurred! Unable to commit withdrawal Update. Please try again";
		break;
	}
	case "successDeleted": {
		$successmsg = "Withdrawal Record Successfully Deleted.";
		break;
	}
	case "failDelete": {
		$errmsg = "Error occurred! Unable to Delete Withdrawal's Record. Please try again";
		break;
	}
	case "noSubmit": {
		$errmsg = "Error Occured! Please Fill required field and click submit";
		break;
	}
}

?>
