<?php
class Cart extends Controller
{

    protected $_data = [], $_cartModel, $_cart = [];

    public function __construct()
    {
        $this->_cartModel = $this->model("CartModel");
    }

    public function index()
    {
        // Get Session.
        $this->_cart = Session::data('cart');

        // Total price.
        $totalPrice = 0;
        if (!empty($this->_cart)) {
            foreach ($this->_cart as $itemCart) {
                $totalPrice += $itemCart['price'] * $itemCart['quantity'];
            }
        }
        $this->_data['sub_content']['totalPrice'] = $totalPrice;
        $this->_data['sub_content']['cart'] = $this->_cart;
        $this->_data["content"] = "carts/cart";

        $this->render("layouts/client_layout", $this->_data);
    }

    public function add_cart($id)
    {
        if (!empty($id)) {
            // Get product by ID
            $productById = $this->_cartModel->getProductById($id);
            $this->_data['sub_contents']['productById'] = $productById;

            // Set product
            $productName =  $productById[0]['name'];
            $productPrice = $productById[0]['price'];
            $productWarranty = $productById[0]['warranty'];
            $productID = $productById[0]['ID'];

            // Get brand by ID
            $brandById = $this->_cartModel->getBrandById($productById[0]['brand']);
            $this->_data['sub_contents']['brandById'] = $brandById;

            // Set brand
            $brandName = $brandById[0]['name'];

            // Add Cart
            $newCart = $this->addHandle($productID, $productName, $productPrice, $brandName, $productWarranty);

            // Session handle
            if (!empty(Session::data('cart'))) {
                $oldCart = Session::data('cart');

                // Biến tạm
                $productExists = false;

                foreach ($oldCart as $key => $item) {
                    if ($item['ID'] == $productID) {
                        $oldCart[$key]['quantity']++;
                        Session::data('cart', $oldCart);
                        $productExists = true;
                        break;
                    }
                }

                if (!$productExists) { // Nếu sản phẩm không tồn tại trong giỏ hàng.
                    $newCart = array_merge($oldCart, $newCart);
                    Session::data('cart', $newCart);
                }
            } else {
                Session::data('cart', $newCart);
            }
        }


        // Redirect back to Detail Product.
        $response = new Response;
        $response->redirect("product/detail_product/$id");
    }

    public function delete_cart($key)
    {
        $key = $key - 1;
        $oldCart = Session::data('cart');


        foreach ($oldCart as $index => $cartItem) {

            // Remove Handle.
            if ($index == $key) { // Check ID
                if ($cartItem['quantity'] > 1) { // Quantity > 1
                    --$oldCart[$index]['quantity'];
                    Session::data('cart', $oldCart);
                } else { // Quantity = 1
                    if (count($oldCart) == 1) {
                        Session::delete('cart');
                    } else {
                        unset($oldCart[$index]);
                        Session::data('cart', $oldCart);
                    }
                }
            }
        }

        // Redirect back to Detail Product.
        $response = new Response;
        $response->redirect("cart/index");
    }


    public function addHandle($id, $name, $price, $brand, $warranty, $quantity = 1)
    {
        $this->_cart[count($this->_cart)] = [
            'ID' => $id,
            'name' => $name,
            'price' => $price,
            'brand' => $brand,
            'warranty' => $warranty,
            'quantity' => $quantity,
        ];
        return $this->_cart;
    }
}
