<?php
if (!isset($_SESSION)) {
	session_start();
}
require_once('../../Connections/config.php');
include_once('../../Library/auth.class.php');
include_once('../../Library/camps.class.php');
include_once('../../Library/campfee.class.php');
$TimeFormat='Y-m-d h:i:s';

if(isset($_REQUEST['submit']) and (($_REQUEST['submit']=='Register Camp') or ($_REQUEST['submit']=='Update Camp') or ($_REQUEST['submit']=='Delete Camp')))
{
	$camp = new camps();
	
	if(($_REQUEST['submit']=='Register Camp'))
	{
		if(isset($_REQUEST['campName'],$_REQUEST['campTheme'],$_REQUEST['memVerse'],$_REQUEST['campLocation'],$_REQUEST['campDOP']))
		{
			$house['male'] = $_REQUEST['campMaleHouseName'];
			$house['female'] = $_REQUEST['campFemaleHouseName'];
			$isAdded= $camp->add($_REQUEST['campName'],$_REQUEST['campTheme'],$_REQUEST['memVerse'],$_REQUEST['campLocation'],$_REQUEST['campDOP'],serialize($house),1,date($TimeFormat),date($TimeFormat));
			if($isAdded)
			{
				$campFee = new campFee();
				$amounts = $_REQUEST['amount'];
				foreach($amounts as $categoryId=>$amount)
				{
					if($amount>0){
						$campFee->add($isAdded,$categoryId,$amount);
					}
				}
				header('location:../regCamp.php?err=success');
				die();
			}
			else
			{
				header('location:../regCamp.php?err=fail');
				die();	
			}
		}
	}
	else if(($_REQUEST['submit']=='Update Camp'))
	{
		
	}
}

?>