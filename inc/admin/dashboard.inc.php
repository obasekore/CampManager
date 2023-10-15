<?php

if (!$auth->validateAdminAuth()) {
	header("location:index.php?err=accessdenied");
	exit;
}

$admin = $auth->getAdminAuth();

if (!$admin) {
	header("location:index.php?err=accessdenied");
	exit;
}

?>
