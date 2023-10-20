<?php

/**
 * Kế thừa từ class Model
 */
class HomeModel extends Model
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

    public function getAllProduct()
    {
        return $this->getAll();
    }

    public function getBrandData()
    {
        return  $this->db->table('brand')->get();
    }
}
