<?php

if (!isset($_SESSION)) {
	session_start();
}

include_once("../Library/auth.class.php");

$auth->destroyAdminAuth();

if(!empty($_REQUEST['err']) and $_REQUEST['err']=='resetsuccess')
{
	header('location:index.php?err=resetsuccess');
	exit;
}

header("location:index.php?err=logout");
exit;

?>
