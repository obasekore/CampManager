<?php
//Determine admin's role
//get his menu
//compare if he is accessible
//else accessdenied page
include_once('../Library/roles.class.php');
$role = new roles($admin->getRole());
$active = explode('/',$active);
$active = $active[count($active)-1];
$accessDenied = $role->accessDenied($active);

if($accessDenied)
{
	header('location:accessDenied.php');
	die();
}

