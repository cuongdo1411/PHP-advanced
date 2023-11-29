<?php
class App
{
    // ------------------------------------------TÓM TẮT NỘI DUNG----------------------------------------------------------------
    // Nguyên tắc tự đặt ra cho đường dẫn là: http://localhost/PHP/mvc_trainning/"tên controller"/"tên phương thức"/"tên tham số có liên quan đến phương thức".
    // Ví dụ: http://localhost/PHP/mvc_trainning/home/index. Nó sẽ thực hiện những gì có trong phương thức index.
    // Ví dụ: http://localhost/PHP/mvc_trainning/product/list_product. Nó sẽ thực hiện những gì có trong phương thức list_product.

    private $__controller, $__action, $__params, $__routes, $__db;

    static public $app;

    // -----------------------------------------HÀM KHỞI TẠO-----------------------------------------
    function __construct()
    {
        global $routes; // khai báo biến toàn cục có tên là $routes.

        self::$app = $this;

        $this->__routes = new Route(); // khởi tạo đối tượng với biến vừa khai báo.

        if (!empty($routes['default_controller'])) { // Kiểm tra biến default_controller có tồn tại hay không?
            $this->__controller = $routes['default_controller']; // Nếu có thì sẽ gán giá trị cho biến controller
        }
        $this->__action = 'index'; // Gán giá trị 'index' vào biến action.
        $this->__params = []; // Gán gia trị [] vào biến params.

        if (class_exists('DB')) {
            $dbOject = new DB();
            $this->__db = $dbOject->db;
        }

        $this->handleUrl(); // Gọi hàm handleUrl();
    }


    // -----------------------------------------HÀM LẤY URL-----------------------------------------
    function getUrl()
    {
        if (!empty($_SERVER['PATH_INFO'])) { // Ví dụ: http://localhost/PHP/mvc_trainning/home/index. 
            $url = $_SERVER['PATH_INFO']; // thì $_SERVER['PATH_INFO] sẽ là home/index
        } else {
            $url = '/';
        }
        return $url;
    }

    // -----------------------------------------HÀM XỬ LÍ URL-----------------------------------------
    public function handleUrl()
    {
        $url = $this->getUrl(); // lúc này $url = home/index
        $url = $this->__routes->handleRoute($url); // truyền giá trị tham số là $url vào hàm handleRoute thông qua đối tượng được khởi tạo trường đó ($__routes)

        // Middleware App
        $this->handleGlobalMiddleware($this->__db);
        $this->handleRouteMiddleware($this->__routes->getUri(), $this->__db);

        // Service Provider
        $this->handleAppServiceProvider($this->__db);

        $urlArr = array_filter(explode('/', $url)); // sử dụng hàm explode để tách $url thành [ [0] => home [1] => index] kết hợp với hàm array_filter để loại bỏ khoảng trống.
        $urlArr = array_values($urlArr); // đối với mảng có $key=> $value, hàm array_values() sẽ bỏ qua các $key mà chỉ lấy các $value và mảng này được sắp xếp lại theo thứ tự tăng dần và được đánh số thứ tự tại các $key.

        // Giả sử nếu trong đường dẫn xuất hiện một folder chứ không phải là một trong 3 tên được quy định sẵn
        // Ví dụ: admin/dashboard/index thì admin chính là tên 1 folder.
        $urlCheck = '';

        if (!empty($urlArr)) {
            foreach ($urlArr as $key => $item) {
                $urlCheck .= $item . '/';
                $fileCheck = rtrim($urlCheck, '/');
                $fileArr = explode('/', $fileCheck);
                $fileArr[count($fileArr) - 1] = ucfirst($fileArr[count($fileArr) - 1]);
                $fileCheck = implode('/', $fileArr);
                if (!empty($urlArr[$key - 1])) {
                    unset($urlArr[$key - 1]);
                }
                if (file_exists('app/controllers/' . ($fileCheck) . '.php')) {
                    $urlCheck = $fileCheck;
                    break;
                }
            }
            $urlArr = array_values($urlArr);
        }

        // Sau khi tách $url chúng ta sẽ xử lý từng cái một.
        // Ví dụ $url = home/index/1/2/...
        // Chúng sẽ được tách thành $urlArr = [ [0] => home, [1] => index, [2] => 1, [3] => 2, ... ]

        // Xử lý controller ( tức là sẽ xử lý $urlArr[0] )
        if (!empty($urlArr[0])) { // Nếu như có tồn tại tên controller
            $this->__controller = ucfirst($urlArr[0]); // thì sẽ gán tên đó vào biến __controller và sử dụng hàm ucfirst() để in hoa ký tự đầu tiên.
        } else { // ngược lại
            $this->__controller = ucfirst($this->__controller); // thì sẽ gán lại về giá trị mặc định.
        }

        // Kiểm tra sự tồn tại $urlCheck
        if (empty($urlCheck)) { // Sử dụng empty dể kiểm tra xem giá trị truyền vào có rỗng hay không? Kết trả trả về true nếu rỗng, false nếu không rỗng.
            $urlCheck = $this->__controller;
        }

        if (file_exists('app/controllers/' . $urlCheck . '.php')) { // Kiểm tra xem đường dẫn chứa tên controller có tồn tại hay không ?
            require_once 'controllers/' . $urlCheck . '.php'; // Nếu có thì sẽ require đường dẫn đó
            if (class_exists($this->__controller)) { // Kiểm tra class (được đặt theo tên controller) có tồn tại chưa?
                $this->__controller = new $this->__controller(); // Khởi tạo đối tượng
                unset($urlArr[0]); // Xoá tên controller trong mảng urlArr bằng hàm unset();
                if (!empty($this->__db)) {
                    $this->__controller->db = $this->__db;
                }
            } else {
                $this->loadError();
            }
        } else {
            $this->loadError();
        }

        // Xử lý action
        if (!empty($urlArr[1])) { // Kiếm tra xem có tồn tại action hay không?
            $this->__action = ucfirst($urlArr[1]); // Nếu có thì gán giá trị vào $__action.
            unset($urlArr[1]); // Xoá phần tử khỏi $urlArr
        }

        // Xử lý params
        // Tại sao phải xử lí params theo dạng đưa hết vào một mảng? => Vì chúng ta sẽ sử dụng hàm call_user_func_array.
        $this->__params = array_values($urlArr); // Biến đổi thành mảng giá trị và gán vào $__params.

        // Kiểm tra method tồn tại
        if (method_exists($this->__controller, $this->__action)) { // Kiểm tra xem có tồn tại phương thức trong một đối tượng hay không? Cú pháp method_exists($object, $methodName)
            call_user_func_array([$this->__controller, $this->__action], $this->__params); // Gọi hàm hoặc phương thức và truyền vào đó một mảng tham số
        } else { // Nếu không?
            $this->loadError(); // thì sẽ gọi hàm loadError().
        }
    }

