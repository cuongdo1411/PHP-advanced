<form method="post" action="<?php echo WEB_ROOT; ?>/order/confirm">
  <table class="table">
    <thead>
      <tr>
        <th scope="col">STT</th>
        <th scope="col">Name</th>
        <th scope="col">Brand</th>
        <th scope="col">Quantity</th>
        <th scope="col">Price</th>
        <th scope="col">Warranty</th>
        <th scope="col">Handle</th>
      </tr>
    </thead>
    <tbody>
      @if(!empty($cart))
      @foreach($cart as $key=>$item)
      <tr>
        <th scope="row">{{$key + 1}}</th>
        <td>{{$item['name']}}</td>
        <td>{{$item['brand']}}</td>
        <td>{{$item['quantity']}}</td>
        <td>{{number_format($item['price'] * $item['quantity'])}} VNĐ</td>
        <td>{{$item['warranty']}}</td>
        <td><a class="btn btn-danger" href="<?php echo WEB_ROOT; ?>/cart/delete_cart/<?php echo $key + 1; ?>">Delete</a></td>
      </tr>
      @endforeach
      @endif
      <tr>
        <th scope="row"></th>
        <td></td>
        <td></td>
        <td>
          <h4>Tổng số tiền: </h4>
        </td>
        <td>{{number_format($totalPrice)}} VNĐ</td>
        <td colspan="2">
          <button type="submit" class="btn btn-primary">Thanh Toán</button>
        </td>
      </tr>
    </tbody>
  </table>
</form>