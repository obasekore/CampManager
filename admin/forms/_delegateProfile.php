<div id="all">
        <div id="zone1">
            
            <div class="row">
                <div class="col-md-6">
		  			<div class="content-box-large">
		  				<div class="panel-heading text-warning">
							<div class="panel-title"><h3>Personal Details</h3></div>
							
							<div class="panel-options">
								<a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
								<a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
							</div>
						</div>
		  				<div class="panel-body">
                              <label>Name:</label> <?=(($Delegate->getGender()=='Male')?'Brother, ':'Sister, '). $Delegate->getSurname().', '.$Delegate->getFirstName().' '.$Delegate->getOtherName() ?><br />
                              <label>Address:</label> <address class="well"><?= $Delegate->getAddress() ?></address><br />
                              <label>School/Work:</label> <?= $Delegate->getSchool_department_placeOfWork() ?><br />
                              <div style="display:inline-block"><span align="left"><label>E-mail:</label> <?= $Delegate->getEmail() ?></span>&nbsp;&nbsp;&nbsp;
                              <span align="right"><label>Phone Number:</label> <?= $Delegate->getPhone_number() ?></span></div><br />
                              <hr />
                              <label>Name of Next of Kin:</label> <?= $Delegate->getName_next_of_kin() ?><br />
                              <label>Address of Next of Kin:</label> <address class="well"><?= $Delegate->getAddress_next_of_kin() ?></address><br />
                              <label>Phone Number of Next of Kin:</label> <?= $Delegate->getNumber_next_of_kin() ?><br />
                              
						  <br /><br />
                          
		  				</div>
		  			</div>
		  		</div>  
                
                <div class="col-md-6">
		  			<div class="content-box-large">
		  				<div class="panel-heading text-warning">
							<div class="panel-title">Delegate's Camp History</div>
							
							<div class="panel-options">
								<a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
								<a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
							</div>
						</div>
		  				<div class="panel-body">
                        <?php
						if(!is_null($myAttendances))
						{
						foreach($myAttendances as $myAttendance)
						{
							?>
                            <h4><?= $myAttendance->getCampName() ?></h4>
                            <div class="well">
                              <label>House:</label> <?= $myAttendance->getHouse() ?><br />

                              <?php
							  if($myAttendance->getUnderpay()>0 or !empty($myAttendance->getPersonResponsible()))
							  {
								  ?>
                                  <div class="alert-danger">
                              <label>UnderPaid:</label> <?= $myAttendance->getUnderpay() ?><br />
                              <label>Person Responsible for Balance:</label> <?= $myAttendance->getPersonResponsible() ?>
                              </div>
                                  <?php
							  }
							  ?>
                              <label>Categroy Name:</label> <?= $myAttendance->getCategoryName() ?><br />
                              <label>Categroy Amount:</label> #<?= $myAttendance->getCampCategoryAmount() ?><br />

                              </div>
                         <?php
						}
						}
						?>
						  <br /><br />
		  				</div>
		  			</div>
		  		</div>              
            </div>
         
         </div>
</div>
<br />
<br />
<br />
<br />
