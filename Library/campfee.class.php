<?php

class campFee
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
			$query = mysql_query("SELECT * FROM campfee WHERE id = ".$sanitizer->extendedSanitizeInput($id, 'int')."");
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
	
	function getAmount()
	{
		return isset($this->details['amount']) ? $this->details['amount'] : NULL;
	}
	function getCategoryId()
	{
		return isset($this->details['categoryId']) ? $this->details['categoryId'] : NULL;
	}
	
	function getCategoryName()
	{
		include_once('categories.class.php');
		$category = new categories($this->getCategoryId());
		return $category->getName();
	}
	
	function getByCampId($campId)
	{
		$result = NULL;
		
		$query = mysql_query("SELECT id FROM campfee WHERE campId=$campId");
		if ($query and (mysql_num_rows($query) > 0)) {
			
			$result = array();
			while($array = mysql_fetch_assoc($query)) {
				$result[] = new  campFee($array['id']);
			}
		}
		return $result;
	}
	
	function getByCategoryId($categoryId)
	{
		$result = NULL;
		
		$query = mysql_query("SELECT id FROM campfee WHERE categoryId=$categoryId");
		if ($query and (mysql_num_rows($query) > 0)) {
			
				$array = mysql_fetch_array($query);
				$result = new campFee($array['id']);
		}
		return $result;
	}
	
	function getByCategoryIdCampId($categoryId, $campId)
	{
		$result = NULL;
		
		$query = mysql_query("SELECT id FROM campfee WHERE categoryId=$categoryId and campId=$campId");
		if ($query and (mysql_num_rows($query) > 0)) {
			
				$array = mysql_fetch_array($query);
				$result = new campFee($array['id']);
		}
		return $result;
	}

	
	function getAmountBy($categoryId, $campId)//get amount by campId and CategoryId
	{
		$result = NULL;
		
		$query = mysql_query("SELECT id FROM campfee WHERE categoryId=$categoryId and campId=$campId");
		if ($query and (mysql_num_rows($query) > 0)) {
			
				$array = mysql_fetch_array($query);
				$result = new campFee($array['id']);
				$result = $result->getAmount();
		}
		return $result;

	}
	
	function IsUnderPay($categoryId,$campId, $amount)
	{
		$thisCategory = $this->getByCategoryIdCampId($categoryId, $campId);
		$ActualAmount =$thisCategory->getAmount();
		$difference = ($ActualAmount-$amount);
		if($difference>0)
		{
			return $difference;
		}
		else
		{
			return false;
		}
	}
	
	function add($campId, $CategoryId, $amount)
	{
		$query=mysql_query("INSERT INTO campfee (campId,categoryId,amount) VALUES ('$campId','$CategoryId','$amount')");
		
		if($query)
		{
			$result=mysql_insert_id();
		}
		return $result;
	}
	
	function update($id,$amount)
	{
		$value=false;
		
		$query=mysql_query("UPDATE campfee SET amount= '" . $sanitizer->sanitizeInput($amount)." WHERE id='".$id."'");
		
		if($query)
		{
			$result=true;
			return $result;
		}
		
		return $result;		
	}
	
	function delete($id)
	{
		
	}	
}