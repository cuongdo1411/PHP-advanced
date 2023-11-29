<?php
class Order extends Controller
{
    protected $_data = [], $_cart, $_orderModel;
    public function __construct()
    {
        $this->_orderModel = $this->model('OrderModel');
    }

    // Hàm xác nhận
    public function confirm()
    {
        $this->_cart = Session::data('cart');
        if (empty($this->_cart)) {
            $response = new Response;
            $response->redirect('cart/index');
        }

        $userId = Session::data('userId');
        if (!empty($userId)) {
            $customers = $this->_orderModel->getCustomers($userId);
            $this->_data['sub_content']['customers'] = $customers;
        }

        $this->_data['sub_content']['cart'] = $this->_cart;
        $this->_data['content'] = 'orders/confirm';
        $this->render('layouts/client_layout', $this->_data);
    }

    // Hàm thêm thông tin liên hệ
    public function add_contact()
    {
        $request = new Request();
        $response = new Response();

        if ($request->isPost()) {
            $request->rules([
                'fullname' => 'required',
                'phone' => 'required|phoneNumber',
                'email' => 'required|email|min:6',
            ]);
            $request->message([
                'fullname.required' => 'Vui lòng nhập tên',
                'phone.required' => 'Vui lòng nhập số điện thoại',
                'phone.phoneNumber' => 'Số điện thoại không đúng định dạng',
                'email.required' => 'Email không được để trống.',
                'email.min' => 'Email không được nhỏ hơn 6 ký tự',
                'email.email' => 'Email không đúng định dạng',
            ]);

            $validate = $request->validate();

            if (!$validate) {
                $response->redirect('order/confirm');
            } else {
                $dataContact = $request->getFields();
                Session::data('dataContact', $dataContact);
                $response->redirect('order/confirm_order');
            }
        }
    }

    // hàm kiểm tra thông tin thanh toán
    public function confirm_order()
    {
        $dataContact = Session::data('dataContact');
        $cart = Session::data('cart');

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += ($item['price'] * $item['quantity']);
        }

        $this->_data['sub_content']['totalPrice'] = $totalPrice;
        $this->_data['sub_content']['dataContact'] = $dataContact;
        $this->_data['sub_content']['cart'] = $cart;
        $this->_data['content'] = 'orders/confirm_order';
        $this->render('layouts/client_layout', $this->_data);
    }

    public function confirm_order_action()
    {
        $dataContact = Session::data('dataContact');
        $dataContact_str = '';
        foreach ($dataContact as $item) {
            $dataContact_str .= ', ' . $item;
            $dataContact_str = trim($dataContact_str, ', ');
        }
        $timeStamp = date('Y-m-d H:i:s', time());
        $dataOrder = [
            'order_id' => '',
            'order_date' => $timeStamp,
            'customer' => $dataContact_str,
        ];

        // Insert orders table
        $this->_orderModel->insertOrder($dataOrder);

        // Get order_id
        $dataOrder = $this->_orderModel->getOrder();
        $order_id = end($dataOrder)['order_id'];

        $cart = Session::data('cart');
        // Insert order items table
        foreach ($cart as $item) {
            $dataOrderItems = [
                'item_id' => '',
                'order_id' => $order_id,
                'product_id' => $item['ID'],
                'quantity' => $item['quantity'],
            ];
            $this->_orderModel->insertOrderItems($dataOrderItems);
        }

        // Chuyển hướng trang
        $response = new Response();
        $response->redirect('order/confirm_success');
    }

    public function confirm_success()
    {
        $this->_data['sub_content'][''] = '';
        $this->_data['content'] = 'orders/confirm_success';
        $this->render('layouts/client_layout', $this->_data);
    }
}
