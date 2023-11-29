<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="row">
            <div class="col-12 text-center">
                <img id="main-img" src="<?php echo WEB_ROOT; ?>/public/assets/clients/images/{{$productDetail['image'][0]}}" class="img-fluid main-img" />
            </div>
            @foreach ($productDetail['image'] as $image)
            <div class="col-lg-3 col-md-3 col-sm-3 mt-3">
                <img src="<?php echo WEB_ROOT; ?>/public/assets/clients/images/{{$image}}" class="img-fluid thumbnail-img" />
            </div>
            @endforeach
        </div>
    </div>

    
    <div class="col-lg-8 col-md-8 col-sm-8">
        <h3>{{$productDetail['name']}}</h3>
        <h5>{{number_format($productDetail['price'])}} VNĐ</h5>
        <h5>{{$brand['name']}}</h5>
        <h5>{{$productDetail['connect']}}</h5>
        <h5>{{$productDetail['layout']}}</h5>
        <h5>{{$switch['name']}}</h5>
        <h5>{{$productDetail['warranty']}}</h5>
        <h5> - {{$productDetail['discount']}} %</h5>
        <h5> Còn lại: {{$productDetail['inventory']}} sản phẩm</h5>
        <a class="btn btn-primary" href="<?php echo WEB_ROOT; ?>/cart/add_cart/<?php echo $productDetail['ID']; ?>">Thêm vào giỏ hàng</a>
    </div>
</div>