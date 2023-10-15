<?php


class SQLSanitizer
{
	function __construct()
	{
	}
	
	function sanitizeInput($theValue)
	{
		
		if (PHP_VERSION < 6)
		{
		$theValue = @get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
		}
		
		$theValue = function_exists("mysql_real_escape_string") ? @mysql_real_escape_string($theValue) : @mysql_escape_string($theValue);

		return $theValue;
	}
	
	function extendedSanitizeInput($theValue, $theType)
	{
		
		$theValue = $this->sanitizeInput($theValue);
		
		switch ($theType)
		{
			case "text":
			  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			  break;    
			case "long":
			case "int":
			  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
			  break;
			case "double":
			  $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
			  break;
			case "date":
			  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			  break;
			case "defined":
			  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
			  break;
		}
		return $theValue;
	}
}

$sanitizer = new SQLSanitizer();

?>