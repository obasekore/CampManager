<?php

class migrations
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
			$query = mysql_query("SELECT * FROM migrations WHERE id = ".$sanitizer->extendedSanitizeInput($id, 'int')."");
			if ($query and (mysql_num_rows($query) > 0)) {
				$this->id = $id;
				$this->details = mysql_fetch_array($query);
			}
		}
	}
	
function getMigration()
	{
		return isset($this->details['migration']) ? $this->details['migration'] : NULL;
	}
	function getBatch()
	{
		return isset($this->details['batch']) ? $this->details['batch'] : NULL;
	}
	function delete($id)
	{
		$value=false;
		if(!is_null($id) and is_numeric($id))
		{
			$query=mysql_query('DELETE FROM migrations WHERE id="'.$id.'"');
			
			if($query)
			{
				$value=true;
				return $value;
			}
		}
		return $value;		
	}
	function add($migration,$batch)
	{
		$value=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		$query=mysql_query("INSERT INTO migrations (migration,batch) VALUES ($migration,$batch)");
		

		if($query)
		{
			$result=mysql_insert_id();
		}
		return $result;
	}
	function update($migration,$batch)
	{
		$value=false;
		
		$query=mysql_query("UPDATE migrations SET ".migration,batch WHERE id='".$id."'");
		
		if($query)
		{
			$result=true;
			return $result;
		}
		
		return $result;
	}
}