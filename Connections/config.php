<?php

$hostname_config = "localhost";
$database_config = "campmanager";
$username_config = "root";
$password_config = "Hell0W0rld";

$config = @mysql_pconnect($hostname_config, $username_config, $password_config) or trigger_error(mysql_error(),E_USER_ERROR);
$db = @mysql_select_db($database_config) or die("Could not connect to database : ".mysql_error());

