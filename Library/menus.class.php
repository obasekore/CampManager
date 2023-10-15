<?php

class menus
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
			$query = mysql_query("SELECT * FROM menu WHERE id = ".$sanitizer->extendedSanitizeInput($id, 'int')."");
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
	function getTitle()
	{
		return isset($this->details['title']) ? $this->details['title'] : NULL;
	}	
	function getUrl()
	{
		return isset($this->details['url']) ? $this->details['url'] : NULL;
	}	
	function getStatus()
	{
		return isset($this->details['status']) ? $this->details['status'] : NULL;
	}	
	function getCreated_at()
	{
		return isset($this->details['created_at']) ? $this->details['created_at'] : NULL;
	}	
}