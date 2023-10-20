<?php

// Class Route có nhiệm vụ chính là xử lý và điều hướng các URL trong ứng dụng.
class Route
{

    private $__keyRoute = null;

    // ----------------------------------------------------------------HÀM XỬ LÝ ĐƯỜNG DẪN URL----------------------------------------------------------------
    function handleRoute($url)
    { // Truyền vào một tham số $url ($url là một đường dẫn) và $url này sẽ có dạng là "'controller_name'/'action_name'/'params'"
        global $routes; // Tạo biến toàn cục

        unset($routes['default_controller']); // xoá phần tử default_controller có trong mảng.
        
        // echo '<pre>';
        // echo print_r($routes);
        // echo '</pre>';
        $url = trim($url, '/'); // Làm gọn 2 bên đường dẫn (xoá 2 dấu / ở điểm đầu và điểm cuối đường dẫn, đồng thời xoá luôn khoảng trắng nếu có)

        if(empty($url)){
            $url = '/';
        }

        $handleUrl = $url; // Tạo một biến $handleUrl với nhiệm vụ là điều hướng
        if (!empty($routes)) { // Kiểm tra mảng routes có tồn tại hay không ?
            foreach ($routes as $key => $value) { // Nếu có chúng ta sử dụng vòng lặp foreach.  
                // Hàm preg_match có nhiệm vụ dùng để kiểm tra một biểu thức chính quy có khớp với chuỗi hay không?
                if (preg_match('~' . $key . '~is', $url)) {

                    // Nếu khớp với chuỗi, thay thế chuỗi $url bằng giá trị $value bằng hàm preg_replace.
                    $handleUrl = preg_replace('~' . $key . '~is', $value, $url);

                    $this->__keyRoute = $key;
                }
            }
        }
        return $handleUrl;
    }

    public function getUri(){
        return $this->__keyRoute;
    }

    static public function getFullUrl(){
        $uri = App::$app->getUrl();
        $url = WEB_ROOT.$uri;
        return $url;
    }
}
