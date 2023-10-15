<?php

class Auth {
	
	function __construct() {
	}

	function validateAdminAuth() {
		$bool = false;
		if (isset($_SESSION['cm_admin'], $_SESSION['cm_admin_id']) and !empty($_SESSION['cm_admin']) and is_numeric($_SESSION['cm_admin_id'])) {
			$bool = true;
		}
		return $bool;
	}
	
	function createAdminAuth($admin) {
		$bool = false;
		if (is_a($admin, 'Admin')) {
			$_SESSION['cm_admin'] = serialize($admin);
			$_SESSION['cm_admin_id'] = $admin->getId();
		}
		return $bool;
	}

	function destroyAdminAuth() {
		include_once("admin.class.php");	
		unset($_SESSION['cm_admin']);
		unset($_SESSION['cm_admin_id']);
		
		session_destroy();
		
	}
	
	function destroyAllAuth() {
	}
	
	function getAdminAuth() {
		$result = NULL;
		if ($this->validateAdminAuth()) {
			$result = unserialize($_SESSION['cm_admin']);
		}
		return $result;
	}
	
}

$auth = new Auth();

?>
