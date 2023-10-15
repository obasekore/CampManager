<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once("../../Connections/config.php");
include_once("../../Library/sqlsanitize.class.php");
include_once("../../Library/admin.class.php");
include_once("../../Library/utility.class.php");
include_once("../../Library/auth.class.php");


if (isset($_POST['submit']) and ($_POST['submit'] == 'Login')) {
    if (isset($_POST['username'], $_POST['password']) and !empty($_POST['username']) and !empty($_POST['password'])) {

        $sanitizer = new SQLSanitizer();
        $admin = new admin();

        $password = $utility->hashPassword($_POST['password']);

        $isAdmin = $admin->getAdmin($_POST['username'], $password);

        if ($isAdmin) {

            $auth->createAdminAuth($isAdmin);
            $admin->login($isAdmin->getId());

            if ($_SESSION['cm_admin']) {
                header("location:../dashboard.php");
                exit;
            } else {
                header("location:../index.php?err=error");
                exit;
            }

        } else {
            header("location:../index.php?err=invaliddetails");
            exit;
        }
    } else {
        header("location:../index.php?err=emptyfield");
        exit;
    }
} else {
    header("location:../index.php");
    exit;
}

?>
