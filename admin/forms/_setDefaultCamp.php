<?php 
$allCamp = $camp->getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="content-box-header">
            <div class="panel-title">Set Default Camp</div>
            
            <div class="panel-options">
                <a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
                <a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
            </div>
        </div>
        <div class="content-box-large box-with-header">
            <div id="content">
                        Default Camp<div class="v-margin-20 alert alert-info alert-dismissable text-center font-dot9">
                        <?= $camp->getName()?><span class="badge"><?php echo date_format(date_create($camp->getCreated_at()),'Y') ?></span><div class="col-md-12"><label class="label label-info"><?= $camp->getTheme() ?></label></div>
                        </div>
            	<div class="input-group form">
                   <select class="form-control" id="defaultCamp" name="defaultCamp">
                   	<?php
					foreach($allCamp as $aCamp)
					{
					?>	
						<option value="<?= $aCamp->getId() ?>" <?= ($aCamp->getId()==$camp->getId())?'selected':'' ?>><?= $aCamp->getName() ?></option>
					<?php
					}
					?>                 	
                   </select>
                   <span class="input-group-btn">
                     <button class="btn btn-primary" id="setDefault" type="button">Set As Default</button>
                   </span>
                </div>
            </div>
          <br /><br />
        </div>
    </div>
</div>
<script >
$('#setDefault').click(function(){
	defaultCamp= $('#defaultCamp').val();
	$('#loader').show('slow');
		$.ajax({
			type: 'POST',
			url: 'route.php',
			data:{ids:defaultCamp,purp:'setDefaultCamp'},
			success: function (msg) {
				$('#publicDump').html('');
				$('#publicDump').html(msg);
				$('#loader').hide('slow');
			}
		});		
});
</script>