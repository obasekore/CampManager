<?php

class Utility {
	
	function __construct() {
	}
	
	function hashPassword($value, $algo = 'sha512') {
		$algo = !empty($algo) ? $algo : 'sha512';
		$hash = hash($algo, $value);
		
		return $hash;
	}

	function generateRandomString($length=8) {
		$characters = '12345678abcdefhjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function generateSecureRandomString($length=8) {
		$result = NULL;
		if ($length > 0) {
			$bytes = openssl_random_pseudo_bytes(ceil($length / 2));
			$result = bin2hex($bytes);
		}
		return $result;
	}

	function generateRandomPassword($minlength = 8) {
		$result = NULL;
		$length = $minlength + rand(1, 5);

		# $result = $this->generateSecureRandomString($length);
        $result = $this->generateRandomString($length);

        return $result;
	}
	
}

abstract class JobStatus {
	const ACTIVE = "Active";
	const CLOSED = "Closed";
	const CANCELLED = "Cancel";
}

abstract class JobQuoteStatus {
	const READ = 1;
	const UNREAD = 0;

	const ACCEPTED = 1;
	const UNACCEPTED = 0;
}

abstract class MailType {
	const HTML = 'html';
	const PLAIN_TEXT = 'plaintext';
}

$utility = new Utility();


?>