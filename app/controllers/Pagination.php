<?php
class Pagination extends Controller
{
    protected $_data = [];
    public function index($currentPage){
        Session::data('currentPage', $currentPage);

        $response = new Response();
        $response->redirect('product/list_product');
    }
}
