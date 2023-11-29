<form method="post" action="<?php echo WEB_ROOT; ?>/admin/product/edit_brand_action/<?php echo $brandsById['ID'];?>">
    <div class="mb-3">
        <label for="" class="form-label">ID</label>
        <input type="number" class="form-control" name="idBrand" value="<?php echo $brandsById['ID']; ?>" id="" placeholder="" disabled>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Brand</label>
        <input type="text" class="form-control" name="mainBrand" value="<?php echo $brandsById['name'];?>" id="" placeholder="">
        <?php echo form_error("mainBrand", "<span style='color:red'>", "</span>"); ?>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>