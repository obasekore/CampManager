<?php

if (!isset($_SESSION)) {
	session_start();
}

require_once("../Connections/config.php");
include_once("../inc/admin/login.inc.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CV Nija :: Login</title>
<link rel="stylesheet" href="../templates/css/screen.css" type="text/css" media="screen" title="default" />
<!--  jquery core -->
<script src="../templates/js/jquery-2.2.3.min.js" type="text/javascript"></script>

<!-- Custom jquery scripts -->
<script src="../templates/js/custom_jquery.js" type="text/javascript"></script>

<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
<script src="../templates/js/jquery.pngFix.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).pngFix( );
});
</script>
</head>
<body id="login-bg"> 
 
<!-- Start: login-holder -->
<div id="login-holder">

	<!-- start logo -->
	<div id="logo-login">
		<a href="residue/index.php"><img src="../templates/images/favicon-128x128-2.png"  height="40" alt="" /></a>
	</div>
	<!-- end logo -->
	
	<div class="clear"></div>
	
	<!--  start loginbox ................................................................................. -->
	<div id="loginbox">
	 <div align="center" style="padding-bottom:7px">
	 <?php
		if (!empty($errmsg)) {
		?>
        	<div class="v-margin-20 alert alert-danger text-center"><?php echo $errmsg; ?></div>
        <?php
		} else if (!empty($successmsg)) {
		?>
	        <div class="v-margin-20 alert alert-success text-center"><?php echo $successmsg; ?></div>
        <?php
		}
		?>
        </div>
        <form action="actions/loginAction.php" method="post"  enctype="application/x-www-form-urlencoded">
	<!--  start login-inner -->
	<div id="login-inner">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Username</th>
			<td><input type="text"  class="login-inp" name="username" placeholder="Username" /></td>
		</tr>
		<tr>
			<th>Password</th>
			<td><input type="password" name="password" placeholder="Password" value="************"  onfocus="this.value=''" class="login-inp" /></td>
		</tr>
		<tr>
			<th></th>
			<td valign="top"><input type="checkbox" class="checkbox-size" id="login-check" /><label for="login-check">Remember me</label></td>
		</tr>
		<tr>
			<th></th>
			<td><input type="submit" name="submit" value="Login" class="submit-login"  /></td>
		</tr>
		</table>
	</div>
 	<!--  end login-inner -->
     </form>
	<div class="clear"></div>
	<a href="" class="forgot-pwd">Forgot Password?</a>
 </div>
 <!--  end loginbox -->

 
	<!--  start forgotbox ................................................................................... -->
	<form method="post" enctype="application/x-www-form-urlencoded">
    <div id="forgotbox">
		<div id="forgotbox-text">Please send us your email and we'll reset your password.</div>
		<!--  start forgot-inner -->
		<div id="forgot-inner">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Email address:</th>
			<td><input type="text" value="" name="email"  class="login-inp" /></td>
		</tr>
		<tr>
			<th> </th>
			<td><input type="button" class="submit-login" name="Reset" value="reset" /></td>
		</tr>
		</table>
		</div>
		<!--  end forgot-inner -->
		<div class="clear"></div>
		<a href="" class="back-login">Back to login</a>
	</div>
	<!--  end forgotbox -->
</form>
</div>

<!-- End: login-holder -->
</body>
</html>