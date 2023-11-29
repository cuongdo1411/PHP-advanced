<form method="post" action="{{WEB_ROOT}}/order/confirm_order_action">

    <h1>Xác nhận thông tin đặt hàng</h1>
    <div class="row">
        <div class="col-4">
            <h3>Thông tin liên hệ</h3>

        </div>
        <div class="col-8">
            Anh(Chị): <?php print_r($dataContact['fullname']); ?> <br>
            Số điện thoại: <?php print_r($dataContact['phone']); ?> <br>
            Địa chỉ: <?php print_r($dataContact['email']); ?> <br>
        </div>
    </div>

    <h3>Thông tin đơn hàng</h3>
    <div class="table-responsive">
        <table class="table table-warning">
            <thead>
                <caption>Kiểm tra thông tin thật kỹ trước khi xác nhận đặt hàng</caption>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Thông tin sản phẩm</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Đơn giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $key => $item)
                <tr class="">
                    <td scope="row">{{$key + 1}}</td>
                    <td>{{$item['name']}}; Thương hiệu: {{$item['brand']}}; Bảo hành: {{$item['warranty']}}</td>
                    <td>{{$item['quantity']}}</td>
                    <td>{{number_format($item['price'])}}</td>
                </tr>
                @endforeach
                <tr class="">
                    <td colspan="3" scope="row" class="text-end"><strong>Tổng tiền:</strong></td>
                    <td>
                        <strong>{{number_format($totalPrice)}} VNĐ</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <button type="submit" class="btn btn-primary">Xác nhận</button>
</form>