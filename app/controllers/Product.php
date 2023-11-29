    <?php
    class Product extends Controller
    {

        protected $_productModel, $_data = [];

        public function __construct()
        {
            $this->_productModel = $this->model('ProductModel');
        }

        public function index()
        {
            $this->_data['page_title'] = 'Đây là trang sản phẩm';
            $this->_data['content'] = 'products/page';
            $this->render('layouts/client_layout', $this->_data);
        }

        public function list_product()
        {
            // Connect Product Model
            $this->_productModel = $this->model('ProductModel');

            // Get DB Product Default
            $products = $this->_productModel->getAllProduct();

            // Handle image
            foreach ($products as $key => $product) {
                $products[$key]['image'] = explode(', ', $product['image']);
            }

            // Seach
            if (!empty($this->search())) {
                $products = $this->search();
            }

            // Handle Sort Values
            $value_sort = Session::flash('valueSort');
            if (!empty($value_sort)) {
                if ($value_sort['sort_price'] === 'desc') {
                    $products = $this->_productModel->getProductByPriceDESC();
                } else {
                    $products = $this->_productModel->getProductByPriceASC();
                }
                $this->_data['sub_content']['value_sort'] = $value_sort['sort_price'];
            }

            // Get products table
            $this->_data['sub_content']['products'] = $products;

            // Get brand tables
            $brand = $this->_productModel->getBrand();
            $this->_data['sub_content']['brand'] = $brand;


            // Content Product
            $this->_data['sub_content']['title'] = 'Danh sách sản phẩm';
            $this->_data['content'] = 'products/list';

            // Render view
            $this->render('layouts/client_layout', $this->_data);
        }

        public function post_list_product()
        {
            // Request Handle
            $request = new Request();
            if ($request->isPost()) {
                $valueSort = $request->getFields();
                // Setting Value Sort
                Session::flash('valueSort', $valueSort);
            }

            // Redirect Handle
            $response = new Response();
            $response->redirect('product/list_product');
        }

        public function detail_product($id)
        {
            $this->_data['page_title'] = 'Chi tiết sản phẩm';
            $this->_data['content'] = 'products/detail';

            $productDetail = $this->_productModel->getProductById($id);
            // Handle Image
            $imgArr = explode(', ', $productDetail[0]['image']);
            $productDetail[0]['image'] = $imgArr;
            $this->_data['sub_content']['productDetail'] = $productDetail[0];

            // Get brand tables
            $brand = $this->_productModel->getBrandById($productDetail[0]['brand']);
            $this->_data['sub_content']['brand'] = $brand[0];

            // Get switch tables
            $switch = $this->_productModel->getSwitchById($productDetail[0]['switch']);
            $this->_data['sub_content']['switch'] = $switch[0];

            $this->render('layouts/client_layout', $this->_data);
        }

        public function search()
        {
            $request = new Request();
            if ($request->isPost()) {
                $search_value = $request->getFields();
                $result = $this->_productModel->search($search_value['search_value']);
                return $result;
            }
        }
    }
