<?php

$err = isset($_REQUEST['err']) ? $_REQUEST['err'] : NULL;
$errmsg = "";
$successmsg = "";

switch ($err) {
	case "success": {
		$successmsg = "Password successfully changed";
		break;
	}
	case "error": {
		$errmsg = "Error occurred! Unable to change password. Please try again";
		break;
	}
	case "emptyfield": {
		$errmsg = "Please fill all fields";
		break;
	}
	case "notprevpwd": {
		$errmsg = "Access denied! Unable to match previous password";
		break;
	}
	case "matchfail": {
		$errmsg="Error occurred! New and confirm password does not match";
		break;
	}
}

?>
