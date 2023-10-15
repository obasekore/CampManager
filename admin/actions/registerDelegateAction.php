<?php
if (!isset($_SESSION)) {
	session_start();
}
require_once('../../Connections/config.php');
include_once("../../Library/settings.class.php");
include_once('../../Library/auth.class.php');
include_once('../../Library/delegatedetails.class.php');
include_once('../../Library/attendances.class.php');
include_once('../../Library/camps.class.php');
include_once('../../Library/campfee.class.php');

$TimeFormat='Y-m-d h:i:s';

if(isset($_REQUEST['submit']) and (($_REQUEST['submit']=='Save') or ($_REQUEST['submit']=='Save & Attend') or ($_REQUEST['submit']=='Delete Camp')))
{
	
	$camp = new camps();
	
	if(($_REQUEST['submit']=='Save'))
	{
		$DelegateId = AddDelegate();
		if($DelegateId)
		{
			header('location:../delegateRegister.php?err=successDelegateAdded');
			die();
		}
		else
		{
			//Error in adding new delegate
			header('location:../delegateRegister.php?err=failAddNewDelegate');
			die();
		}
	}
	else if(($_REQUEST['submit']=='Save & Attend'))
	{
		$DelegateId = AddDelegate();
		if($DelegateId)
		{
			$IsPresent=attend($DelegateId);
			if($IsPresent)
			{
				header('location:../delegateRegister.php?err=successDelegateMarked');
				die();
				//Successfully Marked present
			}
			else
			{
				//Error in marking Delegate present
				header('location:../delegateRegister.php?err=fail2MarkDelegate');
				die();
			}
		}
		else
		{
			//Error in adding new delegate
			header('location:../delegateRegister.php?err=failAddNewDelegate');
			die();
		}
	}
}
else if(isset($_REQUEST['submit']) and (($_REQUEST['submit']=='Update Record') or ($_REQUEST['submit']=='Update Record & Attend Camp') or ($_REQUEST['submit']=='Attend Camp')))
{
	
	if(($_REQUEST['submit']=='Update Record'))
	{
		$DelegateId = UpdateDelegate();
		if($DelegateId)
		{
			header('location:../delegateRegister.php?err=successDelegateUpdated');
			die();
		}
		else
		{
			//Error in adding new delegate
			header('location:../delegateRegister.php?err=failUpdateDelegate');
			die();
		}
	}
	else if($_REQUEST['submit']=='Update Record & Attend Camp')
	{
		$DelegateDetails = new delegatedetails();
		$isExist = $DelegateDetails->isExists($_REQUEST['ids']);
		if($isExist)
		{
			$DelegateId = UpdateDelegate();
		}
		
		if($DelegateId)
		{
			$IsPresent=attend($DelegateId);
			if($IsPresent)
			{
				header('location:../delegateRegister.php?err=successDelegateMarkedAndUpdated');
				die();
				//Successfully Marked present
			}
			else
			{
				//Error in marking Delegate present
				header('location:../delegateRegister.php?err=fail2MarkDelegate');
				die();
			}
		}
		else
		{
			//Error in adding new delegate
			header('location:../delegateRegister.php?err=failAddNewDelegate');
			die();
		}
	}
	else if(($_REQUEST['submit']=='Attend Camp'))
	{
		//Find delegate on DB if(is_found){mark}else{raise_complain}
		$DelegateDetails = new delegatedetails();
		$isExist = $DelegateDetails->isExists($_REQUEST['ids']);
		if($isExist)
		{
			$DelegateId = $_REQUEST['ids'];//delegate Id
		}
		if($DelegateId)
		{
			$IsPresent=attend($DelegateId);
			if($IsPresent)
			{
				header('location:../delegateRegister.php?err=successDelegateMarked');
				die();
				//Successfully Marked present
			}
			else
			{
				//Error in marking Delegate present
				header('location:../delegateRegister.php?err=fail2MarkDelegate');
				die();
			}
		}
	}
}

function AddDelegate()
{
	$TimeFormat='Y-m-d h:i:s';
	$DelegateDetails = new delegatedetails();
	if(isset($_REQUEST['delegateSurname'],$_REQUEST['delegateFirstName'],$_REQUEST['delegateGender'],$_REQUEST['address'],$_REQUEST['school_department_placeOfWork'],$_REQUEST['phone'],$_REQUEST['nokName'],$_REQUEST['nokPhone']))
	{
		$isAdded = $DelegateDetails->add($_REQUEST['delegateSurname'],$_REQUEST['delegateFirstName'],$_REQUEST['delegateOtherName'],$_REQUEST['delegateGender'],$_REQUEST['address'],$_REQUEST['school_department_placeOfWork'],$_REQUEST['eMail'],$_REQUEST['phone'],$_REQUEST['delegateState'],$_REQUEST['nokName'],$_REQUEST['nokPhone'],$_REQUEST['nokaddress'],1,date($TimeFormat),date($TimeFormat));
			return $isAdded;
	}
}

function UpdateDelegate()
{
	$TimeFormat='Y-m-d h:i:s';
	$DelegateDetails = new delegatedetails();
	$isExist = $DelegateDetails->isExists($_REQUEST['ids']);
	if($isExist)
	{
		if(isset($_REQUEST['delegateSurname'],$_REQUEST['delegateFirstName'],$_REQUEST['delegateGender'],$_REQUEST['address'],$_REQUEST['school_department_placeOfWork'],$_REQUEST['phone'],$_REQUEST['nokName'],$_REQUEST['nokPhone']))
		{

			//update($surname,$firstName,$otherName,$gender,$address,$school_department_placeOfWork,$email,$phone_number,$state,$name_next_of_kin,$number_next_of_kin,$address_next_of_kin,$status,$updated_at)
			$isUpdated = $DelegateDetails->update($_REQUEST['delegateSurname'],$_REQUEST['delegateFirstName'],$_REQUEST['delegateOtherName'],$_REQUEST['delegateGender'],$_REQUEST['address'],$_REQUEST['school_department_placeOfWork'],$_REQUEST['eMail'],$_REQUEST['phone'],$_REQUEST['delegateState'],$_REQUEST['nokName'],$_REQUEST['nokPhone'],$_REQUEST['nokaddress'],1,date($TimeFormat));
				return $isUpdated;
		}
	}
	return false;
}


function attend($delegateId)
{
	$System = new settings(1);
	$TimeFormat='Y-m-d h:i:s';
	$attendance = new attendances();
	$IsAttended=false;
	if(isset($_REQUEST['delegateStatus'],$_REQUEST['house'],$_REQUEST['amount']) and is_numeric($delegateId)){
		//add($delegateDetailId,$campId,$categoryId,$house,$created_at,$updated_at,$underPay=NULL,$personResponsible=NULL)
		$campFee = new campFee();
		$defaultCampId = $System->getDefaultCampId();
		$IsUnderPay = $campFee->IsUnderPay($_REQUEST['delegateStatus'],$defaultCampId,$_REQUEST['amount']);
		if(isset($_REQUEST['personResponsible']) or $IsUnderPay>0)
		{
			$IsAttended = $attendance->add($delegateId,$System->getDefaultCampId(),$_REQUEST['delegateStatus'],$_REQUEST['house'],date($TimeFormat),date($TimeFormat),$IsUnderPay,$_REQUEST['personResponsible']);
		}
		else
		{
			$IsAttended = $attendance->add($delegateId,$System->getDefaultCampId(),$_REQUEST['delegateStatus'],$_REQUEST['house'],date($TimeFormat),date($TimeFormat));
		}
		return $IsAttended;
	}
}


?>