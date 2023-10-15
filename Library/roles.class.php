<?php

class roles
{
	private $id;
	private $details = array();
	const SUPER=false;
	const HEAD_REG = false;
	const SUB_REG = false;
	const LOGISTICS = false;
	const SECURITY = false;
	
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
			$query = mysql_query("SELECT * FROM roles WHERE id = ".$sanitizer->extendedSanitizeInput($id, 'int')."");
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
	function getAccessible()
	{
		return isset($this->details['accessible']) ? $this->details['accessible'] : NULL;
	}
	function getStatus()
	{
		return isset($this->details['status']) ? $this->details['status'] : NULL;
	}
	
	function getAll()
	{
		$result = NULL;
		$query = mysql_query("SELECT id FROM roles ORDER BY title");
		if ($query and (mysql_num_rows($query) > 0)) {
			
			$result = array();
			while($array = mysql_fetch_assoc($query)) {
				$result[] = new roles($array['id']);
			}
		}
		return $result;		
	}
	function getMyMenuUrl()
	{
		$value = false;
		$menus = $this->getAccessible();
		if(!is_null($menus))
		{
			include_once('menus.class.php');
			$menus = explode(',',$menus);
			foreach($menus as $menuId)
			{
				$value[$menuId] = new menus($menuId);
			}
		}
		return $value;
	}
	function accessDenied($url)
	{
		$value = false;
		$myUrls = $this->getMyMenuUrl();
		$cnt = 0;
		foreach($myUrls as $myUrl)
		{
			$urls[$cnt] = $myUrl->getUrl();
			$cnt++;
		}
		if(!in_array($url,$urls))
			$value=true;
		return $value;		
	}
	function delete($id)
	{
		$value=false;
		if(!is_null($id) and is_numeric($id))
		{
			$query=mysql_query('DELETE FROM roles WHERE id="'.$id.'"');
			
			if($query)
			{
				$value=true;
				return $value;
			}
		}
		return $value;		
	}
	function add($title,$accessible,$status)
	{
		$value=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		$query=mysql_query("INSERT INTO roles (title,accessible,status) VALUES ($title,$accessible,$status)");
		

		if($query)
		{
			$result=mysql_insert_id();
		}
		return $result;
	}
	function update($title,$accessible,$status)
	{
		$value=false;
		
		$query=mysql_query("UPDATE roles SET title= '" . $sanitizer->sanitizeInput($title).",accessible= '" . $sanitizer->sanitizeInput($accessible).",status= '" . $sanitizer->sanitizeInput($status)." WHERE id='".$id."'");
		
		if($query)
		{
			$result=true;
			return $result;
		}
		
		return $result;
	}
}