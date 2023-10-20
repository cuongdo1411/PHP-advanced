<?php
if (!empty($_SERVER['argv'][0])) {
    // Create Controller
    if ($_SERVER['argv'][1] == 'create') {
        if (!empty($_SERVER['argv'][2])) {
            $controllerName = $_SERVER['argv'][2];
            // echo $controllerName; Tên Controller: Categories
            if (!file_exists('app/controllers/' . $controllerName . '.php')) {
                $data = '<?php
            class ' . $controllerName . ' extends Controller{
                public $data = [];
                public function __construct(){
                    // Construct
                }
                public function index(){
                    // Index
                }
            }';
                file_put_contents('app/controllers/' . $controllerName . '.php', $data);
                echo "\033[32m Tạo controller ' . $controllerName . ' thành công \033[0m\n";
            } else {
                echo '\033[33m Controller ' . $controller . ' đã tồn tại. \033[0m\n';
            }
        }
    }

    // Delete Controller
    // echo '<pre>';
    // print_r($_SERVER);
    // echo '</pre>';
    if ($_SERVER['argv'][1] == 'delete' || $_SERVER['argv'][1] == 'del') {
        if (!empty($_SERVER['argv'][2])) {
            $nameController = $_SERVER['argv'][2];
            if (file_exists('app/controllers/' . $nameController . '.php')) {
                unlink('app/controllers/' . $nameController . '.php');
                echo "\033[31m Xóa Controller ' . $nameController . ' thành công \033[0m\n";
            } else {
                echo "Controller ' . $nameController . ' không tồn tại.";
            }
        }
    }
}
