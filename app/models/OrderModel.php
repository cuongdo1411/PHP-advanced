<?php

class OrderModel extends Model
{
    function tableFill()
    {
        return 'order';
    }

    function fieldFill()
    {
        return '*';
    }

    function primaryFill()
    {
        return '';
    }

    public function orderData($id, $customer_info, $order_date, $total_amount, $order_status, $product_id, $product_quantity)
    {
        return [
            'order_id' => $id,
            'customer_info' => $customer_info,
            'order_date' => $order_date,
            'total_amount' => $total_amount,
            'order_status' => $order_status,
            'product_id' => $product_id,
            'product_quantity' => $product_quantity
        ];
    }

    public function getCustomers($id)
    {
        return $this->db->table('users')->where('ID', '=', $id)->get();
    }

    public function getOrder()
    {
        return $this->db->table('orders')->get();
    }

    public function getOrderItems()
    {
        return $this->db->table('orders_item')->get();
    }

    public function getStatus($value)
    {
        return $this->db->table('0rder')->where('order_status', '=', $value)->get();
    }

    public function joinProducts()
    {
        return $this->db
            ->select('products.name, products.price, orders_item.order_id, orders_item.quantity')
            ->table('orders_item')
            ->join('products', 'orders_item.product_id = products.ID')
            ->get();
    }

    public function getTotalOrder()
    {
        return $this->db
            ->select('orders_item.order_id, SUM(products.price*orders_item.quantity) as total_value')
            ->table('orders_item')
            ->join('products', 'orders_item.product_id = products.ID')
            ->groupBy('orders_item.order_id')
            ->get();
    }

    public function insertOrder($data) // ['order_id', 'order_data', 'customer']
    {
        return $this->db->table('orders')->insert($data);
    }

    public function insertOrderItems($data) // ['item_id', 'order_id', 'product_id', 'quantity']
    {
        return $this->db->table('orders_item')->insert($data);
    }

    public function updateStatusOrder($id, $data)
    {
        return $this->db->table('0rder')->where('order_id', '=', $id)->update($data);
    }
}
