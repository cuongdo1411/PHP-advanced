<h1 class="text-center">DANH SÁCH SẢN PHẨM</h1>


<form method="GET" action="<?php echo WEB_ROOT;?>/app/controllers/Product.php">
    <select class="form-select text-center" name="sort_price">
        <option value="desc" <?php if(isset($_GET['sort_price']) && $_GET['sort_price'] == "desc") echo "selected";?>>Giá giảm dần</option>
        <option value="asc" <?php if(isset($_GET['sort_price']) && $_GET['sort_price'] == "asc") echo "selected";?>>Giá tăng dần</option>
    </select>
    <button type="submit">Sort</button>
</form>


<div class="row">
    @foreach($products as $itemProduct)
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card">
            <img class="card-img-top" src="<?php echo WEB_ROOT; ?>/public/assets/clients/images/testProduct.jpg" alt="Card image">
            <div class="card-body text-center">
                <h4 class="card-title">{{$itemProduct['name']}}</h4>
                <h5 class="card-title">{{number_format($itemProduct['price'],0)}}
                    <span style="text-decoration: line-through">
                        @if (!empty($itemProduct['discount']))
                        {{ number_format($itemProduct['price'] * ( 1 - ($itemProduct['discount']/100))) }}
                        @endif
                    </span>
                </h5>
                @foreach($brand as $itemBrand)
                @if($itemProduct['brand'] == $itemBrand['ID'])
                <p class="card-text">{{$itemBrand['name']}}</p>
                @endif
                @endforeach
                <!-- <a href="#" class="btn btn-primary">Xem chi tiết</a> -->
            </div>
        </div>
    </div>
    @endforeach
</div>