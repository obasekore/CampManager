<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Localhost = "Localhost";
$database_Localhost = "campmanager";
$username_Localhost = "root";
$password_Localhost = "";
$Localhost = mysql_pconnect($hostname_Localhost, $username_Localhost, $password_Localhost) or trigger_error(mysql_error(),E_USER_ERROR); 
?>