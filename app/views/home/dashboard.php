<div class="row">
    <div class="col-lg-2 col-md-2 col-sm-2">
        <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action" id="products-list" data-bs-toggle="list" href="#products" role="tab" aria-controls="products">Products</a>
            <a class="list-group-item list-group-item-action" id="brands-list" data-bs-toggle="list" href="#brands" role="tab" aria-controls="brands">Brands</a>
            <a class="list-group-item list-group-item-action" id="categories-list" data-bs-toggle="list" href="#categories" role="tab" aria-controls="categories">Categories</a>
            <a class="list-group-item list-group-item-action" id="switches-list" data-bs-toggle="list" href="#switches" role="tab" aria-controls="switches">Switches</a>
            <a class="list-group-item list-group-item-action" id="orders-list" data-bs-toggle="list" href="#orders" role="tab" aria-controls="orders">Orders</a>
            <a class="list-group-item list-group-item-action active" id="chart-list" data-bs-toggle="list" href="#chart" role="tab" aria-controls="chart">Chart</a>

        </div>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-10">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-list">
                <!-- Hiển thị dữ liệu -->
                <div class="container">
                    <h1 class="text-center">Danh sách sản phẩm</h1>
                    <a href="<?php echo WEB_ROOT ?>/admin/product/add" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm</a>
                    <?php
                    if (isset($delete_success)) {
                        echo '<div class="alert alert-danger">' . $delete_success . '</div>';
                    }
                    if (isset($add_success)) {
                        echo '<div class="alert alert-primary">' . $add_success . '</div>';
                    }
                    if (isset($edit_success)) {
                        echo '<div class="alert alert-success">' . $edit_success . '</div>';
                    }
                    ?>


                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Thương hiệu</th>
                                <th>Kết nối</th>
                                <th>Layout (Số phím)</th>
                                <th>Switch</th>
                                <th>Bảo hành</th>
                                <th>Giảm giá</th>
                                <th>Ảnh</th>
                                <th>Danh mục</th>
                                <th>Mô tả</th>
                                <th>Tồn kho</th>
                                <th>Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $key => $productArr)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$productArr['name']}}</td>
                                <td>{{number_format($productArr['price'])}} đ</td>
                                <td>
                                    @foreach ($brands as $brandArr)
                                    @if ($productArr['brand'] == $brandArr['ID'])
                                    {{$brandArr['name']}}
                                    @endif
                                    @endforeach
                                </td>
                                <td>{{$productArr['connect']}}</td>
                                <td>{{$productArr['layout']}}</td>
                                <td>
                                    @foreach ($switches as $switch)
                                    @if ($productArr['switch'] == $switch['ID'])
                                    {{$switch['name']}}
                                    @endif
                                    @endforeach
                                </td>
                                <td>{{$productArr['warranty']}}</td>
                                <td>{{$productArr['discount']}}%</td>
                                <td>{{$productArr['image']}}</td>
                                <td>
                                    @foreach ($categories as $category)
                                    @if ($productArr['product_type_id'] == $category['ID'])
                                    {{$category['name']}}
                                    @endif
                                    @endforeach
                                </td>
                                <td>{{$productArr['description']}}</td>
                                <td>{{$productArr['inventory']}}</td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal<?php echo $productArr['ID']; ?>">
                                        <i class="fas fa-trash text-danger me-3"></i>
                                    </a>
                                    <!-- Confirmation Modal -->
                                    <div class="modal fade" id="confirmDeleteModal<?php echo $productArr['ID']; ?>" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Xác nhận xóa sản phẩm</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Bạn có chắc chắn muốn xóa sản phẩm này?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <a href="<?php echo WEB_ROOT; ?>/admin/dashboard/delete_product/<?php echo $productArr['ID']; ?>" class="btn btn-danger">Xóa</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href='<?php echo WEB_ROOT; ?>/admin/product/edit/<?php echo $productArr['ID']; ?>'><i class="fas fa-pencil-alt text-primary"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="tab-pane fade" id="brands" role="tabpanel" aria-labelledby="brands-list">
                <a href="<?php echo WEB_ROOT ?>/admin/product/add_brand" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm</a>
                <?php
                if (isset($delete_brand_success)) {
                    echo '<div class="alert alert-danger">' . $delete_brand_success . '</div>';
                }
                if (isset($add_brand_success)) {
                    echo '<div class="alert alert-primary">' . $add_brand_success . '</div>';
                }
                if (isset($edit_brand_success)) {
                    echo '<div class="alert alert-success">' . $edit_brand_success . '</div>';
                }
                ?>
                <div class="table-responsive">
                    <table class="table table-striped
                    table-hover	
                    table-borderless
                    table-dark
                    align-middle">
                        <thead class="table-light">
                            <caption>Danh sách thương hiệu</caption>
                            <tr>
                                <th>STT</th>
                                <th>Name</th>
                                <th>Handle</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach($brands as $key => $brand)
                            <tr class="table-secondary">
                                <td scope="row">{{++$key}}</td>
                                <td>{{$brand['name']}}</td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteCategoryModal<?php echo $brand['ID']; ?>">
                                        <i class="fas fa-trash text-danger me-3"></i>
                                    </a>
                                    <!-- Confirmation Modal -->
                                    <div class="modal fade" id="confirmDeleteCategoryModal<?php echo $brand['ID']; ?>" tabindex="-1" aria-labelledby="confirmDeleteCategoryModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteCategoryModalLabel">Xác nhận xóa sản phẩm</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Bạn có chắc chắn muốn xóa sản phẩm này?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <a href="<?php echo WEB_ROOT; ?>/admin/dashboard/delete_brand/<?php echo $brand['ID']; ?>" class="btn btn-danger">Xóa</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href='<?php echo WEB_ROOT; ?>/admin/product/edit_brand/<?php echo $brand['ID']; ?>'><i class="fas fa-pencil-alt text-primary"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="categories-list">
                <a href="<?php echo WEB_ROOT ?>/admin/product/add_category" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm</a>
                <?php
                if (isset($delete_category_success)) {
                    echo '<div class="alert alert-danger">' . $delete_category_success . '</div>';
                }
                if (isset($add_category_success)) {
                    echo '<div class="alert alert-primary">' . $add_category_success . '</div>';
                }
                if (isset($edit_category_success)) {
                    echo '<div class="alert alert-success">' . $edit_category_success . '</div>';
                }
                ?>
                <div class="table-responsive">
                    <table class="table table-striped
                    table-hover	
                    table-borderless
                    table-dark
                    align-middle">
                        <thead class="table-light">
                            <caption>Danh sách thương hiệu</caption>
                            <tr>
                                <th>STT</th>
                                <th>Name</th>
                                <th>Handle</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach($categories as $key => $category)
                            <tr class="table-secondary">
                                <td scope="row">{{++$key}}</td>
                                <td>{{$category['name']}}</td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteCategoryModal<?php echo $category['ID']; ?>">
                                        <i class="fas fa-trash text-danger me-3"></i>
                                    </a>
                                    <!-- Confirmation Modal -->
                                    <div class="modal fade" id="confirmDeleteCategoryModal<?php echo $category['ID']; ?>" tabindex="-1" aria-labelledby="confirmDeleteCategoryModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteCategoryModalLabel">Xác nhận xóa sản phẩm</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Bạn có chắc chắn muốn xóa sản phẩm này?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <a href="<?php echo WEB_ROOT; ?>/admin/dashboard/delete_category/<?php echo $category['ID']; ?>" class="btn btn-danger">Xóa</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href='<?php echo WEB_ROOT; ?>/admin/product/edit_category/<?php echo $category['ID']; ?>'><i class="fas fa-pencil-alt text-primary"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="switches" role="tabpanel" aria-labelledby="switches-list">
                Hello
            </div>

            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-list">
                <div class="table-responsive">
                    <table class="table table-bordered
                    table-hover	
                    table-borderless
                    table-dark
                    align-middle">
                        <thead class="table-light">
                            <caption>Đơn hàng chưa xử lý</caption>
                            <tr>
                                <th>STT</th>
                                <th>Thời gian đặt hàng</th>
                                <th>Thông tin người dùng</th>
                                <th>Tên sản phẩm (Số lượng)</th>
                                <th>Tổng đơn hàng</th>
                                <th>Tình trạng</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php foreach ($orders as $key => $order) : ?>
                                <tr class="table-secondary">
                                    <td scope="row">{{$key + 1}}</td>
                                    <td>{{$order['order_date']}}</td>
                                    <td>{{$order['customer']}}</td>
                                    <td>
                                        <?php foreach ($orderItemJoinProduct as $row) : ?>
                                            <?php if ($row['order_id'] == $order['order_id']) : ?>
                                                {{$row['name']}}
                                                <strong>({{$row['quantity']}})</strong>
                                                <hr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>

                                    <td>
                                        <?php foreach ($totalValue as $totalVal) : ?>
                                            <?php if ($totalVal['order_id'] == $order['order_id']) : ?>
                                                {{number_format($totalVal['total_value'])}} VNĐ
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>

                                    <td>
                                        <div class="mb-3">
                                            <form method="post" action="<?php echo WEB_ROOT; ?>/admin/dashboard/order_status_update/<?php echo $item['order_id'] ?>">
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-primary">Handle</button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>

                                    <td><input type="text"></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade show active" id="chart" role="tabpanel" aria-labelledby="chart-list">
                <div id="chartQuantity" style="width: 100%;"></div>
                <div id="chartDate"></div>
            </div>

            <script>
                window.onload = function() {
                    var chart = new CanvasJS.Chart("chartQuantity", {
                        animationEnabled: true,
                        theme: "light2",
                        title: {
                            text: "Bảng theo dõi số lượng sản phẩm"
                        },
                        axisY: {
                            title: "Số lượng (đơn vị tính: cái)"
                        },
                        axisX: {
                            // valueFormatString: "DD MMM",
                            labelWrap: true,
                            labelMaxWidth: 80,
                        },
                        data: [
                            {
                                type: "column",
                                showInLegend: true,
                                dataPoints: <?php echo json_encode($quantityChart, JSON_NUMERIC_CHECK); ?>,
                            },
                            // {
                            //     type: "line",
                            //     showInLegend: true,
                            //     xValueType: "dateTime",
                            //     xValueFormatString: "DD MMM",
                            //     yValueFormatString: "#,##0 cái",
                            //     dataPoints: <?php echo json_encode($dateChart, JSON_NUMERIC_CHECK); ?>,
                            // }
                        ]

                    });
                    chart.render();
                }
            </script>
        </div>
    </div>

</div>
</div>
</div>