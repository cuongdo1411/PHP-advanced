<?php
// Controller sẽ tương tác với Model
class Controller
{
    public $db;

    // Hàm gọi Models
    public function model($model) // Tạo một tham số truyền vào có tên là $model ( $model này là đường dẫn đến file chứa nó)
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
        if (!empty(View::$dataShare)) {
            $data = array_merge($data, View::$dataShare);
        }

        extract($data); // Hàm extract sẽ biến những $key trong mảng thành những biến riêng biệt chứa giá trị có sẵn.

        // ob_start(); // output buffering start: bắt đầu tiến hành lưu trữ vào bộ nhớ đệm.
        // // Truy xuất đường dẫn chứa giá trị $view
        // if (file_exists(_DIR_ROOT . '/app/views/' . $view . '.php')) {
        //     require_once _DIR_ROOT . '/app/views/' . $view . '.php';
        // }
        // $contentView = ob_get_contents(); // Output buffering get contents: truyền những nội dung đã lưu trữ vào biến $contentView
        // ob_end_clean(); // output buffering clean: xóa nội dung lưu trữ trong bộ nhớ đệm đầu ra mà không gửi đi.

        if (preg_match('~^layouts~', $view)) {
            if (file_exists(_DIR_ROOT . '/app/views/' . $view . '.php')) {
                require_once _DIR_ROOT . '/app/views/' . $view . '.php';
            }
        } else {
            $contentView = null;
            if (file_exists(_DIR_ROOT . '/app/views/' . $view . '.php')) {
                $contentView = file_get_contents(_DIR_ROOT . '/app/views/' . $view . '.php');
            }
            $template = new Template();
            $template->run($contentView, $data);
        }
        // echo $contentView;
    }
}
