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