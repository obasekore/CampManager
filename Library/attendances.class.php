<?php

class attendances
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
			$query = mysql_query("SELECT * FROM attendances WHERE id = ".$sanitizer->extendedSanitizeInput($id, 'int')."");
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
	function getDelegateDetailId()
	{
		return isset($this->details['delegateDetailId']) ? $this->details['delegateDetailId'] : NULL;
	}
	function getCampId()
	{
		return isset($this->details['campId']) ? $this->details['campId'] : NULL;
	}
	function getCategoryId()
	{
		return isset($this->details['categoryId']) ? $this->details['categoryId'] : NULL;
	}
	function getUnderPay()
	{
		return isset($this->details['underPay']) ? $this->details['underPay'] : NULL;
	}
	function getPersonResponsible()
	{
		return isset($this->details['personResponsible']) ? $this->details['personResponsible'] : NULL;
	}
	function getHouse()
	{
		return isset($this->details['house']) ? $this->details['house'] : NULL;
	}
	function getCreated_at()
	{
		return isset($this->details['created_at']) ? $this->details['created_at'] : NULL;
	}
	function getUpdated_at()
	{
		return isset($this->details['updated_at']) ? $this->details['updated_at'] : NULL;
	}
	//Delegate hass many attendance
	function getByDelegateId($DelegateID)
	{
		$result = NULL;
		
		$query = mysql_query("SELECT id FROM attendances WHERE delegateDetailId=$DelegateID");
		if ($query and (mysql_num_rows($query) > 0)) {
			$result = array();
			while($array = mysql_fetch_assoc($query)) {
				$result[] = new attendances($array['id']);
			}
		}
		return $result;
	}
	
	function getCategoryName()
	{
		include_once('categories.class.php');
		$category = new categories($this->getCategoryId());
		return $category->getName();
	}
	function getCampName()
	{
		include_once('camps.class.php');
		$camp = new camps($this->getCampId());
		return $camp->getName();
	}
	function getCampCategoryAmount()
	{
		include_once('campfee.class.php');
		$campfee = new campFee();
		$amount = $campfee->getAmountBy($this->getCategoryId(),$this->getCampId());
		return $amount;
		/*$category = new campFee($this->getCategoryId());
		return $category-();*/
	}
	function getByCampId($campId)
	{
		$result = NULL;
		
		$query = mysql_query("SELECT id FROM attendances WHERE campId=$campId");
		if ($query and (mysql_num_rows($query) > 0)) {
			$result = array();
			while($array = mysql_fetch_assoc($query)) {
				$result[] = new attendances($array['id']);
			}
		}
		return $result;
	}
	function isPresent($defaultCampId, $DelegateId)
	{
		$result = false;
		$thisDelegatesAttendances = $this->getByDelegateId($DelegateId);
		if(!is_null($thisDelegatesAttendances))
		{
			foreach($thisDelegatesAttendances as $thisDelegatesAttendance)
			{
				if($thisDelegatesAttendance->getCampId()==$defaultCampId)
					return new attendances($thisDelegatesAttendance->getId());
			}
		}
		return $result;
		/*$query = mysql_query('SELECT id FROM attendances WHERE delegateDetailId=$DelegateId and campId=$defaultCampId');
		if($query and mysql_fetch_assoc($query)>0)
		{
			$array = mysql_fetch_array($query);
			$result = new attendances($array['id']);
		}
		return $result;*/
	}
	function delete($id)
	{
		$value=false;
		if(!is_null($id) and is_numeric($id))
		{
			$query=mysql_query('DELETE FROM attendances WHERE id="'.$id.'"');
			
			if($query)
			{
				$value=true;
				return $value;
			}
		}
		return $value;		
	}
	function add($delegateDetailId,$campId,$categoryId,$house,$created_at,$updated_at,$underPay=NULL,$personResponsible=NULL)
	{
		$result=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		$query=mysql_query("INSERT INTO attendances (delegateDetailId,campId,categoryId,underPay,personResponsible,house,created_at,updated_at) VALUES ($delegateDetailId,$campId,$categoryId,'$underPay','$personResponsible','$house','$created_at','$updated_at')");
		if($query)
		{
			$result=mysql_insert_id();
		}
		return $result;
	}
	function update($delegateDetailId,$campId,$categoryId,$underPay,$personResponsible,$house,$updated_at)
	{
		$result=false;
		
		$query=mysql_query("UPDATE attendances SET delegateDetailId= '" . $sanitizer->sanitizeInput($delegateDetailId).",campId= '" . $sanitizer->sanitizeInput($campId).",categoryId= '" . $sanitizer->sanitizeInput($categoryId).",underPay= '" . $sanitizer->sanitizeInput($underPay).",personResponsible= '" . $sanitizer->sanitizeInput($personResponsible).",house= '" . $sanitizer->sanitizeInput($house)." WHERE id='".$id."'");
		
		if($query)
		{
			$result=true;
			return $result;
		}
		
		return $result;
	}
	
	function updatePayment($id,$underPay,$personResponsible="")
	{
		$result=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
				
		$query=mysql_query("UPDATE attendances SET underPay= '" . $sanitizer->sanitizeInput($underPay)."',personResponsible= '" . $sanitizer->sanitizeInput($personResponsible)."' WHERE id='".$id."'");
		if($query)
		{
			return true;
		}
		
		return $result;
	}
}