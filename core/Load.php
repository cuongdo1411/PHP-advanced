<?php

class Load
{
    // Hàm gọi Models
    static public function model($model) // Tạo một tham số truyền vào có tên là $model ( $model này là đường dẫn đến file chứa nó)
    {
        if (file_exists(_DIR_ROOT . '/app/models/' . $model . '.php')) { // Kiểm tra đường dẫn có tồn tại hay không thông qua biến $model thông qua hàm file_exists().
            require_once _DIR_ROOT . '/app/models/' . $model . '.php'; // Nếu có thì sẽ truy xuất nó thông qua hàm require_once
            if (class_exists($model)) { // Kiểm tra xem biến $model có phải là một class hay không?
                $model = new $model(); // Nếu có thì sẽ khởi tạo đối tượng.
                return $model; // trả về giá trị $model.
            }
        }
        return false; // Ngược lại sẽ trả ra giá trị false
    }

    // Hàm render ( có thể hiểu là hiển thị giao diện trên website)
    public function render($view, $data = []) // Hàm sẽ chứa 2 tham số: $view có nhiệm vụ là đường dẫn sẽ được require ra, còn $data sẽ có nhiệm vụ là dữ liệu được đưa vào.
    {
        extract($data); // Hàm extract sẽ biến những $key trong mảng thành những biến riêng biệt chứa giá trị có sẵn.
        
        // Truy xuất đường dẫn chứa giá trị $view
        if (file_exists(_DIR_ROOT . '/app/views/' . $view . '.php')) { 
            require_once _DIR_ROOT . '/app/views/' . $view . '.php';
        }
    }
}
