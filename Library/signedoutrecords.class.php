<?php

class signedoutrecords
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
			$query = mysql_query("SELECT * FROM signedoutrecords WHERE id = ".$sanitizer->extendedSanitizeInput($id, 'int')."");
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
	function getDelegateDetailId()
	{
		return isset($this->details['delegateDetailId']) ? $this->details['delegateDetailId'] : NULL;
	}
	function getDestination()
	{
		return isset($this->details['destination']) ? $this->details['destination'] : NULL;
	}
	function getPurpose()
	{
		return isset($this->details['purpose']) ? $this->details['purpose'] : NULL;
	}
	function getDeleted_at()
	{
		return isset($this->details['deleted_at']) ? $this->details['deleted_at'] : NULL;
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
			$query=mysql_query('DELETE FROM signedoutrecords WHERE id="'.$id.'"');
			
			if($query)
			{
				$value=true;
				return $value;
			}
		}
		return $value;		
	}
	function add($delegateDetailId,$destination,$purpose,$deleted_at,$created_at,$updated_at)
	{
		$value=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		$query=mysql_query("INSERT INTO signedoutrecords (delegateDetailId,destination,purpose,deleted_at,created_at,updated_at) VALUES ($delegateDetailId,$destination,$purpose,$deleted_at,$created_at,$updated_at)");
		

		if($query)
		{
			$result=mysql_insert_id();
		}
		return $result;
	}
	function update($delegateDetailId,$destination,$purpose,$updated_at)
	{
		$value=false;
		
		$query=mysql_query("UPDATE signedoutrecords SET delegateDetailId= '" . $sanitizer->sanitizeInput($delegateDetailId).",destination= '" . $sanitizer->sanitizeInput($destination).",purpose= '" . $sanitizer->sanitizeInput($purpose)." WHERE id='".$id."'");
		
		if($query)
		{
			$result=true;
			return $result;
		}
		
		return $result;
	}
}