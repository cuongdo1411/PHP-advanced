<?php

class ChartModel extends Model
{
    function tableFill()
    {
        return 'chart';
    }

    function fieldFill()
    {
        return '*';
    }

    function primaryFill()
    {
        return '';
    }

    public function filterByProductId($startDate = null, $endDate = null)
    {
        $query = $this->db
            ->select('products.name, SUM(orders_item.quantity) as total_quantity, orders.order_date')
            ->table('orders_item')
            ->join('products', 'products.ID = orders_item.product_id')
            ->join('orders', 'orders.order_id = orders_item.order_id')
            ->groupBy('orders_item.product_id');
        if ($startDate !== null){
            $query->where('orders.order_date', '>=', $startDate);
        }
        if ($endDate !== null){
            $query->where('orders.order_id', '<=', $endDate);
        }

        return $query->get();
    
    }

    public function filterByDate()
    {
        return $this->db
            ->table('orders')
            ->select('*')
            ->join('orders_item', 'orders_item.order_id = orders.order_id')
            ->join('products', 'products.ID = orders_item.product_id')
            ->groupBy('orders.order_date')
            ->get();
    }
}