    // -----------------------------------------HÀM LẤY Controller-----------------------------------------
    public function getCurrentController()
    {
        return $this->__controller;
    }

    // -----------------------------------------HÀM XỬ LÍ LỖI KHI URL KHÔNG ĐÚNG-----------------------------------------
    function loadError($name = '404', $data = []) // Sẽ truyền một tham số mặc định là $name = '404', $data sẽ là một mảng gồm $key và $value.
    {
        extract($data); // Hàm extract sẽ tách những $key thành một biến riêng biệt kèm giá trị $value.
        require_once 'errors/' . $name . '.php'; // Truy xuất đường dẫn chứa lỗi.
    }

    // -----------------------------------------HÀM KHỞI TẠO LỚP MIDDLEWARE THEO ROUTE-----------------------------------------
    public function handleRouteMiddleware($routeKey, $db)
    {
        global $config;
        $routeKey = trim($routeKey); // trang-chu or san-pham or tin-tuc
        // Middleware App
        // Trỏ đến đường dẫn và sử dụng các phương thức chứa trong đường dẫn đó.
        if (!empty($config['app']['routeMiddleware'])) {
            $routeMiddlewareArr = $config['app']['routeMiddleware'];
            if (!empty($routeMiddlewareArr)) {
                foreach ($routeMiddlewareArr as $key => $middleWareItem) {
                    if ($routeKey == trim($key) && file_exists('app/middlewares/' . $middleWareItem . '.php')) {
                        require_once 'app/middlewares/' . $middleWareItem . '.php';
                        if (class_exists($middleWareItem)) {
                            $middleWareObject = new $middleWareItem(); // Khởi tạo đối tượng: để sử dụng các phương thức trong đối tượng
                            if (!empty($db)) {
                                $middleWareObject->db = $db;
                            }
                            $middleWareObject->handle();
                        }
                    }
                }
            }
        }
    }

    // -----------------------------------------HÀM KHỞI TẠO LỚP MIDDLEWARE THEO GLOBAL ROUTE-----------------------------------------
    public function handleGlobalMiddleware($db)
    {
        global $config;
        // Middleware App
        // Trỏ đến đường dẫn và sử dụng các phương thức chứa trong đường dẫn đó.
        if (!empty($config['app']['globalMiddleware'])) {
            $globalMiddlewareArr = $config['app']['globalMiddleware'];
            if (!empty($globalMiddlewareArr)) {
                foreach ($globalMiddlewareArr as $middleWareItem) {
                    if (file_exists('app/middlewares/' . $middleWareItem . '.php')) {
                        require_once 'app/middlewares/' . $middleWareItem . '.php';
                        if (class_exists($middleWareItem)) {
                            $middleWareObject = new $middleWareItem(); // Khởi tạo đối tượng: để sử dụng các phương thức trong đối tượng
                            if (!empty($db)) {
                                $middleWareObject->db = $db;
                            }
                            $middleWareObject->handle();
                        }
                    }
                }
            }
        }
    }

    public function handleAppServiceProvider($db)
    {
        global $config;
        if (!empty($config['app']['boot'])) {
            $appServiceProviderArr = $config['app']['boot']; // AppServiceProvider
            if (!empty($appServiceProviderArr)) {
                foreach ($appServiceProviderArr as $appServiceProviderItem) {
                    if(file_exists('app/core/'.$appServiceProviderItem.'.php')){
                        require_once('app/core/'.$appServiceProviderItem.'.php');
                        if(class_exists($appServiceProviderItem))
                        $appServiceProvider = new $appServiceProviderItem;
                        if(!empty($db)){
                            $appServiceProvider->db = $db;
                        }
                        $appServiceProvider->boot();
                    }
                }
            }
        }
    }
}
