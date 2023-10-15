<?php
if (!isset($_SESSION)) {
	session_start();
}
require_once('../../Connections/config.php');
include_once("../../Library/settings.class.php");
include_once('../../Library/auth.class.php');
include_once('../../Library/expenditures.class.php');

$TimeFormat='Y-m-d h:i:s';

if(isset($_REQUEST['submit']) and (($_REQUEST['submit']=='Submit Withdrawal') or ($_REQUEST['submit']=='Update Withdrawal') or ($_REQUEST['submit']=='Delete Withdrawal')))
{
	$expenditure = new expenditures();
	if(isset($_REQUEST['name'],$_REQUEST['purpose'],$_REQUEST['phoneNumber'],$_REQUEST['amount']))
	{	
		if($_REQUEST['submit']=='Submit Withdrawal' and isset($_REQUEST['campId']))
		{

			$IsWithdrew = $expenditure->add($_REQUEST['campId'],$_REQUEST['name'],$_REQUEST['purpose'],$_REQUEST['phoneNumber'],$_REQUEST['amount'],date($TimeFormat),date($TimeFormat));
			if($IsWithdrew)
			{
				header('location:../expenditure.php?err=successWithdrawn');
				die();
			}
			else
			{
				//Error in adding new delegate
				header('location:../expenditure.php?err=failWithdrawal');
				die();
			}
		}
		else if($_REQUEST['submit']=='Update Withdrawal' and isset($_REQUEST['id']))
		{
			$IsWithdrewUpdated = $expenditure->update($_REQUEST['id'],$_REQUEST['name'],$_REQUEST['purpose'],$_REQUEST['phoneNumber'],$_REQUEST['amount'],date($TimeFormat));
			if($IsWithdrewUpdated)
			{
				header('location:../expenditure.php?err=updateSuccessWithdrawn');
				die();
			}
			else
			{
				//Error in adding new delegate
				header('location:../expenditure.php?err=updateFailWithdrawal');
				die();
			}
		}
		else if($_REQUEST['submit']=='Delete Withdrawal' and isset($_REQUEST['id']))
		{
			$isDeleted=$expenditure->delete($_REQUEST['id']);
			if($isDeleted)
			{
				header('location:../expenditure.php?err=successDeleted');
				die();
			}
			else
			{
				header('location:../expenditure.php?err=failDelete');
				die();
			}
		}
	}
}
?>