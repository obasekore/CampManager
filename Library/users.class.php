<?php

class users
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
			$query = mysql_query("SELECT * FROM users WHERE id = ".$sanitizer->extendedSanitizeInput($id, 'int')."");
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
	function getEmail()
	{
		return isset($this->details['email']) ? $this->details['email'] : NULL;
	}
	function getImage()
	{
		return isset($this->details['image']) ? $this->details['image'] : NULL;
	}
	function getPassword()
	{
		return isset($this->details['password']) ? $this->details['password'] : NULL;
	}
	function getRole()
	{
		return isset($this->details['role']) ? $this->details['role'] : NULL;
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
	function delete($id)
	{
		$value=false;
		if(!is_null($id) and is_numeric($id))
		{
			$query=mysql_query('DELETE FROM users WHERE id="'.$id.'"');
			
			if($query)
			{
				$value=true;
				return $value;
			}
		}
		return $value;		
	}
	function add($name,$email,$image,$password,$role,$remember_token,$created_at,$updated_at)
	{
		$value=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		$query=mysql_query("INSERT INTO users (name,email,image,password,role,remember_token,created_at,updated_at) VALUES ($name,$email,$image,$password,$role,$remember_token,$created_at,$updated_at)");
		

		if($query)
		{
			$result=mysql_insert_id();
		}
		return $result;
	}
	function update($name,$email,$image,$password,$role,$updated_at)
	{
		$value=false;
		
		$query=mysql_query("UPDATE users SET name= '" . $sanitizer->sanitizeInput($name).",email= '" . $sanitizer->sanitizeInput($email).",image= '" . $sanitizer->sanitizeInput($email).",password= '" . $sanitizer->sanitizeInput($password).",role= '" . $sanitizer->sanitizeInput($role)." WHERE id='".$id."'");
		
		if($query)
		{
			$result=true;
			return $result;
		}
		
		return $result;
	}
}