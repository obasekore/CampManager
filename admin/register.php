<?php

if (!isset($_SESSION)) {
	session_start();
}

require_once("../Connections/config.php");
include_once("../inc/register.inc.php");

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>
<!-- Basic Page Needs
    ================================================== -->
<meta charset="utf-8">
<title>MechCity</title>
<meta name="description" content="">
<!-- Mobile Specific Metas
    ================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
<!-- CSS
         ================================================== -->
<!-- Bootstrap -->
<link rel="stylesheet" href="../css/bootstrap.min.css"/>
<!-- FontAwesome -->
<link rel="stylesheet" href="../css/font-awesome.min.css"/>
<!-- Animation -->
<link rel="stylesheet" href="../css/animate.css" />
<link rel="stylesheet" href="../css/red.css"/>

<!-- Template styles-->
<link rel="stylesheet" href="../css/custom.css" />
<link rel="stylesheet" href="../css/responsive.css" />
<link rel="stylesheet" href="../css/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> -->
<link href='http://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
<!-- <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,500' rel='stylesheet' type='text/css'> -->
</head>

<body data-spy="scroll" data-target=".navbar-fixed-top" class="bg-gray">
<!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="clearfix"></div>

<div class="container loginer">
  <section class="col-md-6 col-sm-8 col-centered log-section v-margin-20">
  
    <div class="login_header" align="center">
    	<a href="../index.php"><img src="../images/logo/logo_dark.png" /></a>
	</div>
    
    <div class="login_register box-shadow-flipper slideInDown">
    
        <div class="login_form_header">
          <h3 align="center" class="no-text-transform">Register Administrator</h3>          
        </div>
        
        <div class="login_form_body">
        <!--
        	<div class="v-margin-20 alert alert-success text-center">You have been registered successfully</div>
        -->
        
        <?php if (!empty($errmsg)) { ?>
        <div class="v-margin-20 alert alert-danger text-center"><?php echo $errmsg; ?></div>
        <?php } ?>
        
            <form action="actions/registerAction.php" enctype="application/x-www-form-urlencoded" method="post">
            
            
            	<div class="form-group form-level">
               	  <input class="form-control" type="text" name="firstname" placeholder="Firstname" maxlength="50" required="required" />
                    <span class="form-icon fa fa-user"></span>
                </div>
                
                <div class="form-group form-level">
               	  <input class="form-control" type="text" name="lastname" placeholder="Lastname" maxlength="50" required="required" />
                    <span class="form-icon fa fa-user"></span>
                </div>
                
                <div class="form-group form-level">
               	  <input class="form-control" type="text" name="username" placeholder="Username" maxlength="50" required="required" />
                    <span class="form-icon fa fa-user"></span>
                </div>

                                                
          		<div class="form-group form-level">
                	<input type="password" name="password" class="form-control" placeholder="Password" required="required" maxlength="30" />
                    <span class="form-icon fa fa-key"></span>
                </div>
                
                <div class="form-group text-center">
                	<input type="submit" name="submit" value="Create Account" class="btn btn-main featured" />
                </div>
                
            </form>
        </div>
        
    </div>
    
    <div class="login_footer slideInUp"></div>
  
  </section>
</div>

<div class="clearfix"></div>

<!-- Javascript Files
    ================================================== --> 
<!-- initialize jQuery Library --> 

<!-- initialize jQuery Library --> 
<script type="text/javascript" src="../js/jquery.js"></script> 
<!-- Bootstrap jQuery --> 
<script src="../js/bootstrap.min.js"></script> 
<!-- Isotope --> 
<script src="../js/jquery.isotope.js"></script> 
<!-- SmoothScroll --> 
<script type="text/javascript" src="../js/smooth-scroll.js"></script> 
<script type="text/javascript" src="../js/waypoints.min.js"></script> 
<script type="text/javascript" src="../js/jquery.bxslider.min.js"></script> 
<script type="text/javascript" src="../js/jquery.scrollTo.js"></script> 
<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script> 
<!-- Wow Animation --> 
<script type="js/javascript" src="../js/wow.min.js"></script> 
<script src="../js/custom.js"></script>
</body>
</html>
