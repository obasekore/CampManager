<?php

$err = isset($_REQUEST['err']) ? $_REQUEST['err'] : NULL;
$errmsg = "";
$successmsg = "";

switch ($err) {
	case "success": {
		$successmsg = "Camp successfully created registered";
		break;
	}
	case "noSubmit": {
		$errmsg = "Error Occured! Please Fill required field and click submit";
		break;
	}
	case "fail": {
		$errmsg = "Error occurred! Unable to register camp. Please try again";
		break;
	}
	case "noCatName": {
		$errmsg = "Please enter category name";
		break;
	}
	case "failUpdate": {
		$errmsg = "Update denied! Error in commiting Category Update";
		break;
	}
	case "failDelete": {
		$errmsg = "Error in Deleting Category!";
		break;
	}

	case "successUpdated": {
		$successmsg = "Category successfully Updated.";
		break;
	}
	case "successDeleted": {
		$successmsg = "Category successfully Deleted.";
		break;
	}

}

?>
