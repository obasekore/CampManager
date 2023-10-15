<?php

class camps
{
	private $id;
	private $details = array();
	
	function __construct($id=NULL)
	{
		if (!is_null($id)) {
			$this->loadData($id);
		}
	}
	
	private function loadData($id) {
		
		if (is_numeric($id) and ($id > 0)) {
			include_once("sqlsanitize.class.php");
			$sanitizer = new SQLSanitizer();
			$query = mysql_query("SELECT * FROM camps WHERE id = ".$sanitizer->extendedSanitizeInput($id, 'int')."");
			if ($query and (mysql_num_rows($query) > 0)) {
				$this->id = $id;
				$this->details = mysql_fetch_array($query);
			}
		}
	}
	
function getId()
	{
		return isset($this->details['id']) ? $this->details['id'] : NULL;
	}
	function getName()
	{
		return isset($this->details['name']) ? $this->details['name'] : NULL;
	}
	function getTheme()
	{
		return isset($this->details['theme']) ? $this->details['theme'] : NULL;
	}
	function getMemoryVerse()
	{
		return isset($this->details['memoryVerse']) ? $this->details['memoryVerse'] : NULL;
	}
	function getDOP()
	{
		return isset($this->details['DOP']) ? $this->details['DOP'] : NULL;
	}
	function getAmount()
	{
		return isset($this->details['amount']) ? $this->details['amount'] : NULL;
	}
	function getHouse()
	{
		return isset($this->details['house']) ? $this->details['house'] : NULL;
	}
	function getStatus()
	{
		return isset($this->details['status']) ? $this->details['status'] : NULL;
	}
	function getLocation()
	{
		return isset($this->details['Location']) ? $this->details['Location'] : NULL;
	}
	function getCreated_at()
	{
		return isset($this->details['created_at']) ? $this->details['created_at'] : NULL;
	}
	function getUpdated_at()
	{
		return isset($this->details['updated_at']) ? $this->details['updated_at'] : NULL;
	}
	function delete($id)
	{
		$value=false;
		if(!is_null($id) and is_numeric($id))
		{
			$query=mysql_query('DELETE FROM camps WHERE id="'.$id.'"');
			if($query)
			{
				$value=true;
				return $value;
			}
		}
		return $value;		
	}
	function getAll()
	{
		$result = NULL;
		
		$query = mysql_query("SELECT id FROM camps ORDER BY name");
		if ($query and (mysql_num_rows($query) > 0)) {
			
			$result = array();
			while($array = mysql_fetch_assoc($query)) {
				$result[] = new  camps($array['id']);
			}
		}
		
		return $result;
	}
	
	function add($name,$theme,$memoryVerse,$Location,$DOP,$house,$status=NULL,$created_at,$updated_at)
	{
		$value=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		$query=mysql_query("INSERT INTO camps (name,theme,memoryVerse,Location,DOP,house,status,created_at,updated_at) VALUES ('$name','$theme','$memoryVerse','$Location','$DOP','$house',1,'$created_at','$updated_at')");
		if($query)
		{
			$result=mysql_insert_id();
		}
		return $result;
	}
	function update($name,$theme,$memoryVerse,$Location,$DOP,$house,$status,$updated_at)
	{
		$value=false;
		
		$query=mysql_query("UPDATE camps SET name= '" . $sanitizer->sanitizeInput($name).",theme= '" . $sanitizer->sanitizeInput($theme).",memoryVerse= '" . $sanitizer->sanitizeInput($memoryVerse).",Location= '" . $sanitizer->sanitizeInput($Location).",DOP= '" . $sanitizer->sanitizeInput($DOP).",house= '" . $sanitizer->sanitizeInput($house).",status= '" . $sanitizer->sanitizeInput($status)." WHERE id='".$id."'");
		
		if($query)
		{
			$result=true;
			return $result;
		}
		
		return $result;
	}
	
	function getStatOfGender()
	{
		include_once('attendances.class.php');
		include_once('delegatedetails.class.php');
		$value = array('Male'=>0,'Female'=>0);;
		if(is_numeric($this->getId()))
		{
			$attendance = new attendances();
			$attendancesInCamp = $attendance->getByCampId($this->getId());
			if(!is_null($attendancesInCamp))
			{
				foreach($attendancesInCamp as $attendanceInCamp)
				{
					$delagate = new delegatedetails($attendanceInCamp->getDelegateDetailId());
					$Gender = $delagate->getGender();
					$value[$Gender]++;
				}
				return $value;
			}
		}
		return $value;
		//Number of Male and Female
	}
	
