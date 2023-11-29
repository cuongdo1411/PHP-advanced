<?php
// PHẦN XỬ LÝ ĐƯỜNG DẪN.

// Dùng define để tạo biến hằng số, biến hằng này sẽ mang giá trị chính là đường dẫn (C:\xampp\htdocs\PHP\mvc_trainning)
define('_DIR_ROOT', __DIR__);

// Xử lý HTTP Root.
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') { // Nếu trên trình duyệt có sử dụng HTTPS và HTTPS được bật
    $web_root = 'https://' . $_SERVER['HTTP_HOST']; // thì kết quả sẽ trả ra là một chuỗi đường dẫn https://localhost
} else { // Ngược lại thì
    $web_root = 'http://' . $_SERVER['HTTP_HOST']; // thì kết quả trả ra là một chuỗi đường dẫn http://localhost
}

// Dòng dưới là để xử lý đường dẫn _DIR_ROOT 
// Bạn thấy đường dẫn đang sử dụng dấu \, nên chúng ta phải xử lý bằng hàm str_replace
$a = str_replace('\\', '/', _DIR_ROOT); // Hàm str_replace được sử dụng để thay thế các chuỗi con trong một chuỗi, gồm 3 tham số (find, replace, string)
define('_DIR_ROOT_', $a);
// Dòng dưới là lấy đường dẫn chứa thư mục của project mà chúng ta đang thực hiện
$folder = str_replace($_SERVER['DOCUMENT_ROOT'], "", $a); // Kết quả trả ra sẽ là: /PHP/mvc_trainning

// Xây dựng một URL mong muốn có tên là: http://localhost/PHP/mvc_trainning
$web_root = $web_root . $folder; // Kết quả sẽ trả ra là: http://localhost/PHP/mvc_trainning

// Tạo một biến hằng có tên là WEB_ROOT và gán vào đó giá trị vừa tìm được.
define('WEB_ROOT', $web_root);

/**
 * Tự động load những file chứa trong thư mục configs.
 */
$configs_dir = scandir('configs'); // Sử dụng hàm scandir để liệt kê tất cả các file có trong thư mục được chỉ định. Kết quả trả về là dạng mảng values.
if (!empty($configs_dir)) { // hàm empty dùng để kiểm tra giá trị có rỗng hay không. Nếu rỗng => true, không rỗng=> false.
    foreach ($configs_dir as $item) {
        if ($item != '.' && $item != '..' && file_exists('configs/' . $item)) {
            require_once 'configs/' . $item;
        }
    }
}

// Load all services
if (!empty($config['app']['service'])) {
    $allServices = $config['app']['service'];
    if (!empty($allServices)) {
        foreach ($allServices as $serviceName) {
            if (file_exists('app/core/' . $serviceName . '.php')) {
                require_once 'app/core/' . $serviceName . '.php';
            }
        }
    }
}

// Load Load.
require_once 'core/Load.php';

// Load Service Provider
require_once 'core/ServiceProvider.php';

// Load View Class
require_once 'core/View.php';

// Middleware
require_once 'core/Middlewares.php';
require_once 'core/Route.php'; // Load Routes class
require_once 'core/Session.php'; // Load Session class
// Kiểm tra config và Load database
if (!empty($config['database'])) {
    $db_config = array_filter($config['database']);

    if (!empty($db_config)) {
        require_once 'core/Connection.php';
        require_once 'core/QueryBuilder.php';
        require_once 'core/Database.php';
        require_once 'core/DB.php';

        $db = new Database();
        $query = $db->query("SELECT * FROM table1")->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Load core helpes
require_once 'core/Helper.php'; // Load Helper.
require_once 'app/App.php'; // Load App.

// Load all helpers
$allHelpers = scandir('app/helpers');
if (!empty($allHelpers)) {
    foreach ($allHelpers as $item) {
        if ($item != '.' && $item != '..' && file_exists('app/helpers/' . $item)) {
            require_once 'app/helpers/' . $item;
        }
    }
}

require_once 'core/Model.php'; // Load Model
require_once 'core/Template.php'; // Load Template
require_once 'core/Controller.php'; // Load base Controller.
require_once 'core/Request.php'; // Load Request
require_once 'core/Response.php'; // Load Response.