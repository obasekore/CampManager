<?php

$err = isset($_REQUEST['err']) ? $_REQUEST['err'] : NULL;
$errmsg = "";
$successmsg = "";

switch ($err) {
	case "successDelegateAdded": {
		$successmsg = "Delegate Record Successfully Registered";
		break;
	}
	case "failAddNewDelegate": {
		$errmsg = "Error occurred! Unable to register Delegate. Please try again";
		break;
	}
	case "successDelegateMarked": {
		$successmsg = "Delegate Successfully Marked for this Camp";
		break;
	}
	case "fail2MarkDelegate": {
		$errmsg = "Error occurred! Unable to Marked Delegate for this Camp. Please try again";
		break;
	}
	case "successDelegateUpdated": {
		$successmsg = "Delegate Record Successfully Updated.";
		break;
	}
	case "failUpdateDelegate": {
		$errmsg = "Error occurred! Unable to Update Delegate's Record. Please try again";
		break;
	}
	case "successDelegateMarkedAndUpdated": {
		$successmsg = "Delegate Record Successfully Updated and Marked for this Camp.";
		break;
	}
	case "noSubmit": {
		$errmsg = "Error Occured! Please Fill required field and click submit";
		break;
	}
}

?>
