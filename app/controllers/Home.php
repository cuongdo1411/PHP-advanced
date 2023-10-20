<?php
class Home extends Controller
{

    protected $homeModel, $data = [];

    public function __construct()
    {
        $this->homeModel = $this->model('HomeModel');
    }

    public function index()
    {

        $productData = $this->homeModel->getAllProduct();
        $this->data['sub_content']['products'] = $productData;

        $brand = $this->homeModel->getBrandData();
        $this->data['sub_content']['brand'] = $brand;

        $this->data['sub_content']['title'] = 'Trang Home';
        $this->data['content'] = 'home/page';

        $this->render('layouts/client_layout', $this->data);       
    }
}
