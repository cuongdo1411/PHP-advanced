    <?php
    class Product extends Controller
    {

        public $data = [];

        public function index()
        {
            $this->data['sub_content']['title'] = 'Đây là trang sản phẩm';
            $this->data['content'] = 'products/page';
            $this->render('layouts/client_layout', $this->data);
        }

        public function list_product()
        {
            $productModel = $this->model('ProductModel');
            $dataProductByPrice = $productModel->getAllProduct();
            if (isset($_GET['sort_price'])) {
                if ($_GET['sort_price'] === 'desc') {
                    $dataProductByPrice = $productModel->getProductByPriceDESC();
                } else if ($_GET['sort_price'] === 'asc') {
                    $dataProductByPrice = $productModel->getProductByPriceASC();
                }
            }
            // Get products table
            $this->data['sub_content']['products'] = $dataProductByPrice;

            // Get products table by price DESC
            // $dataProductByPriceDESC = $productModel->getProductByPriceDESC();
            // $this->data['sub_content']['productsByPriceDESC'] = $dataProductByPriceDESC;

            // Get products table by price ASC
            // $dataProductByPriceASC = $productModel->getProductByPriceASC();
            // $this->data['sub_content']['productsByPriceASC'] = $dataProductByPriceASC;

            // Get brand tables
            $brand = $productModel->getBrandData();
            $this->data['sub_content']['brand'] = $brand;



            $this->data['sub_content']['title'] = 'Danh sách sản phẩm';
            $this->data['content'] = 'products/list';
            $this->data['page_title'] = 'Trang danh sách sản phẩm';

            // Render view
            $this->render('layouts/client_layout', $this->data);
        }
    }
