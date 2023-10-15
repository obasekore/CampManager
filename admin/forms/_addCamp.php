<div class="col-md-12">
    <div class="content-box-header">
	<?php

if($msg=='view')
{
	?>

        <div class="panel-title"><?php echo $camp->getName() ?> <span class="badge"><?php echo date_format(date_create($camp->getCreated_at()),'Y') ?></span></div>
        
        <div class="panel-options">
            <a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
            <a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
        </div>
    </div>
    <div class="content-box-large box-with-header">
        <div class="row">
        	<div class="col-md-12"><h4 id="headingContainer">Theme: <?php echo $camp->getTheme() ?></h4></div>
        </div>
        <div class="row well">
        	<div class="col-md-7">Location: <?php echo $camp->getLocation() ?></div>
            <div class="col-md-5">Memory verse: <?php echo $camp->getMemoryVerse() ?></div>
        </div>
        
        <div class="row">
        	<div class="col-md-12"><label class="label label-info">Director of Programme:</label><h4 > <?php echo $camp->getDOP() ?></h4></div>
        </div>
        <h4 align="center">House</h4><hr>
        <div class="row well">
        	<div class="col-md-6">
            <?php
				$house=unserialize($camp->getHouse());
			?>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Male</th>
                </tr>
              </thead>
              <tbody>
              <?php 
			  foreach($house['male'] as $a_house)
			  {
				  ?>
              	<tr>
                	<td><?php echo $a_house ?></td>
                </tr>
                <?php
			  }
			  ?>
              </tbody>
            
            </table>
            </div>
            <div class="col-md-6">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Female</th>
                </tr>
              </thead>
              <tbody>
              <?php 
			  foreach($house['female'] as $a_house)
			  {
				  ?>
              	<tr>
                	<td><?php echo $a_house ?></td>
                </tr>
                <?php
			  }
			  ?>
              </tbody>
            
            </table>
            </div>
        </div>
        <h4>Amount</h4><hr/>
        <div class="row ">
        	<div class="col-md-6 well">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Category</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
              <?php 
			  if(is_array($amount))
			  {
				  foreach($amount as $a_amount)
				  {
					  ?>
					<tr>                	
						<td><?php echo $a_amount->getCategoryName() ?></td>
						<td><?php echo $a_amount->getAmount() ?></td>
					</tr>
	
					<?php
				  }
			  }
			  else
			  {
					echo '<tr class="label-warning"><td colspan="2">No Amount attributed to any category</td></tr>';
			  }
			  ?>
              
              </tbody>
            
            </table>
            </div>
            
            <div class="col-md-6">
            	<div class="panel-footer"><label class="btn btn-block btn-info">Edit</label></div>
                <br>
                <div class="panel-footer"><label class="btn btn-block btn-danger" id="delete" onclick="confirmDelete(<?= $camp->getId() ?>)">Delete</label></div>
            </div>
            
        </div>
        
        <script>
			function confirmDelete(id)
			{
				response = confirm('Are you sure you want to delete <?= $camp->getName().' ('. date_format(date_create($camp->getCreated_at()),'Y').')' ?> Camp?');
				if(response)
				{
					window.location = "route.php?purp=CampDelete&ids="+id;
				}
			}
		
		</script>
        <br /><br />
    </div>
    <?php
}
?>
	
</div>