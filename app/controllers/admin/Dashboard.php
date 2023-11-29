<?php

class DashBoard extends Controller
{
    protected $_data = [],
        $_productModel, $_orderModel, $_chartModel,
        $_brands, $_categories, $_switch, $_products, $_orders;

    public function __construct()
    {
        $this->_productModel = $this->model('ProductModel');
        $this->_orderModel = $this->model('OrderModel');
        $this->_chartModel = $this->model('ChartModel');

        $this->_products = $this->_productModel->getAllProduct();
        $this->_brands = $this->_productModel->getBrand();
        $this->_categories = $this->_productModel->getCategories();
        $this->_switch = $this->_productModel->getSwitch();
        $this->_orders = $this->_orderModel->getOrder();
    }

    public function index()
    {
        // Handle Date (to string)
        foreach ($this->_orders as $index => $item) {
            if (!array_key_exists('order_date', $this->_orders)) {
                $this->_orders[$index]['order_date'] = $this->handleDate($item['order_date']);
            }
        }

        // Notifications
        $this->_data['sub_content']['delete_success'] = Session::flash('delete_success');
        $this->_data['sub_content']['edit_success'] = Session::flash('edit_success');
        $this->_data['sub_content']['add_success'] = Session::flash('add_success');
        $this->_data['sub_content']['delete_brand_success'] = Session::flash('delete_brand_success');
        $this->_data['sub_content']['edit_brand_success'] = Session::flash('edit_brand_success');
        $this->_data['sub_content']['add_brand_success'] = Session::flash('add_brand_success');
        $this->_data['sub_content']['delete_category_success'] = Session::flash('delete_category_success');
        $this->_data['sub_content']['add_category_success'] = Session::flash('add_category_success');
        $this->_data['sub_content']['edit_category_success'] = Session::flash('edit_category_success');

        // Array
        $this->_data['sub_content']['brands'] = $this->_brands;
        $this->_data['sub_content']['categories'] = $this->_categories;
        $this->_data['sub_content']['switches'] = $this->_switch;
        $this->_data['sub_content']['products'] = $this->_products;
        $this->_data['sub_content']['orders'] = $this->_orders;

        // Order item table JOIN Product table
        $orderItemJoinProduct = $this->_orderModel->joinProducts();
        $this->_data['sub_content']['orderItemJoinProduct'] = $orderItemJoinProduct;

        // Get Total Value Order
        $getTotalValue = $this->_orderModel->getTotalOrder();
        $this->_data['sub_content']['totalValue'] = $getTotalValue;

        // Handle Chart
        $quantityChart = $this->_chartModel->filterByProductId();
        $dateChart = $this->_chartModel->filterByDate();

        $newQuantityChart = $this->convertArrayCanVasType($quantityChart, ['total_quantity', 'name']);
        $newDateChart = $this->convertArrayCanVasType1($dateChart, ['order_date', 'quantity']);

        $this->_data['sub_content']['quantityChart'] = $newQuantityChart;
        $this->_data['sub_content']['dateChart'] = $newDateChart;

        $this->_data['sub_content']['title'] = 'Dashboard';
        $this->_data['content'] = 'home/dashboard';
        $this->render('layouts/admin_layout', $this->_data);
    }

    public function delete_product($id)
    {
        foreach ($this->_products as $product) {
            if ($product['ID'] == $id) {
                $this->_productModel->delProduct($id);
            }
        }
        Session::flash('delete_success', 'Xóa sản phẩm thành công');
        $response = new Response();
        $response->redirect('admin/dashboard/index');
    }

    public function delete_brand($id)
    {
        foreach ($this->_brands as $brand) {
            if ($brand['ID'] == $id) {
                $this->_productModel->delBrand($id);
            }
        }
        Session::flash('delete_brand_success', 'Xóa sản phẩm thành công');
        $response = new Response();
        $response->redirect('admin/dashboard/index');
    }

    public function delete_category($id)
    {
        foreach ($this->_categories as $category) {
            if ($category['ID'] == $id) {
                $this->_productModel->delCategory($id);
            }
        }
        Session::flash('delete_category_success', 'Xóa sản phẩm thành công');
        $response = new Response();
        $response->redirect('admin/dashboard/index');
    }

    // handle Order date
    public function handleDate($date)
    {
        $timestamp = strtotime($date);
        $formattedData = date('\N\g\à\y d \t\h\á\n\g m \n\ă\m Y \l\ú\c H \g\i\ờ i \p\hú\t s \g\i\â\y', $timestamp);
        return $formattedData;
    }

    // public function chart()
    // {
    //     // $a = Session::flash('chartData');
    //     // print_r($a);
    //     header('Content-Type: application/json');
    //     $data = $this->_chartModel->filterByProductId();
    //     echo json_encode($data);
    // }

    // public function chart1()
    // {
    //     header('Content-Type: application/json');
    //     $data = $this->_chartModel->filterByDate();
    //     echo json_encode($data);
    // }


    // Handle Chart (convert CanvasJS Array Type) // ['y','label','x']
    public function convertArrayCanVasType($array, $properties)
    {
        $newArr = [];
        foreach ($array as $arr) {
            if (!empty($properties[2])) {
                $timeStamp = strtotime($arr[$properties[2]]);
                $newArr[] = [
                    'label' => $arr[$properties[1]], // name
                    'x' => $timeStamp * 1000, // 01/01/2000
                    'y' => $arr[$properties[0]], // quantity
                ];
            } else {
                $newArr[] = [
                    'y' => $arr[$properties[0]],
                    'label' => $arr[$properties[1]],
                ];
            }
        }
        return $newArr;
    }

    public function convertArrayCanVasType1($array, $properties)
    {
        $newArr = [];
        foreach ($array as $arr) {
            $timeStamp = strtotime($arr[$properties[0]]);

            $newArr[] = [
                'x' => $timeStamp * 1000,
                'y' => $arr[$properties[1]],
            ];
        }
        return $newArr;
    }
}
