<?php

class delegatedetails
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
			$query = mysql_query("SELECT * FROM delegatedetails WHERE id = ".$sanitizer->extendedSanitizeInput($id, 'int')."");
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
	function getSurname()
	{
		return isset($this->details['surname']) ? $this->details['surname'] : NULL;
	}
	function getFirstName()
	{
		return isset($this->details['firstName']) ? $this->details['firstName'] : NULL;
	}
	function getOtherName()
	{
		return isset($this->details['otherName']) ? $this->details['otherName'] : NULL;
	}
	function getGender()
	{
		return isset($this->details['gender']) ? $this->details['gender'] : NULL;
	}
	function getAddress()
	{
		return isset($this->details['address']) ? $this->details['address'] : NULL;
	}
	function getSchool_department_placeOfWork()
	{
		return isset($this->details['school_department_placeOfWork']) ? $this->details['school_department_placeOfWork'] : NULL;
	}
	function getEmail()
	{
		return isset($this->details['email']) ? $this->details['email'] : NULL;
	}
	function getPhone_number()
	{
		return isset($this->details['phone_number']) ? $this->details['phone_number'] : NULL;
	}
	function getState()
	{
		return isset($this->details['state']) ? $this->details['state'] : NULL;
	}
	function getName_next_of_kin()
	{
		return isset($this->details['name_next_of_kin']) ? $this->details['name_next_of_kin'] : NULL;
	}
	function getNumber_next_of_kin()
	{
		return isset($this->details['number_next_of_kin']) ? $this->details['number_next_of_kin'] : NULL;
	}
	function getAddress_next_of_kin()
	{
		return isset($this->details['address_next_of_kin']) ? $this->details['address_next_of_kin'] : NULL;
	}
	function getStatus()
	{
		return isset($this->details['status']) ? $this->details['status'] : NULL;
	}
	function getCreated_at()
	{
		return isset($this->details['created_at']) ? $this->details['created_at'] : NULL;
	}
	function getUpdated_at()
	{
		return isset($this->details['updated_at']) ? $this->details['updated_at'] : NULL;
	}
	function isExists($id)
	{
		if(isset($id))
		{
			$query = mysql_query('SELECT id FROM delegatedetails WHERE id="'.$id.'"');

			if($query)
			{
				if ($query and (mysql_num_rows($query) > 0)) {
					$this->loadData($id);
					return $this->getId();
				}
			}
		}
		return false;

	}
	function delete($id)
	{
		$value=false;
		if(!is_null($id) and is_numeric($id))
		{
			$query=mysql_query('DELETE FROM delegatedetails WHERE id="'.$id.'"');
			
			if($query)
			{
				$value=true;
				return $value;
			}
		}
		return $value;		
	}
	
	function getAll()
	{
		$result = NULL;
		$query = mysql_query("SELECT id FROM delegatedetails ORDER BY surname");
		if ($query and (mysql_num_rows($query) > 0)) {
			
			$result = array();
			while($array = mysql_fetch_assoc($query)) {
				$result[] = new  delegatedetails($array['id']);
			}
		}
		return $result;
	}
	function add($surname,$firstName,$otherName,$gender,$address,$school_department_placeOfWork,$email,$phone_number,$state,$name_next_of_kin,$number_next_of_kin,$address_next_of_kin,$status,$created_at,$updated_at)
	{
		$result=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		$query=mysql_query("INSERT INTO delegatedetails (surname,firstName,otherName,gender,address,school_department_placeOfWork,email,phone_number,state,name_next_of_kin,number_next_of_kin,address_next_of_kin,status,created_at,updated_at) VALUES ('$surname','$firstName','$otherName','$gender','$address','$school_department_placeOfWork','$email',$phone_number,'$state','$name_next_of_kin','$number_next_of_kin','$address_next_of_kin',$status,'$created_at','$updated_at')");
		if($query)
		{
			$result=mysql_insert_id();
		}
		return $result;
	}
	function update($surname,$firstName,$otherName,$gender,$address,$school_department_placeOfWork,$email,$phone_number,$state,$name_next_of_kin,$number_next_of_kin,$address_next_of_kin,$status,$updated_at)
	{
		$result=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
				
		$query=mysql_query("UPDATE delegatedetails SET surname= '" . $sanitizer->sanitizeInput($surname)."',firstName= '" . $sanitizer->sanitizeInput($firstName)."',otherName= '" . $sanitizer->sanitizeInput($otherName)."',gender= '" . $sanitizer->sanitizeInput($gender)."',address= '" . $sanitizer->sanitizeInput($address)."',school_department_placeOfWork= '" . $sanitizer->sanitizeInput($school_department_placeOfWork)."',email= '" . $sanitizer->sanitizeInput($email)."',phone_number= '" . $sanitizer->sanitizeInput($phone_number)."',state= '" . $sanitizer->sanitizeInput($state)."',name_next_of_kin= '" . $sanitizer->sanitizeInput($name_next_of_kin)."',number_next_of_kin= '" . $sanitizer->sanitizeInput($number_next_of_kin)."',address_next_of_kin= '" . $sanitizer->sanitizeInput($address_next_of_kin)."',status= '" . $sanitizer->sanitizeInput($status)."',updated_at = '".$updated_at."' WHERE id='".$this->getId()."'");
		if($query)
		{
			$result=$this->getId();
			return $result;
		}
		
		return $result;
	}
}
$delegate = new delegatedetails();

$all_Delegates = $delegate->getAll();