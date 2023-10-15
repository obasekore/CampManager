<?php

if (!isset($_SESSION)) {
	session_start();
}

require_once("../../Connections/config.php");
include_once("../../Library/sqlsanitize.class.php");
include_once("../../Library/auth.class.php");
include_once("../../Library/__admin.class.php");
include_once("../../Library/utility.class.php");
include_once("../../inc/admin/dashboard.inc.php");

include_once("../../Library/validator.class.php");

if (isset($_POST['submit']) and ($_POST['submit'] == 'Change Password')) {
	if (isset($_POST['previousPassword'], $_POST['newPassword'], $_POST['confirmPassword']) and !empty($_POST['previousPassword']) and !empty($_POST['newPassword'])and !empty($_POST['confirmPassword'])) {
		
		$sanitizer = new SQLSanitizer();
		
		

		if(strcmp($_POST['newPassword'],$_POST['confirmPassword'])==0)
		{
			
			if($admin->isPasswordMatch($_POST['previousPassword']))
			{
				if($admin->changePassword($_POST['newPassword']))
				{
					
					header("location:../logout.php?err=resetsuccess");
					exit;
				}
				else
				{
					header("location:../pwdReset.php?err=error");
					exit;
				}
			}	
			else
			{
				
				header("location:../pwdReset.php?err=notprevpwd");
				exit;
			}	
		}
		else
		{
			header("location:../pwdReset.php?err=matchfail");
			exit;
		}
	}
	else 
	{
		header("location:../pwdReset.php?err=emptyfield");
		exit;
	}
} else {
	header("location:../pwdReset.php");
	exit;
}

?>
