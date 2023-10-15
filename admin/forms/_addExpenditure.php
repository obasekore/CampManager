<form action="actions/registerExpenditureAction.php" method="post" enctype="application/x-www-form-urlencoded">
<?php
if($msg=='new')
{
	?>
<div class="row">
	<div class="form-group">
    <input type="hidden" name="campId" value="<?=$thisCamp->getId() ?>"/>
		<label>Name of Withdrawer</label>
        <input class="form-control" type="text" name="name" placeholder="Enter Name of Withdrawer" required />
	</div>
	<div class="form-group">
		<label>Purpose of Withdrawal</label>
        <textarea class="form-control" name="purpose" placeholder="Enter the purpose of withdrawal" required ></textarea>
	</div>
	<div class="form-group">
		<label>Phone Number of Withdrawer</label>
        <input class="form-control" type="tel" name="phoneNumber" placeholder="Enter the Phone Number of withdrawer" required />
	</div>
	<div class="form-group">
		<label>Amount withdrew</label>
        <input class="form-control" type="number" step="100" name="amount" placeholder="Enter the Amount withdrew" required />
	</div>
    <input class="btn btn-success" type="submit" name="submit" value="Submit Withdrawal"/>
</div>
</form>
<?php
}
else if($msg=='update')
{
	
	?>
	<div class="row">
	<div class="form-group">
    <input type="hidden" name="id" value="<?= $expenditure->getId()?>"/>
		<label>Name of Withdrawer</label>
        <input class="form-control" type="text" name="name" value="<?= $expenditure->getName() ?>" placeholder="Enter Name of Withdrawer" required />
	</div>
	<div class="form-group">
		<label>Purpose of Withdrawal</label>
        <textarea class="form-control" name="purpose" placeholder="Enter the purpose of withdrawal" required ><?= $expenditure->getPurpose()?></textarea>
	</div>
	<div class="form-group">
		<label>Phone Number of Withdrawer</label>
        <input class="form-control" type="tel" name="phoneNumber" value="<?= $expenditure->getPhoneNumber()?>" placeholder="Enter the Phone Number of withdrawer" required />
	</div>
	<div class="form-group">
		<label>Amount withdrew</label>
        <input class="form-control" type="number" step="100" name="amount" value="<?= $expenditure->getAmount()?>" placeholder="Enter the Amount withdrew" required />
	</div>
    <input class="btn btn-success" type="submit" name="submit" value="Update Withdrawal"/>
    <input class="btn btn-danger" type="submit" name="submit" value="Delete Withdrawal"/>
</div>
</form>
<?php
}
?>
