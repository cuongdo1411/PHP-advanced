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

    // Product handle  
    public function getProductById($id)
    {
        return $this->db->table('products')->where('ID', '=', $id)->get();
    }

    public function search($value)
    {
        return $this->db->table('products')->likeWhere('name', $value)->get();
    }

    public function getProductByPriceDESC()
    {
        return $this->db->table('products')->orderBy('price', 'DESC')->get();
    }

    public function getProductByPriceASC()
    {
        return $this->db->table('products')->orderBy('price')->get();
    }

    public function insertProduct($data)
    {
        return $this->db->table('products')->insert($data);
    }

    public function delProduct($id)
    {
        return $this->db->table('products')->where('ID', '=', $id)->delete();
    }

    public function editProduct($id, $data)
    {
        return $this->db->table('products')->where('ID', '=', $id)->update($data);
    }



    // Brand handle
    public function getBrand()
    {
        return $this->db->table('brand')->get();
    }

    public function getBrandById($id)
    {
        return $this->db->table('brand')->where('ID', '=', $id)->get();
    }

    public function insertBrand($data)
    {
        return $this->db->table('brand')->insert($data);
    }

    public function editBrand($id, $data)
    {
        return $this->db->table('brand')->where('ID', '=', $id)->update($data);
    }

    public function delBrand($id)
    {
        return $this->db->table('brand')->where('ID', '=', $id)->delete();
    }



    // Switch handle
    public function getSwitch()
    {
        return $this->db->table('switch')->get();
    }

    public function getSwitchCategories()
    {
        return $this->db->table('switch_categories')->get();
    }

    public function getSwitchById($id)
    {
        return $this->db->table('switch')->where('ID', '=', $id)->get();
    }

    // Categories handle
    public function getCategories()
    {
        return $this->db->table('categories')->get();
    }

    public function getCategoryById($id)
    {
        return $this->db->table('categories')->where('ID', '=', $id)->get();
    }

    public function delCategory($id)
    {
        return $this->db->table('categories')->where('ID', '=', $id)->delete();
    }

    public function insertCategory($data)
    {
        return $this->db->table('categories')->insert($data);
    }

    public function editCategory($id, $data)
    {
        return $this->db->table('categories')->where('ID', '=', $id)->update($data);
    }

}
