<?php
class Worker {
	private $id;
	private $details;
	function __construct($id=NULL) {
		
		if (!is_null($id)) {
			$this->loadData($id);
		}
	}
	private function loadData($id) {
		
		if (is_numeric($id) and ($id > 0)) {
			include_once("sqlsanitize.class.php");
			$sanitizer = new SQLSanitizer();
			$query = mysql_query("SELECT * FROM workers WHERE sn = ".$sanitizer->extendedSanitizeInput($id, 'int')."");
			if ($query and (mysql_num_rows($query) > 0)) {
				$this->id = $id;
				$this->details = mysql_fetch_array($query);
			}
		}
	}
	
	function delete($id)
	{
		$value=false;
		if(!is_null($id) and is_numeric($id))
		{
			$query=mysql_query('DELETE FROM workers WHERE sn="'.$id.'"');
			
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
		$query = mysql_query("SELECT sn FROM workers ORDER BY fname");
		if ($query and (mysql_num_rows($query) > 0)) {
			
			$result = array();
			while($array = mysql_fetch_assoc($query)) {
				$result[] = new  Worker($array['sn']);
			}
		}
		return $result;
	}
	function getId()
	{
		return isset($this->details['sn']) ? $this->details['sn'] : NULL;
	}
	function getPin()
	{
		return isset($this->details['pin']) ? $this->details['pin'] : NULL;
	}
	function getRegDate()
	{
		return isset($this->details['reg_date']) ? $this->details['reg_date'] : NULL;
	}
	function getFirstName()
	{
		return isset($this->details['fname']) ? $this->details['fname'] : NULL;
	}
	function getLastName()
	{
		return isset($this->details['lname']) ? $this->details['lname'] : NULL;
	}
	function getGender()
	{
		return isset($this->details['gender']) ? $this->details['gender'] : NULL;
	}
	function getTelephone()
	{
		return isset($this->details['telephone']) ? $this->details['telephone'] : NULL;
	}
	function getAddress()
	{
		return isset($this->details['addy']) ? $this->details['addy'] : NULL;
	}
	function getEmail()
		return isset($this->details['email']) ? $this->details['email'] : NULL;
	}
	function getHq()
	{
		return isset($this->details['hq']) ? $this->details['hq'] : NULL;
	}
	function getOccupation()
	{
		return isset($this->details['occupation']) ? $this->details['occupation'] : NULL;
	}
	function getPlaceOfWork()
	{
		return isset($this->details['pow']) ? $this->details['pow'] : NULL;
	}
	function updateStatus($id)
	{
		$result=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
				
		$query=mysql_query("UPDATE delegatedetails SET status= 1 WHERE id='".$this->getId()."'");
		if($query)
		{
			$result=$this->getId();
			return $result;
		}
		
		return $result;
	}

}
$Worker = new Worker();

$all_Workers = $Worker->getAll();
?>