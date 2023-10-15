<?php
if (!isset($_SESSION)) {
	session_start();
}
/*require('../Library/Carbon/src/Carbon/carbon.php');
use Carbon\Carbon;
*/require_once("../Connections/config.php");
include_once("../inc/admin/login.inc.php");
include_once("../Library/settings.class.php");
include_once('../Library/admin.class.php');
include_once('../Library/auth.class.php');
include_once("../inc/admin/dashboard.inc.php");
include_once('../Library/camps.class.php');
include_once('../Library/attendances.class.php');
include_once('../Library/delegatedetails.class.php');
include_once('../Library/categories.class.php');
$active = $_SERVER['SCRIPT_NAME'];
include_once("../inc/admin/accessiblities.inc.php");

$System = new settings(1);
$defaultCamp = $System->getDefaultCampId();
$camps = new camps();
$all_Camp = $camps->getAll();
$attendances = new attendances();
if(!isset($_REQUEST['campId']) and isset($defaultCamp))
{
	$_REQUEST['campId']=$defaultCamp;//default campid
}
if(isset($_REQUEST['campId']))
{
	$all_Delegates_In_camp = $attendances->getByCampId($_REQUEST['campId']);
}

$admin = unserialize($_SESSION['cm_admin']);
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
      <style>
/*@media print {
  body * {
    display:none;
  }

  body .printable {
    display:block;
  }
}*/
hr {
	border-width:2px;
	border-style:dashed;
}
</style>
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
<div class="row" >
     <form action="" method="post" enctype="application/x-www-form-urlencoded" >
        <div class="col-md-1"></div>
           <div class="col-md-7">
                <select name="campId" class="form-control" id="campId">
                    <option value="">...Please Select a camp...</option>
                    <?php
                    foreach($all_Camp as $a_camp)
                    {
                    ?>
                    <option value="<?= $a_camp->getId()?>" <?= ($a_camp->getId()==$System->getDefaultCampId())?'selected':'';?>><?= $a_camp->getName().' ['.date_format(date_create($a_camp->getCreated_at()),'Y').']' ?></option>
                    <?php
                    }
                    ?>
                </select>
        </div>
        <div class="col-md-3"><input class="btn btn-info" name="submit" type="submit" value="Get Delegates"/></div>
                <div class="col-md-1"></div>

        </form>


</div>
<br>
<br>

