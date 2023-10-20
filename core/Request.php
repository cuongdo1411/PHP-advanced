<?php

class Request
{

    private $__rules = [], $__messages = [], $__errors = [];
    public $db;
    /**
     * 1. Method
     * 2. Body
     */

    public function __construct()
    {
        $this->db = new Database();
    }

    // Hàm trả về phương thức request
    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']); // strtolower dùng để thay đổi tất cả chuỗi thành in thường hết.
    }

    // Hàm kiểm tra xem có phải phương thức post hay không?
    public function isPost()
    {
        if ($this->getMethod() == 'post') { // Nếu có tồn tại phương thức post
            return true;
        } else {
            return false;
        }
    }

    // Hàm kiểm tra xem có phải phương thức get hay không?
    public function isGet()
    {
        if ($this->getMethod() == 'get') { // Nếu có tồn tại phương thức get
            return true;
        } else {
            return false;
        }
    }

    // Hàm lấy Fields.
    public function getFields()
    {
        $dataFields = []; // $dataField sẽ chứa tất cả các giá trị do user nhập vào

        if ($this->isGet()) {
            // Xử lí lấy dữ liệu với phương thức get()
            if (!empty($_GET)) { // Nếu như có tồn tại việc giá trị được truyền qua phương thức GET.
                // Sử dụng Foreach để đẩy dữ liệu vào mảng $dataFields. Tuy nhiên cách này sẽ gây ra sự không an toàn cho dữ liệu của bạn
                // => Sử dụng filter_input() để lọc ra các ký tự đặc biệt gây hại đến CSDL.
                foreach ($_GET as $key => $value) {
                    if (is_array($value)) { // Nếu như giá trị được đẩy vào là một mảng.
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }

        if ($this->isPost()) {
            // Xử lí lấy dữ liệu với phương thức post()
            if (!empty($_POST)) {
                // Sử dụng Foreach để đẩy dữ liệu vào mảng $dataFields. Tuy nhiên cách này sẽ gây ra sự không an toàn cho dữ liệu của bạn
                // => Sử dụng filter_input() để lọc ra các ký tự đặc biệt gây hại đến CSDL.
                foreach ($_POST as $key => $value) {
                    if (is_array($value)) {
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }

        return $dataFields;
    }

    // Set Rules.
    public function rules($rules = [])
    {
        $this->__rules = $rules;
        // echo '<pre>';
        // print_r($this->__rules);
        // echo '</pre>';
    }

    // Set Message.
    public function message($message = [])
    {
        $this->__messages = $message;
        // echo '<pre>';
        // print_r($this->__messages);
        // echo '</pre>';
    }

    // Set Validate
    public function validate()
    {
        $this->__rules = array_filter($this->__rules); // array_filter sẽ lọc đi khoảng trống 2 bên mảng.

        $checkValidate = true; // biến Flag

        if (!empty($this->__rules)) { // Nếu tồn tại mảng rules

            $dataFields = $this->getFields();  // Biến dataFields sẽ chứa mảng giá trị của user.

            // echo '<pre>';
            // print_r($dataFields);
            // echo '</pre>';

            foreach ($this->__rules as $fieldName => $ruleItem) {

                $ruleItemArr = explode('|', $ruleItem); // explode() dùng để tách chuỗi thành mảng.

                foreach ($ruleItemArr as $rules) { // Sử dụng vòng lặp để tách dấu ":" có trong $ruleItemArr

                    $ruleName = null;
                    $ruleValue = null;

                    // 'required,min:5,max:30'
                    $rulesArr = explode(':', $rules); // explode() dùng để tách chuỗi thành mảng. Lúc này kết quả trả ra là [Array([0]=>required),Array([0]=>min [1]=>5), Array([0]=>max [1]=>30)]
                    $ruleName = reset($rulesArr); // Dùng hàm reset để lấy giá trị đầu tiên trong mảng và gán vào biến $ruleName. Kết quả trả ra là required, min, max

                    if (count($rulesArr) > 1) { // Nếu như mảng trả về có độ dài lớn hơn 1
                        $ruleValue = end($rulesArr); // thì sử dụng hàm end để lấy giá trị cuối cùng trong mảng. Kết quả trả ra là: 5,30,...
                    }

                    // Check từng điều kiện rules
                    if ($ruleName == 'required') {
                        if (empty(trim($dataFields[$fieldName]))) { // trim dùng để cắt bỏ khoảng trống của chuỗi nếu có
                            $this->set_Errors($fieldName, $ruleName); // 
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'min') {
                        if (strlen(trim($dataFields[$fieldName])) < $ruleValue) { // dùng strlen để trả về độ dài ký tự của chuỗi.
                            $this->set_Errors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'max') {

                        if (strlen(trim($dataFields[$fieldName])) > $ruleValue) { // dùng strlen để trả về độ dài ký tự của chuỗi.
                            $this->set_Errors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'email') {
                        if (!filter_var($dataFields[$fieldName], FILTER_VALIDATE_EMAIL)) { // Kiểm tra định dạng email
                            $this->set_Errors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'match') {
                        if (trim($dataFields[$fieldName]) != trim($dataFields[$ruleValue])) {
                            $this->set_Errors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'unique') {
                        $tableName = null;
                        $fieldCheck = null;
                        if (!empty($rulesArr[1])) {
                            $tableName = $rulesArr[1];
                        }

                        if (!empty($rulesArr[2])) {
                            $fieldCheck = $rulesArr[2];
                        }

                        if (!empty($tableName) && !empty($fieldCheck)) {
                            // SELECT count(*) FROM $tableName WHERE $fieldCheck ='$dataFields[$fieldName]' là câu lệnh truy vấn lấy giá trị là số đếm, đếm xem trong CSDL có bao nhiêu giá trị thỏa điều kiện WHERE.
                            $checkExist = $this->db->query("SELECT $fieldCheck FROM $tableName WHERE $fieldCheck ='$dataFields[$fieldName]'")->rowCount();
                            if (!empty($checkExist)) {
                                $this->set_Errors($fieldName, $ruleName);
                                $checkValidate = false;
                            }
                        }
                    }

                    // Callback validate
                    // Dùng preg_match để kiểm tra $ruleName có khớp với biểu thức ~^callback_(.+)~is, nếu khớp kết quả sẽ được lưu trữ vào mảng $call
                    if (preg_match('~^callback_(.+)~is', $ruleName, $callbackArr)) { // $ruleName = 'callback_check_age'
                        if (!empty($callbackArr[1])) {
                            $callbackName = $callbackArr[1]; // 'callback_check_age
                            $controller = App::$app->getCurrentController();
                            if (method_exists($controller, $callbackName)) {
                                $checkCallback = call_user_func_array([$controller, $callbackName], [trim($dataFields[$fieldName])]);
                                if (!$checkCallback) {
                                    $this->set_Errors($fieldName, $ruleName);
                                    $checkValidate = false;
                                }
                            }
                        }
                    }
                }
            }
        }

        $sessionKey = Session::isInvalid(); // 'unicode_session'
        Session::flash($sessionKey.'_errors', $this->errors()); // set gia tri errors vao $key unicode_session_errors
        Session::flash($sessionKey.'_old', $this->getFields()); // set gia tri errors vao $key unicode_session_errors

        return $checkValidate;
    }

    // Get errors
    public function errors($fieldName = '')
    {
        if (!empty($this->__errors)) // Nếu tồn tại errors
        {
            if (empty($fieldName)) { // Nếu $fieldName rỗng.
                $errorsArr = [];
                foreach ($this->__errors as $key => $error) {
                    $errorsArr[$key] = reset($error);
                }
                return $errorsArr;
            }
            return reset($this->__errors[$fieldName]); // Lấy cái đầu tiên trong mảng errors bằng hàm reset().
        }
        return false;
    }

    // Set errors
    public function set_Errors($fieldName, $ruleName)
    {
        $this->__errors[$fieldName][$ruleName] = $this->__messages[$fieldName . '.' . $ruleName];
        // Mảng có tên là $fieldName, với $key là $ruleName. Mảng này được đẩy vào một mảng lớn hơn là errors.
        // Giá trị truyền vào chính là mảng messages được tạo sẵn từ Database.
    }
}
