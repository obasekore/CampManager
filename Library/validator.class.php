<?php

class Validator {
	
	function __construct() {
	}
	
	function isEmail($value) {
		$bool = !empty($value) && filter_var($value, FILTER_VALIDATE_EMAIL);
		return $bool;
	}
	
	function isUrl($value) {
		$bool = !empty($value) && filter_var($value, FILTER_VALIDATE_URL);
		return $bool;
	}
	
	function isValidPhone($value) {
		$bool = !empty($value) && ((strlen($value) == 11) || (strlen($value) == 13)) && $this->isMatch($value, '/^[0-9]{11,13}$/');
		return $bool;
	}
	
	function isMatch($value, $regex) {
		$bool = false;
		
		$result = preg_match($regex, $value);
		if ($result === 1) {
			$bool = true;
		}
		return $bool;
	}
	
	function isValidName($value) {
		$bool = !empty($value) && (strlen($value) > 1);
		return $bool;
	}
	
	function isValidMoney($value) {
		$option = array("options" => array("min_range"=>0, "max_range"=>1000000000));
		$bool = !empty($value) && filter_var($value, FILTER_VALIDATE_INT, $option);
		return $bool;
	}
	
	function isValidDegree($value) {
	}
	
	function isInHouseRequest($request) {
	}
	
	function validateLength($value, $min = NULL, $max = NULL) {
		$bool = true;
		
		if (!is_null($min) && is_int($min)) {
			$bool = !empty($value) && (strlen($value) >= $min); 
		}
		if (!is_null($max) && is_int($max)) {
			$bool = $bool && (!empty($value) && (strlen($value) <= $max));
		}
		
		return $bool;
	}
	
	function validateComplexity($value) {
		return true;
	}
	
	function isNumber($value) {
		$bool = filter_var($value, FILTER_VALIDATE_INT);
		return $bool;
	}

	function isGender($value) {
		$bool = false;
		$genders = array("Male", "Female");
		if (!empty($value)) {
			$bool = in_array($value, $genders);
		}
		return $bool;
	}

	function isValidDate ($year, $month, $day) {
		return checkdate($month, $day, $year);
	}

    function isValidDate2($date, $separator = "-") {
        $date_comp = explode($separator, $date);
        return checkdate($date_comp[1], $date_comp[2], $date_comp[0]);
    }

    function isValidDateTime($datetime) {
        $bool = false;
        $date = date_parse_from_format("Y-n-j H:i", $datetime);

        if (!empty($date) and ($date['error_count'] == 0) and ($date['warning_count'] == 0)) {
            $bool = true;
        }

        return $bool;
    }

}

$validator = new Validator();

?>