<?php

class expenditures
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
			$query = mysql_query("SELECT * FROM expenditures WHERE id = ".$sanitizer->extendedSanitizeInput($id, 'int')."");
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
	function getPurpose()
	{
		return isset($this->details['purpose']) ? $this->details['purpose'] : NULL;
	}
	function getPhoneNumber()
	{
		return isset($this->details['phoneNumber']) ? $this->details['phoneNumber'] : NULL;
	}
	function getAmount()
	{
		return isset($this->details['amount']) ? $this->details['amount'] : NULL;
	}
	function getCampId()
	{
		return isset($this->details['campId']) ? $this->details['campId'] : NULL;
	}

	function getCreated_at()
	{
		return isset($this->details['created_at']) ? $this->details['created_at'] : NULL;
	}
	function getUpdated_at()
	{
		return isset($this->details['updated_at']) ? $this->details['updated_at'] : NULL;
	}
	
	function getByCampId($campId)
	{
		$result = NULL;
		
		$query = mysql_query("SELECT id FROM expenditures WHERE campId=$campId");
		if ($query and (mysql_num_rows($query) > 0)) {
			
			$result = array();
			while($array = mysql_fetch_assoc($query)) {
				$result[] = new  expenditures($array['id']);
			}
		}
		return $result;
	}

	function delete($id)
	{
		$value=false;
		if(!is_null($id) and is_numeric($id))
		{
			$query=mysql_query('DELETE FROM expenditures WHERE id="'.$id.'"');
			
			if($query)
			{
				$value=true;
				return $value;
			}
		}
		return $value;		
	}
	function add($campId,$name,$purpose,$phoneNumber,$amount,$created_at,$updated_at)
	{
		$result=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		$query=mysql_query("INSERT INTO expenditures (campId,name,purpose,phoneNumber,amount,created_at,updated_at) VALUES ($campId,'$name','$purpose','$phoneNumber','$amount','$created_at','$updated_at')");
		if($query)
		{
			$result=mysql_insert_id();
		}
		return $result;
	}
	function update($id,$name,$purpose,$phoneNumber,$amount,$updated_at)
	{
		$result=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		$query=mysql_query("UPDATE expenditures SET name= '" . $sanitizer->sanitizeInput($name)."',purpose= '" . $sanitizer->sanitizeInput($purpose)."',phoneNumber= '" . $sanitizer->sanitizeInput($phoneNumber)."',amount= '" . $sanitizer->sanitizeInput($amount)."',updated_at= '" . $sanitizer->sanitizeInput($updated_at)."' WHERE id='".$id."'");
		
		if($query)
		{
			$result=true;
			return $result;
		}
		
		return $result;
	}
}