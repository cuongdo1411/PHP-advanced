<?php
// Helper là một hàm giúp xử lí các câu lệnh lặp đi lặp lại.
// Ví dụ: tại file add.html có những câu lệnh
// <?php echo (!empty($errors) && array_key_exists('email', $errors)) ? '<span style="color:red;">' . $errors['email'] . '</span>' : false;

$sessionKey = Session::isInvalid(); // gọi hàm isInvalid (unicode_session)
$errors = Session::flash($sessionKey . '_errors'); // Lấy session errors
$old = Session::flash($sessionKey . '_old'); // Lấy session old

if (!function_exists('form_error')) { // Kiểm tra hàm form_error có tồn tại hay không?
    function form_error($fieldName, $before = '', $after = '') // $fieldName: tên field (fullname, pass, ...), $before: HTML, $after: HTML
    {
        global $errors; // tạo biến toàn cục
        if (!empty($errors) && array_key_exists($fieldName, $errors)) { // Kiểm tra tồn tại của tên field và errors
            return $before . $errors[$fieldName] . $after; // Dựa vào ví dụ ở trên mà trả ra kết quả
        }
        return false;
    }
}

if (!function_exists('old')) {
    function old($fieldName, $default = '')
    {
        global $old;
        if (!empty($old[$fieldName])) {
            return $old[$fieldName];
        }
        return $default;
    }
}
