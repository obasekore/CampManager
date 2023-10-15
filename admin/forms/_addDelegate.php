
<form action="actions/registerDelegateAction.php" method="post" enctype="multipart/form-data">
<?php
if($msg=='view')
{
?>
                        <div id="all">
                                <div id="zone1">
                                <h3>Personal Details</h3>
                                <div class="row">
                                <div class="col-md-4">
                                	<div class="form-group">
                                        <label>Surname</label>
                                        <input class="form-control" type="text" name="delegateSurname" placeholder ="Delegate's Name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                         <div class="form-group">
                                        <label>First Name</label>
                                        <input class="form-control" type="text" name="delegateFirstName" placeholder ="Delegate's Name">
                                        </div>
                                 </div>
								<div class="col-md-4">
                                         <div class="form-group">
                                        <label>Other Name</label>
                                        <input class="form-control" type="text" name="delegateOtherName" placeholder ="Delegate's Name">
                                        </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-4">
                                 <div class="form-group" id="genderDiv">
                                <label>Gender</label>
                                <input class="radio-inline" type="radio" name="delegateGender" id="Gender" value="Male"> Male <input class="radio-inline" type="radio" name="delegateGender" id="Gender"  value="Female"> Female
                                </div><br />
                                 <div class="form-group">
                                <label>State</label>
                                		<select name="delegateState" >
                                        	<option>.......</option>
                                        </select>
                                 </div>

                                </div>
                                <div class="col-md-8">
                                <div class="form-group">
                                <label>Address</label>
                                <textarea rows="4" name="address" class="form-control" ></textarea>
                                </div>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                         <div class="form-group">
                                            <label>School/Place of Work</label>
                                            <input class="form-control" type="text" name="school_department_placeOfWork" placeholder ="Delegate's Place of work">
                                        </div>
                                    </div>
                                        <div class="col-md-4">
                                             <div class="form-group">
                                                <label>Phone Number</label>
                                                <input class="form-control" type="tel" name="phone" >
                                            </div>
                                        </div>
                                    <div class="col-md-4">
                                     <div class="form-group">
                                    <label>E-mail</label>
                                    <input class="form-control" type="email" name="eMail" placeholder ="Delegate's Name">
                                    </div>
                                    </div>
                                </div>
                                <br /><br /></div>
                                <div id="zone2" style="display:none">
                                <h3>Next of Kin</h3>
                                <div class="row">
                                <div class="col-md-4">
                                	<div class="form-group">
                                        <label>Name</label>
                                        <input class="form-control" type="text" name="nokName" placeholder ="Name of Next of Kin">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Phone Number</label>
                                    <input class="form-control" type="tel" name="nokPhone" placeholder="Phone no. of next of kin">
                                </div>
                                </div>
								<div class="col-md-4">
                                <div class="form-group">
                                <label>Address</label>
                                <textarea rows="4" name="nokaddress" class="form-control" placeholder="Address of next of kin" ></textarea>
                                </div>
                                </div>
                                </div>
                                <div class="form-group">
                                <label></label>
                                </div>
						  <br /><br />
                          </div>
                          
                          <div id="zone3" style="display:none">
                                <h3>Payment Information</h3>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>House</label>
                                            <div id="houseDiv">
                                            
                                            </div>
                                        </div>
                                    </div>
                                  <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Status</label>                                            
                                            <?php
											  $temp="";
											  $temp2 = array();
											  if(is_array($amount))
											  {
												  echo '<select name="delegateStatus" class="form-control"><option value="">...Select Status...</option>';
												 
												  foreach($amount as $a_amount)
												  {
													  ?>
														<option value="<?= $a_amount->getCategoryId() ?>"><?= $a_amount->getCategoryName() ?></option>
															<?php $temp2[$a_amount->getCategoryId()] =$a_amount->getAmount();?>
													<?php
												  }
												  echo '</select>';
											  }
											   else
											  {
													echo '<div class="label-warning">No Amount attributed to any category</div>';
											  }
										  ?>
                                        </div>
                                    </div>
                                 <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" step="100" min="0" name="amount" class="form-control" id="actualAmount" required>
                                            <div id="amountDiv">
                                            	
                                            </div>
                                        </div>
                                    </div>
                                </div>
						  <br /><br />
                          </div>
                          </div>
                          <div class="row">
                          	<div class="col-md-4"><input type="submit" class="btn btn-info" onclick="remove()" name="submit" value="Save" /></div>
                          	<div class="col-md-4"><input class="btn btn-success" type="submit" name="submit" value="Save & Attend" /></div>
                           	<div class="col-md-4"></div>
                           </div>

<?php						   
}
else if($msg=='update')
{
	?>
                        <div id="all">
                                <div id="zone1">
                                <h3>Personal Details</h3>
                                <div class="row">
                                <div class="col-md-4">
                                	<div class="form-group">
                                        <label>Surname</label>
                                        <input class="form-control" type="text" name="delegateSurname" value="<?= $Delegate->getSurname() ?>" placeholder ="Delegate's Name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                         <div class="form-group">
                                        <label>First Name</label>
                                        <input class="form-control" type="text" name="delegateFirstName" value="<?= $Delegate->getFirstName() ?>"  placeholder ="Delegate's Name">
                                        </div>
                                 </div>
								<div class="col-md-4">
                                         <div class="form-group">
                                        <label>Other Name</label>
                                        <input class="form-control" type="text" name="delegateOtherName" value="<?= $Delegate->getOtherName() ?>"  placeholder ="Delegate's Name">
                                        </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-4">
                                 <div class="form-group" id="genderDiv">
                                <label>Gender</label>
                                <input class="radio-inline" type="radio" name="delegateGender" id="Gender" value="Male"> Male <input class="radio-inline" type="radio" name="delegateGender" id="Gender"  value="Female"> Female
                                </div><br />
                                 <div class="form-group">
                                <label>State</label>
                                		<select name="delegateState" >
                                        	<option>.......</option>
                                        </select>
                                 </div>

                                </div>
                                <div class="col-md-8">
                                <div class="form-group">
                                <label>Address</label>
                                <textarea rows="4" name="address" class="form-control" ><?= $Delegate->getAddress() ?></textarea>
                                </div>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                         <div class="form-group">
                                            <label>School/Place of Work</label>
                                            <input class="form-control" type="text" value="<?= $Delegate->getSchool_department_placeOfWork() ?>"  name="school_department_placeOfWork" placeholder ="Delegate's Place of work">
                                        </div>
                                    </div>
                                        <div class="col-md-4">
                                             <div class="form-group">
                                                <label>Phone Number</label>
                                                <input class="form-control" type="tel" value="<?= $Delegate->getPhone_number() ?>"  name="phone" >
                                            </div>
                                        </div>
                                    <div class="col-md-4">
                                     <div class="form-group">
                                    <label>E-mail</label>
                                    <input class="form-control" type="email" name="eMail" value="<?= $Delegate->getEmail() ?>"  placeholder ="Delegate's Name">
                                    </div>
                                    </div>
                                </div>
                                <br /><br /></div>
                                <div id="zone2" style="display:none">
                                <h3>Next of Kin</h3>
                                <div class="row">
                                <div class="col-md-4">
                                	<div class="form-group">
                                        <label>Name</label>
                                        <input class="form-control" type="text" name="nokName" value="<?= $Delegate->getName_next_of_kin() ?>"  placeholder ="Name of Next of Kin">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Phone Number</label>
                                    <input class="form-control" type="tel" name="nokPhone" value="<?= $Delegate->getNumber_next_of_kin() ?>"  placeholder="Phone no. of next of kin">
                                </div>
                                </div>
								<div class="col-md-4">
                                <div class="form-group">
                                <label>Address</label>
                                <textarea rows="4" name="nokaddress" class="form-control"  placeholder="Address of next of kin" ><?= $Delegate->getAddress_next_of_kin() ?></textarea>
                                </div>
                                </div>
                                </div>
                                <div class="form-group">
                                <label></label>
                                </div>
						  <br /><br />
                          </div>
                          
                          <div id="zone3" style="display:none">
                                <h3>Payment Information</h3>
                                <div class="row">
                                <?php 
								//If Delegate is NOT already present in this camp; show this ||
								if($isPresent)
								{
								?>
                                 <div class="col-md-4">
                                        <div class="form-group">
                                            <label>House</label>
                                            <div >
                                            	<h4><?= $isPresent->getHouse(); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                  <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Status</label>                                            
                                            <h4><?= $hisCategory->getName() ?></h4>
                                        </div>
                                    </div>
                                 <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <div id="amountDiv">
                                            <?php
											if($isPresent->getUnderPay()>0 or !empty($isPresent->getPersonResponsible()))
											{
												$forUnderPay=true; //To filter off the attend, attend & update button
											?>
                                            <!--//if isUnderpay show personResponsible, textBox_for_amount_paid and updatePaymentBtn-->
                                            	<input type="hidden" id="expectedAmount" value="<?= $amount ?>" /><!--//Get and put expected amount for this category
                                                //Use js to remove personResponsible once is equal to-->
                                            	<input type="number" step="100" value="<?= $amount-$isPresent->getUnderPay(); ?>" onchange="adJust()"  class="form-control" min="0" name="amount" id="actuaAmount" required><br />
                                                <div id="DIVpersonResponsible">
												<input type="text" name="personResponsible" id="personResponsible" class="form-control" value="<?= $isPresent->getPersonResponsible() ?>" /></div><br />

                                                 <div class="btn btn-warning" id="UpdatePayment" onclick="UpdatePayment(<?= $isPresent->getId() ?>)" >Update Delegate Payment</div>
                                                 <br /><br />

												<div class="btn btn-danger" id="deRegister" onclick="deRegister(<?= $isPresent->getId() ?>)" >De-Register Delegate</div>
                                                 <script>
//												 var isMyLiability = $('#personResponsible').val();
												 var tempText = '<input type="text" name="personResponsible" id="personResponsible" class="form-control" value="<?= $isPresent->getPersonResponsible() ?>" />';
												 function adJust()
												 {
														newAmount = $('#actuaAmount').val();
														Expected = $('#expectedAmount').val();
														
													 if(newAmount==Expected)
													 {
														$('#personResponsible').remove();
													 }
													 else
													 {
														 $('#DIVpersonResponsible').html(tempText);
													 }
													 
												 }
												 function UpdatePayment(id){
													 response = confirm("Are you sure you want to Update <?= $Delegate->getSurname().', '.$Delegate->getFirstName(); ?>'s Payment?");
													 if(response)
													{
														newAmount = $('#actuaAmount').val();
														isMyLiability = ($('#personResponsible').val())?$('#personResponsible').val():"";
														//less secure but I have to use it like this:: no time
														Expected = $('#expectedAmount').val();
														$('#loader').show('slow');
																$.ajax({
																	type: 'POST',
																	url: 'route.php',
																	data:{ids:id,amount:newAmount,statusExpectedAmount:Expected,personResponsible:isMyLiability,purp:'UpdateDelegatePayment'},
																	success: function (msg) {
																		$('#modalClose').trigger('click');
																		$('#publicDump').html('');
																		$('#publicDump').html(msg);
																		$('#loader').hide('slow');
																		
																	}
																});															
													}
                                                }
												 </script>

                                           	<?php
											}
											else
											{
												$forUnderPay=true; //To filter off the attend, attend & update button
											?>
                                            <h4><?= $amount; ?></h4><br />

                                            <div class="btn btn-danger" id="deRegister" onclick="deRegister(<?= $isPresent->getId() ?>)" >De-Register Delegate</div>
                                            
                                            <!--'else
'                                            show Status, amount and deRegisterFromCamp-->

                                            <?php
											}
											?>
                                            <script>
                                            	function deRegister(id){
                                                	response = confirm('Are you sure you want to DeRegister <?= $Delegate->getSurname().', '.$Delegate->getFirstName(); ?> from this camp?');

													if(response)
													{
														$('#loader').show('slow');
																$.ajax({
																	type: 'POST',
																	url: 'route.php',
																	data:{ids:id,purp:'deletAttendanceForCamp'},
																	success: function (msg) {
																		$('#publicDump').html('');
																		$('#publicDump').html(msg);
																		$('#loader').hide('slow');
																		$('#modalClose').trigger('click');
																	}
																});															
													}
                                                }
												
                                            </script>
                                            </div>
                                        </div>
                                    </div>
                                
                                <?php
								}
								else 
								{//Otherwise show his camp information
									?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>House</label>
                                            <div id="houseDiv">
                                           
                                            </div>
                                        </div>
                                    </div>
                                  <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Status</label>                                            
                                            <?php
											  $temp="";
											  $temp2 = array();
											  if(is_array($amount))
											  {
												  echo '<select name="delegateStatus"  class="form-control"><option value="">...Select Status...</option>';
												 
												  foreach($amount as $a_amount)
												  {
													  ?>
														<option value="<?= $a_amount->getCategoryId() ?>"><?= $a_amount->getCategoryName() ?></option>
															<?php $temp2[$a_amount->getCategoryId()] =$a_amount->getAmount();?>
													<?php
												  }
												  echo '</select>';
											  }
											   else
											  {
													echo '<div class="label-warning">No Amount attributed to any category</div>';
											  }
										  ?>
                                        </div>
                                    </div>
                                 <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" class="form-control" step="100" min="0" name="amount" id="actualAmount" required>
                                            <div id="amountDiv" class="personResponsible">
                                            	
                                            </div>
                                        </div>
                                    </div>
                                    <?php
								}
								?>
                                </div>
						  <br /><br />
                          </div>
                          </div>
                          <div class="row">
                          <input type="hidden" name="ids" value="<?= $Delegate->getId() ?>" />
                          	<div class="col-md-4"><input type="submit" onclick="remove()" class="btn btn-info" name="submit" value="Update Record" /></div>
                          	<?php if(@!$forUnderPay){?>
                            <div class="col-md-4"><input class="btn btn-success" type="submit" name="submit" value="Update Record & Attend Camp" /></div>
                           	<div class="col-md-4"><input class="btn btn-success" type="submit" name="submit" value="Attend Camp" /></div>
                            <?php } ?>
                           </div>
    
<?php
}
?>
    
                          </form>
                          <div class="row">
                          <div class="col-md-4"></div><div class="col-md-4"></div>
                          <div class="col-md-4">
                          <div class="nav" align="right"><label class="btn btn-primary" id="forward">>></label></div>
                          </div>
                          </div>
<?php

if(isset($Delegate) or $isAjax)
{
	@include_once('script.php');
}

?>

<script>
function remove()
{
	$('#zone3').remove()
}
</script>