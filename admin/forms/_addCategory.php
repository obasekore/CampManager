<form method="post" enctype="multipart/form-data" action="actions/categoriesAction.php">
<?php
if(@$msg=='edit')
{
	?>
    <div class="form-group">
    <input type="hidden" name="from" value="CatUpdate">
    <input type="hidden" name="id" value="<?php echo $category->getId() ?>">
    <label for="name">Name</label>
    <input type="text" placeholder="Enter name of category" name="nameCat" class="form-control" required value="<?php echo $category->getName()?>" />
 </div>
 <div class="form-group">
    <label for ="description">Description</label>
    <textarea name="descriptionCat" placeholder="Enter description of category" cols="10" rows="3" class="form-control"><?php echo $category->getDescription()?></textarea>
    </div>
    <div class="panel-footer">
    <input type="submit" class="btn btn-block btn-primary" name="submit" value="Update Category">
    </div>
  <?php
}
else {
?>
<div class="form-group">
    <label for="name">Name</label>
    <input type="text" placeholder="Enter name of category" name="nameCat" class="form-control" required />
 </div>
 <div class="form-group">
    <label for ="description">Description</label>
    <textarea name="descriptionCat" placeholder="Enter description of category" cols="10" rows="3" class="form-control"></textarea>
    </div>
    <div class="panel-footer">
    <input type="submit" class="btn btn-block btn-primary" name="submit" value="Create Category">
    </div>
    <?php
}
?>
</form>
