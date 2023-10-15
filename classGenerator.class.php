<?php

include_once 'Connections/config.php';

$value = array(
		'getTables'=>'SHOW TABLES',
		'describleTable' => 'DESCRIBE ',
		'parentFolder' => 'Library/',
		'Tables_in' => 'Tables_in_'.$database_config
);
$sign = '&#36;';
$sign='$';
$temp="";

$fields="";

//die($value['Tables_in']);

if(!file_exists($value['parentFolder']))
{
	$response = mkdir($value['parentFolder']);
	if($response){
		echo $value['parentFolder'].' Folder created..<br/>'; 
	}
	else{
		echo 'Error in creating '.$value['parentFolder'].' folder..';
		exit;
	}
		
}
$query = mysql_query($value['getTables']);
while ($result=mysql_fetch_array($query)) {
	$fullPath=$value['parentFolder'].$result[$value['Tables_in']];
		$accumulate="";
	if(!file_exists($fullPath))
	{
		$cnt=0;
		$fields='';
		$myClasses[$result[$value['Tables_in']]] = fopen($fullPath.'.class.php','w+');
		$TableName = $result[$value['Tables_in']];
		$accumulate = generator($TableName);
		$query2 = mysql_query($value['describleTable'].' '.$result[$value['Tables_in']]);
		while($result2 = mysql_fetch_array($query2))
		{
			
			if($result2['Key']=='PRI')
			{
				$primary = $result2['Field'];			
			}
			else
			{
				$fields .= $result2['Field'].',';//($cnt>=(count($result2['Field']))?',':'');
			}
			//Accumulate Values and Fielda for update and Add
			$temp .= newMethod($result2['Field']);
		}
		$fields=explode(',',$fields);
		array_pop($fields);
		
		$values = implode(',$',$fields);
		$fields = implode(',',$fields);
		
		$temp .=addUpdateDelete($TableName,$values,$fields,$primary);
		
		$accumulate .=$temp;
	}
	$accumulate .='
}';
	fwrite($myClasses[$result[$value['Tables_in']]],$accumulate);
	echo ':) Class successfully generated... :)<br>'.$values;
	$accumulate="";//Clear content
	$temp="";
//	fwrite($myClasses[$result[$value['Tables_in']]],$accumulate);
}

function generator($TableName)
{
$text='<?php

class '.$TableName.'
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
			$query = mysql_query("SELECT * FROM '.$TableName.' WHERE id = '.'".$sanitizer->extendedSanitizeInput($id, '."'int'".')."'.'");
			if ($query and (mysql_num_rows($query) > 0)) {
				$this->id = $id;
				$this->details = mysql_fetch_array($query);
			}
		}
	}
	
';
return $text;
}

function newMethod($field)
{
	$sign = '&#36;';
	$sign='$';
	$text = "function get".ucwords($field)."()
	{
		return isset(".$sign."this->details['".$field."']) ? ".$sign."this->details['".$field."'] : NULL;
	}
	";
	return $text;
}

function addUpdateDelete($TableName,$values,$fields,$primary)
{
	
	$sign='$';
	$text="function delete($".$primary.")
	{
		".$sign."value=false;
		if(!is_null($".$primary.") and is_numeric($".$primary."))
		{
			".$sign."query=mysql_query('DELETE FROM ".$TableName." WHERE ".$primary."=".'"'."'.$".$primary.".'".'"'."');
			
			if(".$sign."query)
			{
				".$sign."value=true;
				return ".$sign."value;
			}
		}
		return ".$sign."value;		
	}
	";
	
	//Add here
	$text .= 'function add($'.$values.')
	{
		'.$sign.'value=false;
		include_once("sqlsanitize.class.php");
		$sanitizer = new SQLSanitizer();
		$query=mysql_query("INSERT INTO '.$TableName.' ('.$fields.') VALUES ($'.$values.')");
		

		if($query)
		{
			$result=mysql_insert_id();
		}
		return $result;
	}
	';
	
	//Update here No yet completed
	//surname='".$sanitizer->sanitizeInput($surname)."',
	/*$temps = explode(',',$fields);
	$hold="";
	foreach($temps as $temp)
	{
//		$hold = "'".$temp
		$hold .= "'".$temp.'=".$sanitizer->sanitizeInput($'.$temp.'),';
	}*/
	
	$text .= 'function update($'.$values.')
	{
		'.$sign.'value=false;
		
		$query=mysql_query("UPDATE '.$TableName.' SET ".'.$fields.' WHERE '.$primary.'='."'".'".$'.$primary.'."'."'".'");
		
		if($query)
		{
			$result=true;
			return $result;
		}
		
		return $result;
	}';	
	return $text;
}

/*
Later jare
$query=mysql_query("UPDATE '.$TableName.' SET ".'.$hold.' WHERE '.$primary.'='."'".'".$'.$primary.'."'."'".'");

*/
/* SET surname='".$sanitizer->sanitizeInput($surname)."',middleName='".$sanitizer->sanitizeInput($middleName)."',firstName='".$sanitizer->sanitizeInput($firstName)."',birthday='".$birthday."',sex='".$sanitizer->sanitizeInput($sex)."',nationality='".$sanitizer->sanitizeInput($nationality)."',maritalStatus='".$sanitizer->sanitizeInput($maritalStatus)."',education='".$sanitizer->sanitizeInput($eduaction)."',occupation='".$sanitizer->sanitizeInput($occuppation)."',residentialAddress='".$sanitizer->sanitizeInput($residentialAddress)."',email='".$sanitizer->sanitizeInput($email)."',phoneNumber='".$sanitizer->sanitizeInput($phoneNumber)."',nameOfChapter='".$sanitizer->sanitizeInput($nameOfChapter)."',region='".$sanitizer->sanitizeInput($region)."',picture='".$sanitizer->sanitizeInput($picture)."',nok_name='".$sanitizer->sanitizeInput($nok_name)."',nok_address='".$sanitizer->sanitizeInput($nok_address)."',nok_email='".$sanitizer->sanitizeInput($nok_email)."',nok_phoneNumber='".$sanitizer->sanitizeInput($nok_phoneNumber)."',spouse_name='".$sanitizer->sanitizeInput($spouse_name)."',spouse_address='".$sanitizer->sanitizeInput($spouse_address)."',spouse_email='".$sanitizer->sanitizeInput($spouse_email)."',spouse_phoneNumber='".$sanitizer->sanitizeInput($spouse_phoneNumber)."'");*/