<!--Tab begins here-->
<?php
if(!is_null($all_Delegates_In_camp))
{
		$thisCamp = new camps($_REQUEST['campId']);

	?>
		  	<div class="row">
					<div class="col-md-12">
						<div class="content-box-large">
		  				<div class="panel-heading">
							<div class="panel-title" style=" text-align:center;border-bottom:double; border-color:green"><h3>Attendance in <?= $thisCamp->getName().' '.date_format(date_create($thisCamp->getCreated_at()),'Y'); ?>  camp </h3></div>
							
							<div class="panel-options">
								<a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
								<a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
							</div>
						</div>
		  				<div class="panel-body">
		  					<div id="rootwizard">
								<div class="navbar">
								  <div class="navbar-inner">
								    <div class="container">
								<ul class="nav nav-pills">
								  	<li class="active"><a href="#tab1" data-toggle="tab">List of Delegates</a></li>
									<li><a href="#tab2" data-toggle="tab">Statistics</a></li>
								</ul>
								 </div>
								  </div>
								</div>
								<div class="tab-content">
								    <div class="tab-pane active" id="tab1">
								      <div class="panel-body">
                                    <button class="btn btn-success" id="btnPrint" value="listContainer" style="float:right"  >Print</button>
                                      <div id="listContainer">
<div class="title" style="text-align:center;border-bottom:double; border-color:green"><h3>List of Delegates in <?= $thisCamp->getName().' '.date_format(date_create($thisCamp->getCreated_at()),'Y'); ?>  camp </h3></div>	<br>
									
									<?php
                                         if(is_array($all_Delegates))
                                        {
                                                  ?>
                                            <table class="table table-hover" id="example" style="cursor:pointer">
                                              <thead>
                                                <tr>
                                                  <th>#</th>
                                                  <th>Name</th>                                                  
                                                  <th>School_Depart./Work</th>
                                                  <th>Phone Number</th>
                                                  <th>House</th>
                                                  <th>Status</th>
                                                  <th>Time-In</th>
                                                </tr>
                                              </thead>
                                              <tbody id="delegate">
                                              <?php
                                             
                                              $cnt=0;
                                              foreach($all_Delegates_In_camp as $a_Delegates_In_camp)
                                              {
                                                  $cnt++;
												  $delegateInfo = new delegatedetails($a_Delegates_In_camp->getDelegateDetailId());
												  $category = new categories($a_Delegates_In_camp->getCategoryId());
                                              ?>
                                                <tr id="<?= $a_Delegates_In_camp->getId() ?>">
                                                  <td><?php echo $cnt?></td>
                                                  <td><?= $delegateInfo->getSurname().', '.$delegateInfo->getFirstName() ?></td>
                                                  <td><?= $delegateInfo->getSchool_department_placeOfWork() ?></td>
                                                  <td><?= $delegateInfo->getPhone_number() ?></td>
                                                  <td><?= $a_Delegates_In_camp->getHouse() ?></td>
                                                  <td><?= $category->getName() ?></td>
                                                  <td><?= $a_Delegates_In_camp->getCreated_at() ?></td>
                                                </tr>
                                                <?php
                                              }
                                             
                                              ?>
                                              </tbody>
                                            </table>
                                        <?php
                                         }
                                              else
                                              {
                                                    echo '<div class="v-margin-20 alert alert-danger alert-dismissable text-center font-dot9">
                                                                    No Delegate found in the database<br>
                                                                    <a class="btn btn-info" id="regModal" data-toggle="modal" data-target="#myModal">Click here to register delegate</a>
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                                                                        aria-hidden="true">&times;</span></button>
                                                                            </div>';
                                              }
                                        
                                        ?>
                                        </div>
                                        </div>
                                        </div>
								    <div class="tab-pane" id="tab2" >                                      
                                    <button class="btn btn-success" id="btnPrint" value="StatisticsContainer" style="float:right"  >Print</button>
								      <div id="StatisticsContainer" class="printable">
<div class="title" style="text-align:center;border-bottom:double; border-color:green"><h3>Statistics of <?= $thisCamp->getName().' '.date_format(date_create($thisCamp->getCreated_at()),'Y'); ?>  camp </h3></div>

                                     <?php /*?> <?= json_encode($thisCamp->getStatOfGender());?><br>
                                      <?= json_encode($thisCamp->getStatOfCategory());?><br>
                                      <?= json_encode($thisCamp->getStatOfHouse());?><br>
                                      <?= json_encode($thisCamp->getStatOfIncome());?><br>
									  <?= json_encode($thisCamp->getResponsibleForUnderPayList());?><br><?php */?>
                                      <div class="row">
                                          <div class="col-md-6" >
                                          	<div id="GenderContainer"></div>
                                          </div>
                                          <div class="col-md-6">
                                          <?php
											$Acounting = $thisCamp->getStatOfIncome();
											$IncomeByStat = array_sum($Acounting['IncomeByStat']);
											$ActualIncome = $Acounting['ActualIncome'];
											$CashAtHand = $Acounting['Cash@hand'];
											?>
                                          	<div id="Expected_ActualContainer"><br>
<br>

                                            <h1>Account</h1>
                                            <table width="60%" class="table table-bordered" border="0" cellspacing="3" cellpadding="1">
                                              <tr>
                                                <th scope="col">Expected Income</th>
                                                <th scope="col">Actual Income</th>
                                                <th scope="col">Cash at Hand</th>
                                              </tr>
                                              <tr>
                                                <td><?= $IncomeByStat ?></td>
                                                <td>&nbsp;<?= $ActualIncome ?></td>
                                                <td>&nbsp;<?= $CashAtHand ?></td>
                                              </tr>
                                            </table>

                                            </div>
                                          </div>
                                       </div>
                                       <hr>
                                      <div class="row">
                                          <div class="col-md-9" >
                                          	<div id="container"></div>
                                          </div>
                                          <div class="col-md-3"><br>
<br>

											<table id="datatable1" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Male</th>
                                                    <th>Female</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                          <?php
                                          $table1 = $thisCamp->getStatOfCategory();
                                          foreach($table1 as $title=>$table2)
                                          {
                                              
                                              ?>
                                              <tr>
                                                <th><?= $title ?></th>
                                                <?php
                                                foreach($table2 as $gender=>$table)
                                                {
                                                    ?>
                                                    <td><?= $table ?></td>
                                                    <?php
                                                }
                                                ?>
                                                </tr>
                                                <?php
                                          }
                                          ?>
                                          </tbody>
                                          </table>

                                          </div>
                                      </div>
                                      <hr>
                                      <div class="row">
                                          <div class="col-md-12" >
                                          	<div id="HouseContainer"></div>
                                          </div>
                                       </div>


								    </div></div>
									<!--Tab 2 end-->
								</div>	
							</div>
		  				</div>
		  			</div>
					</div>
                    </div>
                   <div class="row" id="publicDump">
                   
                   </div> 
                   
                    <?php
}
?>
                <!--End of tab-->

		  		
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
<script src="../Highcharts-5.0.14/code/highcharts.js"></script>
<script src="../Highcharts-5.0.14/code/highcharts-3d.js"></script>
<script src="../Highcharts-5.0.14/code/modules/data.js"></script>
    <script src="../js/printThis.js"></script>
        <script>
                $(document).on("click", "#btnPrint", function (e) {
					container=this.value;
                    e.preventDefault();
                    e.stopPropagation();
                    $("#"+container).printThis({
                        debug: false,               // show the iframe for debugging
                        importCSS: true,            // import page CSS
                        importStyle: true,          // import style tags
                        printContainer: true,       // grab outer container as well as the contents of the selector
                        loadCSS:"../css/print.css", // path to additional css file - us an array [] for multiple
                        pageTitle: "",              // add title to print page
                        removeInline: false,        // remove all inline styles from print elements
                        printDelay: 333,            // variable print delay; depending on complexity a higher value may be necessary
                        header: null,               // prefix to html
                        formValues: true            // preserve input/form values
                    });

                });
            </script>

