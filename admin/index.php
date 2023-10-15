<?php
if (!isset($_SESSION)) {
	session_start();
}

require_once("../Connections/config.php");
include_once("../inc/admin/login.inc.php");
include_once("../Library/settings.class.php");
include_once("../Library/auth.class.php");

if($auth->validateAdminAuth())
{
	header("location:dashboard.php");
	exit;
}
$System = new settings(1);

?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $System->getEstName() ?> v3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/animCSS.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-bg">
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-12">
	              <!-- Logo -->
	              <div class="logo" id="headingContainer" >
                  <img style="margin-top:-17px;" src="../<?php echo $System->getLogo()?>" width="50px" class="img-rounded" align="logo" height="50px"/>
	                 <h1 style="display:inline-block; color: white; text-shadow: 2px 2px 4px #3F9;"><a href="residue/index.php"><?php echo $System->getEstName() ?></a></h1>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>
<form action="actions/loginAction.php" method="post"  enctype="application/x-www-form-urlencoded">
	<div class="page-content container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-wrapper">
			        <div class="box">
			            <div class="content-wrap">
			                <h6>Sign In</h6>
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
			                <div class="social">
	                            <a class="face_login" href="#">
	                                <span class="face_icon">
	                                    <img src="images/facebook.png" alt="fb">
	                                </span>
	                                <span class="text">Sign in with Facebook</span>
	                            </a>
	                            <div class="division">
	                                <hr class="left">
	                                <span>or</span>
	                                <hr class="right">
	                            </div>
	                        </div>
			                <input class="form-control" type="text" name="username" placeholder="Username">
			                <input class="form-control" type="password" name="password" placeholder="Password" value="************"  onfocus="this.value=''" >
			                <div class="action">
                                <input type="submit" name="submit" value="Login" class="btn btn-primary signup"  />
			                </div>                
			            </div>
			        </div>

			        <div class="already">
			            <p>Don't have an account yet?</p>
			            <a href="residue/signup.html">Sign Up</a>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</form>

<div id="footercont" class="clearfix">
    	<p>Camp Manager Version 3.0 &nbsp;|&nbsp; A Product of  <a title="Standard Bearers Islamic Organization" href="#" rel="external">SB IT</a></p>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/custom.js"></script>
  </body>
</html>