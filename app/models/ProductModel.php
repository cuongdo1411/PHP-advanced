<?php
class ProductModel extends Model
{
    function tableFill()
    {
        return 'products';
    }

    function fieldFill()
    {
        return '*';
    }

    function primaryFill()
    {
        return '';
    }

    function getAllProduct()
    {
        return $this->getAll();
    }

    public function getBrandData()
    {
        return $this->db->table('brand')->get();
    }

    public function getProductByPriceDESC()
    {
        return $this->db->table('products')->orderBy('price', 'DESC')->get();
    }

    public function getProductByPriceASC()
    {
        return $this->db->table('products')->orderBy('price')->get();
    }
}