<script type="text/javascript">

Highcharts.chart('container', {
    data: {
        table: 'datatable1'
    },
    chart: {
        type: 'column'
    },
    title: {
        text: 'Statistics of Delegates By Category'
    },
    yAxis: {
        allowDecimals: false,
        title: {
            text: 'Units'
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.series.name + '</b><br/>' +
                this.point.y + ' ' + this.point.name.toLowerCase();
        }
    }
});
		</script>
        
        <script type="text/javascript">
<?php
$gender = $thisCamp->getStatOfGender();
?>
Highcharts.chart('GenderContainer', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: 'Chart of Male Vs Female Delegates On Camp'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}: <b>{point.y} delegate(s)</b>'
            }
        }
    },
    series: [{
        type: 'pie',
        name: 'Gender share',
        data: [
            {
                name: 'Male',
                y: <?= $gender['Male']?>,
                sliced: true,
                selected: true
            },
			{
                name: 'Female',
                y: <?= $gender['Female']?>,
                sliced: true,
                selected: true
            }
        ]
    }]
});
</script>

<?php

$getHouseValue = implode(',',array_values($thisCamp->getStatOfHouse()));
$getHouseKeys = array_keys($thisCamp->getStatOfHouse());
//Obtain Usable key with ""
$temp2 = "";
foreach($getHouseKeys as $id=>$getHouseKey)
{
	$temp2 .= '"'.$getHouseKey.'"';
	if($id != (count($getHouseKeys)-1))
	{
		$temp2 .=',';
	}
}
?>
<script type="text/javascript">

Highcharts.chart('HouseContainer', {
    chart: {
        type: 'column',
        options3d: {
            enabled: true,
            alpha: 10,
            beta: 25,
            depth: 70
        }
    },
    title: {
        text: 'Chart of Delegates in each houses'
    },
    subtitle: {
        text: 'Note: This visualization is to balance the population of delegates in allocated houses'
    },
    plotOptions: {
        column: {
            depth: 25
        }
    },
    xAxis: {
        categories: [<?= $temp2 ?>]
    },
    yAxis: {
        title: {
            text: null
        }
    },
    series: [{
        name: 'Houses',
        data: [<?= $getHouseValue?>]
    }]
});
		</script>
        
        <script>
		$('#delegate tr').click(function(){
		id=this.id;
		$('#loader').show('slow');
		$.ajax({
			type: 'POST',
			url: 'route.php',
			data:{ids:id,purp:'delegateProfile'},
			success: function (msg) {
				$('#publicDump').html('');
				$('#publicDump').html(msg);
				$('#loader').hide('slow');
				$('#regModal').trigger('click');
			}
		});		

		});

		</script>

<!-- InstanceEndEditable -->
  </body>
<!-- InstanceEnd --></html>