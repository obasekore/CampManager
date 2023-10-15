<?php

$err = isset($_REQUEST['err']) ? $_REQUEST['err'] : NULL;
$errmsg = "";
$successmsg = "";

switch ($err) {
	case "logout":
	case "loggedout": {
		$successmsg = "You have successfully logged out";
		break;
	}
	case "invaliddetails": {
		$errmsg = "Invalid E-mail/Username or Password";
		break;
	}
	case "error": {
		$errmsg = "Error occurred! Unable to log you in at this time. Please try again";
		break;
	}
	case "emptyfield": {
		$errmsg = "Please enter your E-mail address/Username and Password";
		break;
	}
	case "accessdenied": {
		$errmsg = "Access denied! You need to login to continue";
		break;
	}
	case "resetsuccess": {
		$successmsg = "Password successfully changed.<br/> Please login with the new credential";
		break;
	}
}

?>
