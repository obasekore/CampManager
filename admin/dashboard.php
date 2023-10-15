<?php
if (!isset($_SESSION)) {
	session_start();
}

require_once("../Connections/config.php");
include_once("../inc/admin/login.inc.php");
include_once("../Library/settings.class.php");
include_once('../Library/admin.class.php');
include_once('../Library/auth.class.php');
include_once("../inc/admin/dashboard.inc.php");
$active = $_SERVER['SCRIPT_NAME'];
include_once("../inc/admin/accessiblities.inc.php");

$System = new settings(1);
//$admin = unserialize($_SESSION['cm_admin']);
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/index.dwt.php" codeOutsideHTMLIsLocked="false" -->
  <head>
  <!-- InstanceBeginEditable name="doctitle" -->
  <title><?php echo $System->getEstName() ?>v3</title>
  <!-- InstanceEndEditable -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery UI -->
    <link href="../css/jquery-ui.css" rel="stylesheet" media="screen">
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
    <style>
		/* Firefox Keyframe Animation */
@-moz-keyframes pulse{
	0%{		color: #FFF;}
	50%{	color: #0F0;}
	100%{	color: #0FF;}
	
	0%{		box-shadow:0 0 1px #FFF;}
	50%{	box-shadow:0 0 15px #FFF;}
	100%{	box-shadow:0 0 1px #FFF;}
}

/* Webkit keyframe animation */
@-webkit-keyframes pulse{
	0%{		color: #FFF;}
	50%{	color: #0F0;}
	100%{	color: #0FF;}

	0%{		box-shadow:0 0 1px #FFF;}
	50%{	box-shadow:0 0 15px #FFF;}
	100%{	box-shadow:0 0 1px #FFF;}
}
#headingContainer {
	
	/* Enabling a smooth animated transition 
	-moz-transition:0.8s;
	-webkit-transition:0.8s;
	transition:0.8s;*/
	
	/* Configure a keyframe animation for Firefox */
	-moz-animation: pulse 2s infinite;
	
	/* Configure it for Chrome and Safari */
	-webkit-animation: pulse 2s infinite;
}
#loader
{
	position:fixed;
	top:300px;
	left:0px;
	background-image:url(../images/giphy.gif);
	height:250px;
	width:300px;
	z-index:1;	
}
	</style>
  <!-- InstanceBeginEditable name="head" -->
   <link href="../css/stats.css" rel="stylesheet">

  <!-- InstanceEndEditable -->
  </head>
  <body>
  <div id="loader"></div>
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-10">
	              <!-- Logo -->
	              <div class="logo" >
                  <img src="../<?php echo $System->getLogo()?>" width="50px" class="img-rounded" align="logo" height="50px"/>
	                 <h2  style="margin-top:5px;display:inline; color: white;"><a id="headingContainer" href="residue/index.php"><?php echo $System->getEstName() ?></a></h2>
	              </div>
	           </div>
	           
	           <div class="col-md-2">
	              <div class="navbar navbar-inverse" role="banner">
	                  <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
	                    <ul class="nav navbar-nav">
	                      <li class="dropdown">
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $admin->getFirstname()?><b class="caret"></b></a>
	                        <ul class="dropdown-menu animated fadeInUp">
	                          <li><a href="../Bootstrap-Admin-Theme-3-master/profile.html">Profile</a></li>
	                          <li><a href="logout.php">Logout</a></li>
	                        </ul>
	                      </li>
	                    </ul>
	                  </nav>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

    <div class="page-content">
    	<div class="row">
		  <div class="col-md-2">
		  	<div class="sidebar content-box" style="display: block;">
                <ul class="nav">
                    <!-- Main menu -->
                    <?php
					$hisMenu = $admin->getAccessiblity();
					$active = $_SERVER['SCRIPT_NAME'];
					$active = explode('/',$active);
					$active = $active[count($active)-1];
					foreach($hisMenu as $menu)
					{
						?>
                    <li <?= ($active==$menu->getUrl())? 'class="current"':''; ?>><a href="<?= $menu->getUrl() ?>"><i class="glyphicon glyphicon-home"></i> <?= $menu->getTitle() ?></a></li>
                    <?php
					}
					?>
                </ul>
             </div>
		  </div>
		  <div class="col-md-10">
          <div class="row">
  	<div class="col-md-2"></div>
    <div class="col-md-8">
    	<?php
                    if (!empty($errmsg)) {
                        ?>
                        <div class="v-margin-20 alert alert-danger alert-dismissable text-center font-dot9">
                            <?php echo $errmsg; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <?php
                    } else if (!empty($successmsg)) {
                        ?>
                        <div class="v-margin-20 alert alert-success alert-dismissable text-center">
                            <?php echo $successmsg; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <?php
                    }
                    ?>
    </div>
    <div class="col-md-2"></div>
  </div>
<!-- InstanceBeginEditable name="EditRegion1" -->
		  	<div class="row">
		  		<div class="col-md-6">
		  			<div class="content-box-large">
		  				<div class="panel-heading text-warning">
							<div class="panel-title">Welcome <?php echo $admin->getLastname().' '.$admin->getFirstname()?>,</div>
							
							<div class="panel-options">
								<a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
								<a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
							</div>
						</div>
		  				<div class="panel-body">
                                Last login [<?= date('Y-m-d h:i:s',$admin->getLastLogin()) ?>]
						  <br /><br />
		  				</div>
		  			</div>
		  		</div>

		  		
		  	</div>
 <!-- InstanceEndEditable -->
		  	
		  </div>
		</div>
    </div>

<div id="footercont" class="clearfix">
    	<p>Camp Manager Version 3.0 &nbsp;|&nbsp; A Product of  <a title="Standard Bearers Islamic Organization" href="#" rel="external">SB IT</a></p>
    </div>
   <!-- <footer>
         <div class="container">
         
            <div class="copy text-center">
               Copyright 2014 <a href='#'>Website</a>
            </div>
            
         </div>
      </footer>
-->
 <link href="../vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery.js"></script>
    <!-- jQuery UI -->
    <script src="../js/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    
        <script src="../vendors/datatables/js/jquery.dataTables.min.js"></script>

    <script src="../vendors/datatables/dataTables.bootstrap.js"></script>

    <script src="../js/custom.js"></script>
    <script src="../js/tables.js"></script> 
  <script>
		$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
	$('#loader').hide();  

    </script>
<!-- InstanceBeginEditable name="EditRegion2" -->

<!-- InstanceEndEditable -->
  </body>
<!-- InstanceEnd --></html>