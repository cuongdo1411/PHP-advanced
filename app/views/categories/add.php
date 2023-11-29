
<form method="post" action="<?php echo WEB_ROOT; ?>/admin/product/add_category_action">
    <div class="mb-3">
        <label for="" class="form-label">ID</label>
        <input type="number" class="form-control" name="id" value="<?php echo end($categories)['ID'] + 1;?>" id="" value="" placeholder="" disabled>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Category: </label>
        <input type="text" class="form-control" name="category" id="" placeholder="">
        <?php echo form_error("category", "<span style='color:red'>", "</span>"); ?>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>