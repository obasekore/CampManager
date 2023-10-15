<div class="row">
    <div class="col-md-12">
        <div class="content-box-header">
            <div class="panel-title">Register New Admin</div>
            
            <div class="panel-options">
                <a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
                <a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
            </div>
        </div>
        <div class="content-box-large box-with-header">
            <div id="content">
            <form id="adminForm">
            	<div class="form-group">
                	<label>First Name</label>
                    <input class="form-control" type="text" name="firstName" required placeholder="Admin first name" >
                </div>
            	<div class="form-group">
                	<label>Last Name</label>
                    <input class="form-control" type="text" name="lastName" required placeholder="Admin last name" >
                </div>
            	<div class="form-group">
                	<label>Username</label>
                    <input class="form-control" type="text" name="username" required placeholder="Admin username" >
                </div>
            	<div class="form-group">
                	<label>E-mail</label>
                    <input class="form-control" type="email" name="email" required placeholder="Admin E-mail" >
                </div>
            	<div class="form-group">
                	<label>Password</label>
                    <input class="form-control" type="password" name="pwd" required placeholder="Admin E-mail" >
                </div>
                <div class="form-group">
                	<label>Role</label>
                    <select name="role" class="form-control" required>
                    <option value="">...Please Select a Role...</option>
                    	<?php
							foreach($roles as $a_role)
							{
						?>
                        <option value="<?= $a_role->getId() ?>"><?= $a_role->getTitle() ?></option>
                        <?php
							}
							?>
                    </select>

                </div>
                    <span class="input-group-btn">
                     <input type="submit" class="btn btn-primary" id="regAdmin" value="Add Admin" name="submit">
                   </span>

             </form>

                </div>
            </div>
          <br /><br />
        </div>
    </div>
</div>
<script >
$('#regAdmin').click(function(e){
	e.preventDefault();
	var formData= $('#adminForm').serialize();
	$('#loader').show('slow');
		$.ajax({
			type: 'POST',
			url: 'route.php',
			data:{data:formData,purp:'addAdmin'},
			success: function (msg) {
				$('#publicDump').html('');
				$('#publicDump').html(msg);
				$('#loader').hide('slow');
			}
		});		
});
</script>