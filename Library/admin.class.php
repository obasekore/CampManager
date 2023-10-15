<?php
class admin
{
	private $admin_id = NULL;
	private $fields = NULL;
	
	private function loadData($id) {
		if (is_numeric($id) and ($id > 0)) {
			include_once("sqlsanitize.class.php");
			$sanitizer = new SQLSanitizer();
			$query = mysql_query("SELECT * FROM admin WHERE admin_id ='".$sanitizer->extendedSanitizeInput($id, 'int')."'");
			if ($query and (mysql_num_rows($query) > 0)) {
				$this->admin_id = $id;
				$this->fields = mysql_fetch_array($query);
			}
		}
	}
	
	
	function __construct($id=NULL) {
		if (!is_null($id)) {
			$this->loadData($id);
		}
	}
	
	
	function getId() {
		return $this->admin_id;
	}
	
	
	function getAdmin($username, $password) {
		$result = false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		
		$query = mysql_query("SELECT admin_id FROM admin WHERE username = '".$sanitizer->sanitizeInput($username)."' AND password = '".$sanitizer->sanitizeInput($password)."'");
		if ($query and (mysql_num_rows($query) > 0)) {
			$array = mysql_fetch_assoc($query);
			$result = new admin($array['admin_id']);
		}
		return $result;
	}
	
	function getFirstname() {
		return !empty($this->fields) ? $this->fields['firstname'] : NULL;
	}
	function getLastLogin() {
		return !empty($this->fields) ? $this->fields['last_login'] : NULL;
	}

	function getUsername() {
		return !empty($this->fields) ? $this->fields['username'] : NULL;
	}

	function getEmail() {
		return !empty($this->fields) ? $this->fields['email'] : NULL;
	}
	function getLastname() {
		return !empty($this->fields) ? $this->fields['lastname'] : NULL;
	}
	function getRole() {
		return !empty($this->fields) ? $this->fields['role'] : NULL;
	}
	
	function getFullname() {
		return $this->getFirstname()." ".$this->getLastname();
	}
	
	function getAccessiblity()
	{
		include_once('roles.class.php');
		$roles = new roles($this->getRole());
		$whatIHaveAccesTo = $roles->getMyMenuUrl();
		return $whatIHaveAccesTo;
	}
	
	function create($firstname, $lastname, $username, $email, $password, $role) {
		$result = false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		
		$query = mysql_query("INSERT INTO admin SET firstname ='".$sanitizer->sanitizeInput($firstname)."', lastname ='".$sanitizer->sanitizeInput($lastname)."', username ='".$sanitizer->sanitizeInput($username)."', password ='".$sanitizer->sanitizeInput($password)."', email ='".$sanitizer->sanitizeInput($email)."', role ='".$sanitizer->sanitizeInput($role)."'");
		if ($query) {
			$result = new admin(mysql_insert_id());
		}
		return $result;
	}
	
		function isUsernameExist($username) {
		$bool = false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		
		$query = mysql_query("SELECT id FROM admin WHERE username = '".$sanitizer->sanitizeInput($username)."'");
		if ($query and (mysql_num_rows($query) > 0)) {
			$bool = true;
		}
		return $bool;
	}
	
	function login($id)
	{
		$bool=false;		
		$query=mysql_query("UPDATE admin SET last_login='".time()."' WHERE admin_id='$id'");
		if($query)
		{
			$bool=true;
		}
		return $bool;
	}
	
	function isPasswordMatch($password)
	{
		include_once("utility.class.php");
		$new_utility= new Utility();
		$bool=($this->fields['password']==$new_utility->hashPassword($password))? TRUE:FALSE;
		return $bool;
	}
	

	function changePassword($newPassword)
	{
		$bool=FALSE;
		include_once("utility.class.php");
		$new_utility= new Utility();
		
		$query=mysql_query("UPDATE admin SET password='".$new_utility->hashPassword($newPassword)."' WHERE admin_id='".$this->getId()."'");
			if($query)
			{
				$bool=TRUE;
				return $bool;
			}
		return $bool;				
	}
	

}

?>
