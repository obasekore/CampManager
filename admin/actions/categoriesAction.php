<?php
if (!isset($_SESSION)) {
	session_start();
}

require_once('../../Connections/config.php');
include_once('../../Library/auth.class.php');
include_once('../../Library/categories.class.php');
$TimeFormat='Y-m-d h:i:s';

if(isset($_REQUEST['submit']) and (($_REQUEST['submit']=='Create Category') or ($_REQUEST['submit']=='Update Category') or ($_REQUEST['submit']=='Delete Category')))
{		
	$category = new categories();

	if(isset($_REQUEST['nameCat']))
	{
		
		if(!isset($_REQUEST['from']))
		{
			$isAdded= $category->add($_REQUEST['nameCat'],$_REQUEST['descriptionCat'],date($TimeFormat),date($TimeFormat));
			if($isAdded)
			{
				header('location:../categories.php?err=success');
				die();
			}
			else
			{
				header('location:../categories.php?err=fail');
				die();	
			}
		}
		else if (isset($_REQUEST['from']) and $_REQUEST['submit']=='Update Category')
		{
			//Update Category here
			$isUpdated = $category->update($_REQUEST['id'],$_REQUEST['nameCat'],$_REQUEST['descriptionCat'],date($TimeFormat));
			if($isUpdated)
			{
				header('location:../categories.php?err=successUpdated');
				die();
			}
			else
			{
				header('location:../categories.php?err=failUpdate');
				die();	
			}
		}
	}
	else if($_REQUEST['submit']=='Delete Category')
	{
		$isDeleted = $category->delete($_REQUEST['id']);
		if($isDeleted)
		{
			header('location:../categories.php?err=successDeleted');
			die();
		}
		else
		{
			header('location:../categories.php?err=failDelete');
			die();	
		}
	}
	else
	{
		header('location:../categories.php?err=noCatName');
		die();
	}
	
}
else
{
	header('location:../categories.php?err=noSubmit');
	die();
}

