<?php

class password_resets
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
			$query = mysql_query("SELECT * FROM password_resets WHERE id = ".$sanitizer->extendedSanitizeInput($id, 'int')."");
			if ($query and (mysql_num_rows($query) > 0)) {
				$this->id = $id;
				$this->details = mysql_fetch_array($query);
			}
		}
	}
	
function getEmail()
	{
		return isset($this->details['email']) ? $this->details['email'] : NULL;
	}
	function getToken()
	{
		return isset($this->details['token']) ? $this->details['token'] : NULL;
	}
	function getCreated_at()
	{
		return isset($this->details['created_at']) ? $this->details['created_at'] : NULL;
	}
	function delete($id)
	{
		$value=false;
		if(!is_null($id) and is_numeric($id))
		{
			$query=mysql_query('DELETE FROM password_resets WHERE id="'.$id.'"');
			
			if($query)
			{
				$value=true;
				return $value;
			}
		}
		return $value;		
	}
	function add($email,$token,$created_at)
	{
		$value=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		$query=mysql_query("INSERT INTO password_resets (email,token,created_at) VALUES ($email,$token,$created_at)");
		

		if($query)
		{
			$result=mysql_insert_id();
		}
		return $result;
	}
	function update($email,$token,$created_at)
	{
		$value=false;
		
		$query=mysql_query("UPDATE password_resets SET ".email,token,created_at WHERE id='".$id."'");
		
		if($query)
		{
			$result=true;
			return $result;
		}
		
		return $result;
	}
}