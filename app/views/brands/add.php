
<form method="post" action="<?php echo WEB_ROOT; ?>/admin/product/add_brand_action">
    <div class="mb-3">
        <label for="" class="form-label">ID</label>
        <input type="number" class="form-control" name="idBrand" value="<?php echo end($brands)['ID'] + 1;?>" id="" value="" placeholder="" disabled>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Brand</label>
        <input type="text" class="form-control" name="mainBrand" id="" placeholder="">
        <?php echo form_error("mainBrand", "<span style='color:red'>", "</span>"); ?>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>