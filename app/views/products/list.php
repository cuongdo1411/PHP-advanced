<?php
$paginatedData = paginate($products, 4);
$startIndex = $paginatedData['startIndex'];
$lastIndex = $paginatedData['lastIndex'];
$totalPages = $paginatedData['totalPages'];
$currentPage = $paginatedData['currentPage'];
?>
<?php 
echo '<pre>';
print_r($products);
echo '</pre>'; 
;?>
<h1 class="text-center">DANH SÁCH SẢN PHẨM</h1>

<form method="post" action="<?php echo WEB_ROOT; ?>/product/post_list_product" class="row align-items-center my-3">
    <div class="col-lg-4 col-md-4 col-sm-4">
        <select class="form-select text-center" name="sort_price">
            <option value="desc" <?php if (isset($value_sort) && $value_sort == "desc") echo "selected"; ?>>Giá giảm dần</option>
            <option value="asc" <?php if (isset($value_sort) && $value_sort == "asc") echo "selected"; ?>>Giá tăng dần</option>
        </select>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4">
        <button class="btn btn-success w-25" type="submit">Sort</button>
    </div>
</form>


<div class="row">
    <?php foreach ($products as $key => $itemProduct) : ?>
        <?php if ($key >= $lastIndex) : ?>
            <?php break; ?>
        <?php elseif ($key >= $startIndex) : ?>
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
                        <a href="<?php echo WEB_ROOT; ?>/product/detail_product/<?php echo $itemProduct['ID']; ?>" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<?php navPaginate($totalPages, $currentPage); ?>