<?php
  // if($login_success){
  //   echo "<script>alert('Dang nhap thanh cong')</script>";
  // }
?>

<!-- Carousel -->
<div id="demo" class="carousel slide" data-bs-ride="carousel">

  <!-- Indicators/dots -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
  </div>

  <!-- The slideshow/carousel -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="<?php echo WEB_ROOT; ?>/public/assets/clients/images/la.jpg" alt="Los Angeles" class="d-block" style="width:100%">
      <div class="carousel-caption">
        <h3>Los Angeles</h3>
        <p>We had such a great time in LA!</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="<?php echo WEB_ROOT; ?>/public/assets/clients/images/chicago.jpg" alt="Chicago" class="d-block" style="width:100%">
      <div class="carousel-caption">
        <h3>Chicago</h3>
        <p>Thank you, Chicago!</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="<?php echo WEB_ROOT; ?>/public/assets/clients/images/ny.jpg" alt="New York" class="d-block" style="width:100%">
      <div class="carousel-caption">
        <h3>New York</h3>
        <p>We love the Big Apple!</p>
      </div>
    </div>
  </div>

  <!-- Left and right controls/icons -->
  <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- End Carousel -->

<!-- Phần Danh Mục Sản Phẩm
Bàn phím cơ, Chuột Gaming, Lót chuột, Switch, Keycap, Phụ kiện, Sửa chữa mod phím, Sale -->
<hr>
<?php
$dataProduct['categories'] = [
  'Bàn phím cơ',
  'Chuột Gaming',
  'Lót chuột',
  'Switch',
  'Keycap',
  'Phụ kiện',
  'Sửa chữa mod phím',
  'Sale'
];
$dataProduct['nameProduct'] = [
  'Sản phẩm 1',
  'Sản phẩm 2',
  'Sản phẩm 3',
  'Sản phẩm 4',
];
?>

<div class="row justify-content-center">
  @foreach($dataProduct['categories'] as $item)
  <div class="col-lg-2 col-md-4 col-sm-6 py-3 bg-secondary text-light text-center border border-2">
    {{$item}}
  </div>
  @endforeach
</div>

<!-- Phần Giảm Giá -->
<h1 class="text-center my-4">Giảm giá</h1>
<div class="row">
  
  @foreach($products as $itemProduct)
  <div class="col-lg-3 col-md-4 col-sm-6">
    <div class="card">
      <img class="card-img-top" src="<?php echo WEB_ROOT; ?>/public/assets/clients/images/{{$itemProduct['image'][0]}}" alt="Card image">
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
        <a href="<?php echo WEB_ROOT;?>/product/detail_product/<?php echo $itemProduct['ID'];?>" class="btn btn-primary">Xem chi tiết</a>
      </div>
    </div>
  </div>
  @endforeach
</div>

<!-- Phần Sản phẩm mới -->
<h1 class="text-center my-4">Sản phẩm mới</h1>
<div class="row">
  @foreach($dataProduct['nameProduct'] as $key => $productName)
  <div class="col-lg-3 col-md-4 col-sm-6">
    <div class="card">
      <img class="card-img-top" src="<?php echo WEB_ROOT; ?>/public/assets/clients/images/testProduct.jpg" alt="Card image">
      <div class="card-body text-center">
        <h4 class="card-title">{{$productName}}</h4>
        <p class="card-text">{{$dataProduct['categories'][$key]}}</p>
        <!-- <a href="#" class="btn btn-primary">Xem chi tiết</a> -->
      </div>
    </div>
  </div>
  @endforeach
</div>

<!-- Tin tức -->