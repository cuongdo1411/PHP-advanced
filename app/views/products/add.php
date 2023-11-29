<form method="post" action="<?php echo WEB_ROOT; ?>/admin/product/add_products" enctype="multipart/form-data">
    <div class="my-3">
        <label for="">Tên sản phẩm:</label>
        <input class="form-control" type="text" name="name" value="" />
        <?php echo form_error("name", "<span style='color:red'>", "</span>"); ?>
    </div>
    <div class="mb-3">
        <label for="">Giá:</label>
        <input class="form-control" type="text" name="price" value="" />
        <?php echo form_error("price", "<span style='color:red'>", "</span>"); ?>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Thương hiệu:</label>
        <select class="form-select form-select-sm" name="brand" id="">
            <option value="">Vui lòng chọn 1 trong {{count($brands)}}</option>
            @foreach($brands as $brand)
            <option value="{{$brand['name']}}">{{$brand['name']}}</option>
            @endforeach
        </select>
        <?php echo form_error("brand", "<span style='color:red'>", "</span>"); ?>
    </div>
    <div class="mb-3">
        <label for="">Kết nối:</label>
        <input class="form-control" type="text" name="connect" value="" />
        <?php echo form_error("connect", "<span style='color:red'>", "</span>"); ?>

    </div>
    <div class="mb-3">
        <label for="">Layout:</label>
        <input class="form-control" type="text" name="layout" value="" />
        <?php echo form_error("layout", "<span style='color:red'>", "</span>"); ?>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Switch:</label>
        <select class="form-select form-select-sm" name="switch" id="">
            <option value="">Vui lòng chọn 1 trong {{count($switch_categories)}}</option>
            @foreach($switch_categories as $switch_category)
            <option value="{{$switch_category['category']}}">{{$switch_category['category']}}</option>
            @endforeach
        </select>
        <?php echo form_error("switch", "<span style='color:red'>", "</span>"); ?>
    </div>
    <div class="mb-3">
        <label for="">Bảo hành:</label>
        <input class="form-control" type="text" name="warranty" value="" />
        <?php echo form_error("warranty", "<span style='color:red'>", "</span>"); ?>
    </div>
    <div class="mb-3">
        <label for="">Giảm giá:</label>
        <input class="form-control" type="text" name="discount" value="" />
        <?php echo form_error("discount", "<span style='color:red'>", "</span>"); ?>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Hình ảnh</label>
        <input type="file" class="form-control" name="image[]" id="" placeholder="" aria-describedby="fileHelpId" multiple>
        <?php echo form_error("image", "<span style='color:red'>", "</span>"); ?>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Danh mục:</label>
        <select class="form-select form-select-sm" name="category" id="">
            <option value="">Vui lòng chọn 1 trong {{count($categories)}}</option>
            @foreach($categories as $category)
            <option value="{{$category['name']}}">{{$category['name']}}</option>
            @endforeach
        </select>
        <?php echo form_error("category", "<span style='color:red'>", "</span>"); ?>
        <div class="mb-3">
            <label for="">Mô tả:</label>
            <input class="form-control" type="text" name="description" value="" />
            <?php echo form_error("description", "<span style='color:red'>", "</span>"); ?>
        </div>
        <div class="mb-3">
            <label for="">Tồn kho:</label>
            <input class="form-control" type="text" name="inventory" value="" />
            <?php echo form_error("inventory", "<span style='color:red'>", "</span>"); ?>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
</form>