	function getStatOfCategory()
	{
		include_once('categories.class.php');
		include_once('campfee.class.php');
		include_once('attendances.class.php');
		include_once('delegatedetails.class.php');
		$value = NULL;
		if(is_numeric($this->getId()))
		{
			$categoriesForThisCamp = new campFee();
			$categoriesForThisCamp = $categoriesForThisCamp->getByCampId($this->getId());
			//Initializing variable for each category & byGender
			if(!is_null($categoriesForThisCamp))
			{
				foreach($categoriesForThisCamp as $a_category)
				{
					$category = new categories($a_category->getCategoryId());
					$value[$category->getName()]['Male']=0;
					$value[$category->getName()]['Female']=0;
				}
			}
			$attendance = new attendances();
			$attendancesInCamp = $attendance->getByCampId($this->getId());
			if(!is_null($attendancesInCamp))
			{
				foreach($attendancesInCamp as $attendanceInCamp)
				{
					//Get his/her gender
					$delagate = new delegatedetails($attendanceInCamp->getDelegateDetailId());
					$Gender = $delagate->getGender();
					//Get his/her category
					$category = new categories($attendanceInCamp->getCategoryId());
					$CategoryName = $category->getName();
					$value[$CategoryName][$Gender]++;
				}
			}
			return $value;
		}
		//Number of Delegate in each Category/Status
		//Grouped by gender 
		//
		// Da'awah =>{male:30, female:50}; Upper => {male:10, female:}
		//
		return $value;
	}

	function getStatOfHouse()
	{
		include_once('attendances.class.php');

		$housesByGender = unserialize($this->getHouse());
		
		$value = NULL;
		if(is_numeric($this->getId()))
		{
			$attendance = new attendances();
			$attendancesInCamp = $attendance->getByCampId($this->getId());

			foreach($housesByGender as $gender=>$aGenderHouses)
			{//Get houses in this gender
				$start=0;
				foreach($aGenderHouses as $aGenderHouse)
				{//get the each house
				//initializing gender=>house variable
					$value[$aGenderHouse]=0;
				}
			}
			if(!is_null($attendancesInCamp))
			{
				foreach($attendancesInCamp as $attendanceInCamp)
				{
					$value[$attendanceInCamp->getHouse()]++;
				}
			}

		}
		return $value;
		//Number of Delegate in each house
	}
	function totalUnderpay()
	{
		include_once('attendances.class.php');		
		$value = NULL;
		if(is_numeric($this->getId()))
		{
			$value = 0;
			$attendance = new attendances();
			$attendancesInCamp = $attendance->getByCampId($this->getId());
			if(!is_null($attendancesInCamp))
			{
				foreach($attendancesInCamp as $attendanceInCamp)
				{
					$value+=$attendanceInCamp->getUnderPay();
				}
			}
		}
		return $value;
	}
	
	function totalExpenditure()
	{
		include_once('expenditures.class.php');		
		$value = NULL;
		if(is_numeric($this->getId()))
		{
			$value = 0;
			$expenditures = new expenditures();
			$expendituresInCamp = $expenditures->getByCampId($this->getId());
			if(!is_null($expendituresInCamp))
			{
				foreach($expendituresInCamp as $expenditureInCamp)
				{
					$value+=$expenditureInCamp->getAmount();
				}
			}
		}
		return $value;
	}
	
	function getResponsibleForUnderPayList()
	{
		include_once('attendances.class.php');
		include_once('delegatedetails.class.php');
		$value = NULL;
		if(is_numeric($this->getId()))
		{
			$attendance = new attendances();
			$attendances = $attendance->getByCampId($this->getId());
			if(!is_null($attendances))
			{
				foreach($attendances as $a_delegate)
				{
					if($a_delegate->getUnderPay()>0 or !empty($a_delegate->getPersonResponsible()))
					{
						$value[$a_delegate->getDelegateDetailId()]['details']= new delegatedetails($a_delegate->getDelegateDetailId());
						$value[$a_delegate->getDelegateDetailId()]['house'] = $a_delegate->getHouse();
						$value[$a_delegate->getDelegateDetailId()]['UnderPay'] = $a_delegate->getUnderPay();
						$value[$a_delegate->getDelegateDetailId()]['PersonResponsible'] = $a_delegate->getPersonResponsible();
						$value[$a_delegate->getDelegateDetailId()]['StatusName'] = $a_delegate->getCategoryName();
					}
					//get underpay and person responsible for this underpayment
				}
			}
		}
		return $value;
		//classes:: DelegateDetails, attendances
		//Return DelegateName, DelegateNumber, DelegateHouse, DelegateStatus, UnderPay, PersonResponsible
	}
	function getStatOfIncome()
	{
		include_once('campfee.class.php');
		include_once('categories.class.php');
		include_once('expenditures.class.php');
		$value = NULL;
		$attendanceByCategory = $this->getStatOfCategory();
		if(!is_null($attendanceByCategory))
		{
			$categoriesForThisCamp = new campFee();
			$categoriesForThisCamp = $categoriesForThisCamp->getByCampId($this->getId());
			if(!is_null($categoriesForThisCamp))
			{
				foreach($categoriesForThisCamp as $a_category)
				{
					$value['IncomeByStat'][$a_category->getCategoryName()]=array_sum($attendanceByCategory[$a_category->getCategoryName()])*$a_category->getAmount();
				}
					//actual amount recieved without expenditure
					$value['ActualIncome'] = array_sum($value['IncomeByStat'])-$this->totalUnderpay();
					$value['Cash@hand']= $value['ActualIncome']-$this->totalExpenditure();
			}
		}
		return $value;
		//ActualIncome
		//Expenditure
		//Expected Income
	}

	
}