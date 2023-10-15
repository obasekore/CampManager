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
                        
            	<div class="input-group form">
	                       <input type="text" class="form-control" id="EstName" value="<?= $EstName?>" placeholder="Establishment Name">
	                       <span class="input-group-btn">
	                         <button class="btn btn-primary" type="button" id="setEstName">Change Name</button>
	                       </span>
	            </div>
            </div>
          <br /><br />
        </div>
    </div>
</div>
<script >
$('#setEstName').click(function(){
	EstName= $('#EstName').val();
	$('#loader').show('slow');
		$.ajax({
			type: 'POST',
			url: 'route.php',
			data:{ids:EstName,purp:'setEstablishName'},
			success: function (msg) {
				$('#publicDump').html('');
				$('#publicDump').html(msg);
				$('#loader').hide('slow');
			}
		});		
});
</script>