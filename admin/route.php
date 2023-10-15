<?php
if (!isset($_SESSION)) {
	session_start();
}
require_once('../Connections/config.php');
require_once('../Library/settings.class.php');
include_once('../Library/admin.class.php');
include_once('../Library/auth.class.php');
include_once("../inc/admin/dashboard.inc.php");

if(isset($_REQUEST['purp']) or !empty($_REQUEST['purp']))
{
	if($_REQUEST['purp']=='CatEdit' and is_numeric($_REQUEST['ids']))
	{
		include('../Library/Categories.class.php');
		$category = new categories($_REQUEST['ids']);
		$msg = 'edit';
		return (include('forms/_addCategory.php'));
	}
	else if($_REQUEST['purp']=='CatNew')
	{
		return (include('forms/_addCategory.php'));
	}
	else if($_REQUEST['purp']=='CatDelete')
	{
		header('location:actions/categoriesAction.php?submit=Delete%20Category&id='.$_REQUEST['id']);
		die();		
	}
	else if($_REQUEST['purp']=='CampView' and is_numeric($_REQUEST['ids']))
	{
		include('../Library/camps.class.php');
		include('../Library/campfee.class.php');
		
		$campFee = new campFee();
		$amount = $campFee->getByCampId($_REQUEST['ids']);
		$camp = new camps($_REQUEST['ids']);
		$msg='view';
		return (include('forms/_addCamp.php'));
	}
	else if($_REQUEST['purp']=='setDefaultCamp')
	{
		include('../Library/camps.class.php');
		$settings = new settings(1);
		if(isset($_REQUEST['ids']) and is_numeric($_REQUEST['ids'])){
				
				$isSet = $settings->setDefaultCamp($_REQUEST['ids']);
				$settings = new settings(1);
			}
			$default = $settings->getDefaultCampId();
		$camp = new camps($default);
		return (include('forms/_setDefaultCamp.php'));
	}
	else if($_REQUEST['purp']=='setEstablishName')
	{
		include('../Library/camps.class.php');
		$settings = new settings(1);
		if(isset($_REQUEST['ids'])){
				
				$isSet = $settings->setInstitutionName($_REQUEST['ids']);
				$settings = new settings(1);
			}
			$EstName = $settings->getEstName();
		return (include('forms/_setEstName.php'));
	}else if($_REQUEST['purp']=='markAttendanceForCamp')
	{
		include_once('../library/delegatedetails.class.php');
		include_once('../library/attendances.class.php');
		include_once('../library/categories.class.php');
		include_once('../library/campfee.class.php');
		include_once('../library/camps.class.php');
		if(isset($_REQUEST['ids']))
		{
			$System = new settings(1);
			$camp = new camps($System->getDefaultCampId());
			$house = unserialize($camp->getHouse());
			//////////////////////////////////////////////						
			$Delegate = new delegatedetails($_REQUEST['ids']);
			$Attendance = new attendances();
			$settings = new settings(1);
			$campFee = new campFee();
			$amount = $campFee->getByCampId($System->getDefaultCampId());
			$myAttendances = $Attendance->getByDelegateId($_REQUEST['ids']);
			$isPresent = $Attendance->isPresent($settings->getDefaultCampId(),$_REQUEST['ids']);
			if($isPresent)
			{
				$hisCategory = new categories($isPresent->getCategoryId());
				$amount = $campFee->getAmountBy($isPresent->getCategoryId(), $settings->getDefaultCampId());//get amount by campId and CategoryId
			}
			$msg = 'update';
			return include('forms/_addDelegate.php');
		}
	}else if($_REQUEST['purp']=='deletAttendanceForCamp')
	{
		include_once('../library/attendances.class.php');
		if(isset($_REQUEST['ids']))
		{	
			$Attendance = new attendances();
			$isDeRegistered = $Attendance->delete($_REQUEST['ids']);
			if($isDeRegistered)
			{
				echo '<script> alert("Delegate Successfully DeRegister for this Camp")</script>';
			}
			else
			{
				echo '<script> alert("Delegate Failed to DeRegister for this Camp")</script>';
			}
		}
	}
	else if($_REQUEST['purp']=='UpdateDelegatePayment')
	{
		include_once('../library/attendances.class.php');
		if(isset($_REQUEST['ids']))
		{	
			$Attendance = new attendances();
			$underPay = $_REQUEST['statusExpectedAmount'] - $_REQUEST['amount'];
			$isPaymentUpdated = $Attendance->updatePayment($_REQUEST['ids'],$underPay,$_REQUEST['personResponsible']);
			if($isPaymentUpdated)
			{
				echo '<script> alert("Delegate\'s payment Successfully Updated")</script>';
			}
			else
			{
				echo '<script> alert("Delegate\'s payment Failed to Update")</script>';
			}
		}
	}
	else if($_REQUEST['purp']=='newDelegateRegistration')
	{
		include_once('../library/campfee.class.php');
		include_once('../library/camps.class.php');
		$System = new settings(1);
		$camp = new camps($System->getDefaultCampId());
		
		$house = unserialize($camp->getHouse());
		//////////////////////////////////////////////						
		$campFee = new campFee();
		$amount = $campFee->getByCampId($System->getDefaultCampId());
		$msg = "view";
		//temporary solution to js not working
		$isAjax = true;
		return include_once('forms/_addDelegate.php');
	}
	else if($_REQUEST['purp']=='delegateProfile')
	{
		include_once('../library/delegatedetails.class.php');
		include_once('../library/attendances.class.php');
		include_once('../library/categories.class.php');
		include_once('../library/campfee.class.php');
		include_once('../library/camps.class.php');
		if(isset($_REQUEST['ids']))
		{
			//Get his 
			$Attendance = new attendances($_REQUEST['ids']);
			$Delegate = new delegatedetails($Attendance->getDelegateDetailId());
			$camp = new camps($Attendance->getCampId());
			$Attendance = new attendances();
			$myAttendances = $Attendance->getByDelegateId($Delegate->getId());
			//////////////////////////////////////////////						
			$campFee = new campFee();
			//$amount = $campFee->getByCampId($System->getDefaultCampId());
			
			return include_once('forms/_delegateProfile.php');
		}
	}	
	else if($_REQUEST['purp']=='editExpenditure')
	{
		include_once('../library/expenditures.class.php');
		if(isset($_REQUEST['ids']))
		{
			$expenditure = new expenditures($_REQUEST['ids']);
			$msg='update';
			return include_once('forms/_addExpenditure.php');
		}

	}
	else if($_REQUEST['purp']=='CampDelete')
	{
		include_once('../library/camps.class.php');
		if(isset($_REQUEST['ids']))
		{
			$camp = new camps();
			$isDeleted = $camp->delete($_REQUEST['ids']);
			if($isDeleted)
			{
				header('location:regCamp.php?err=campDeletedSuccessfully');
				die();
			}
			else
			{
				header('location:regCamp.php?err=campDeletedFailedDelegateAlreadyAvailable');
				die();
			}
		}
	}	
	else if($_REQUEST['purp']=='addAdmin')
	{
		if(isset($_REQUEST['data']))
		{
			
			//if(isset($_REQUEST['firstName'],$_REQUEST['lastName'],$_REQUEST['username'],$_REQUEST['email'],$_REQUEST[''],))
			$adminInfo = explode('&',$_REQUEST['data']);
			foreach($adminInfo as $admini)
			{
				$admini = explode('=',$admini);
				$actual[$admini[0]]= $admini[1];
			}				
				print_r($actual);

			include_once('../library/admin.class.php');
			include_once("../library/utility.class.php");
			$new_utility= new Utility();

			$newAdmin = new admin();
			$adminCreated = $newAdmin->create($actual['firstName'],$actual['lastName'],$actual['username'],$actual['email'],$new_utility->hashPassword($actual['pwd']),$actual['role']);
			if($adminCreated)
			{
				echo '<script> alert("Admin Successfully created")';
			}
			else
			{
				echo '<script> alert("Admin failed to create")';				
			}
		}
		else
		{
			include_once('../library/roles.class.php');
			$role = new roles();
			$roles = $role->getAll();
			return include_once('forms/_addAdmin.php');
		}
	}


		
}
else
{
	echo '<div class="v-margin-20 alert alert-danger alert-dismissable text-center font-dot9">
				Technical Error: No Purpose
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>';
}
?>