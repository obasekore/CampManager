<?php

class categories
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
			$query = mysql_query("SELECT * FROM categories WHERE id = ".$sanitizer->extendedSanitizeInput($id, 'int')."");
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
	function getStatus()
	{
		return isset($this->details['status']) ? $this->details['status'] : NULL;
	}
	function getDescription()
	{
		return isset($this->details['description']) ? $this->details['description'] : NULL;
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
			$query=mysql_query('DELETE FROM categories WHERE id="'.$id.'"');
			
			if($query)
			{
				$value=true;
				return $value;
			}
		}
		return $value;		
	}
	function add($name,$description,$created_at,$updated_at)
	{
		$value=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		$query=mysql_query("INSERT INTO categories (name,description,created_at,updated_at) VALUES ('$name','$description','$created_at','$updated_at')");
		//die(mysql_error());

		if($query)
		{
			$result=mysql_insert_id();
		}
		return $result;
	}
	function update($id,$name,$description,$updated_at)
	{
		$value=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();

		$query=mysql_query("UPDATE categories SET name= '" . $sanitizer->sanitizeInput($name)."' ,description= '" . $sanitizer->sanitizeInput($description)."' WHERE id='".$id."'");
		//die(mysql_error());
		if($query)
		{
			$result=true;
			return $result;
		}
		
		return $result;
	}
	
	function getAll()
	{
		$result = NULL;
		
		$query = mysql_query("SELECT id FROM categories ORDER BY name");
		if ($query and (mysql_num_rows($query) > 0)) {
			
			$result = array();
			while($array = mysql_fetch_assoc($query)) {
				$result[] = new  categories($array['id']);
			}
		}
		
		return $result;
	}
}