<?php

class admin
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
			$query = mysql_query("SELECT * FROM admin WHERE id = ".$sanitizer->extendedSanitizeInput($id, 'int')."");
			if ($query and (mysql_num_rows($query) > 0)) {
				$this->id = $id;
				$this->details = mysql_fetch_array($query);
			}
		}
	}
	
function getAdmin_id()
	{
		return isset($this->details['admin_id']) ? $this->details['admin_id'] : NULL;
	}
	function getFirstname()
	{
		return isset($this->details['firstname']) ? $this->details['firstname'] : NULL;
	}
	function getLastname()
	{
		return isset($this->details['lastname']) ? $this->details['lastname'] : NULL;
	}
	function getUsername()
	{
		return isset($this->details['username']) ? $this->details['username'] : NULL;
	}
	function getEmail()
	{
		return isset($this->details['email']) ? $this->details['email'] : NULL;
	}
	function getRole()
	{
		return isset($this->details['role']) ? $this->details['role'] : NULL;
	}
	function getPassword()
	{
		return isset($this->details['password']) ? $this->details['password'] : NULL;
	}
	function getLast_login()
	{
		return isset($this->details['last_login']) ? $this->details['last_login'] : NULL;
	}
	function getRemember_token()
	{
		return isset($this->details['remember_token']) ? $this->details['remember_token'] : NULL;
	}
	function getCreated_at()
	{
		return isset($this->details['created_at']) ? $this->details['created_at'] : NULL;
	}
	function getUpdated_at()
	{
		return isset($this->details['updated_at']) ? $this->details['updated_at'] : NULL;
	}
	function getNum_retries()
	{
		return isset($this->details['num_retries']) ? $this->details['num_retries'] : NULL;
	}
	
}