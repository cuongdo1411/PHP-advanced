<?php

class CartModel extends Model
{
    function tableFill()
    {
        return 'cart';
    }

    function fieldFill()
    {
        return '*';
    }

    function primaryFill()
    {
        return '';
    }

    public function getProductById($id)
    {
        return $this->db->table('products')->where('ID', '=', $id)->get();
    }

    public function getBrandById($id)
    {
        return $this->db->table('brand')->where('ID', '=', $id)->get();
    }

    public function descInventory($id, $inventory){
        return $this->db->table('products')->where('ID', '=', $id)->update(['inventory', $inventory - 1]);
    }
}
