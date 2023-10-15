<?php

class settings
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
			$query = mysql_query("SELECT * FROM settings WHERE id = ".$sanitizer->extendedSanitizeInput($id, 'int')."");
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
	function getEstName()
	{
		return isset($this->details['EstName']) ? $this->details['EstName'] : NULL;
	}
	function getLogo()
	{
		return isset($this->details['logo']) ? $this->details['logo'] : NULL;
	}
	function getMoto()
	{
		return isset($this->details['moto']) ? $this->details['moto'] : NULL;
	}
	function getDefaultCampId()
	{
		return isset($this->details['defaultCampId']) ? $this->details['defaultCampId'] : NULL;
	}
	function setDefaultCamp($defaultCampId)
	{
		$result=false;
		include_once("sqlsanitize.class.php");	
		$sanitizer = new SQLSanitizer();	
		$query=mysql_query("UPDATE settings SET defaultCampId= '" . $sanitizer->sanitizeInput($defaultCampId)."' WHERE id='".$this->getId()."'");
		echo mysql_error();
		if($query)
		{
			$result=true;
			return $result;
		}
		
		return $result;
	}
	
	function setInstitutionName($InstitutionName)
	{
		$result=false;
		include_once("sqlsanitize.class.php");	
		$sanitizer = new SQLSanitizer();	
		$query=mysql_query("UPDATE settings SET EstName= '" . $sanitizer->sanitizeInput($InstitutionName)."' WHERE id='".$this->getId()."'");
		echo mysql_error();
		if($query)
		{
			$result=true;
			return $result;
		}
		return $result;
	}
	
	function delete($id)
	{
		$value=false;
		if(!is_null($id) and is_numeric($id))
		{
			$query=mysql_query('DELETE FROM settings WHERE id="'.$id.'"');
			
			if($query)
			{
				$value=true;
				return $value;
			}
		}
		return $value;		
	}
	function add($EstName,$logo,$moto,$defaultCampId)
	{
		$result=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		$query=mysql_query("INSERT INTO settings (EstName,logo,moto,defaultCampId) VALUES ($EstName,$logo,$moto,$defaultCampId)");
		

		if($query)
		{
			$result=mysql_insert_id();
		}
		return $result;
	}
	function update($EstName,$logo,$moto,$defaultCampId)
	{
		$result=false;
		$query=mysql_query("UPDATE settings SET EstName= '" . $sanitizer->sanitizeInput($EstName).",logo= '" . $sanitizer->sanitizeInput($logo).",moto= '" . $sanitizer->sanitizeInput($moto).",defaultCampId= '" . $sanitizer->sanitizeInput($defaultCampId)." WHERE id='".$id."'");
		
		if($query)
		{
			$result=true;
			return $result;
		}
		
		return $result;
	}
}