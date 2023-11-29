<?php

class Session
{
    // Ôn tập lại: là một phiên làm việc, thực hiện các chức năng như đăng nhập hoặc đăng xuất.
    /**
     * data(key, value) => set session
     * data(key) => get session
     */
    // Hàm này sẽ có nhiệm vụ là SET SESSION và GET SESSION
    // SET SESSION: truyền 2 biến
    // GET SESSION: truyền 1 biến
    static public function data($key = '', $value = '') // 'username', 'Cuong'
    {
        $sessionKey = self::isInvalid(); // Gọi hàm isInvalid

        if (!empty($value)) { // Xử lý trường hợp nếu tồn tại giá trị $value
            if (!empty($key)) { // Tồn tại $key
                $_SESSION[$sessionKey][$key] = $value; // Gán session
                return true;
            }
            return false;
        } else { // Xử lý trường hợp nếu không nhập $key 
            if (empty($key)) { // Trường hợp nếu $key rỗng
                if (isset($_SESSION[$sessionKey])) {
                    return $_SESSION[$sessionKey]; // Lấy nguyên mảng session
                }
            } else {
                if (isset($_SESSION[$sessionKey][$key])) {
                    return $_SESSION[$sessionKey][$key]; // Lấy giá trị session tương ứng với $key.
                }
            }
        }
    }

    /*
        delete(key) => Xóa session với key
        delete() => Xóa hết session
    */
    static public function delete($key = '')
    {
        $sessionKey = self::isInvalid(); // Gọi hàm isInvalid. Lấy giá trị mặc định của session.
        if (!empty($key)) { // Kiểm tra sự tồn tại của $key
            if (isset($_SESSION[$sessionKey][$key])) { // Kiểm tra sự tồn tại của giá trị của session key
                unset($_SESSION[$sessionKey][$key]); // thì xóa giá trị. [unicode_session][error] 
                return true;
            }
            return false;
        } else {
            unset($_SESSION[$sessionKey]);
            return true;
        }
        return false;
    }

    /**
     * Flash Data
     * - set Flash Data => giống như set session
     * - get Flash Data => giống như get session, xóa luôn session đó sau khi get xong
     */
    static public function flash($key = '', $value = '') // set: flash('msg','Thêm dữ liệu thành công') get: ('msg', '')
    {
        $dataFlash = self::data($key, $value); // gọi hàm data và gán vào biến $dataFlash;
        
        if (empty($value)) { // Nếu $value rỗng
            self::delete($key); // Xóa $key
        }

        return $dataFlash;
    }

    static public function showErrors($message)
    {
        $data = ['mess' => $message];
        App::$app->loadError('exception', $data);
        die();
    }

    // Hàm trả ra giá trị $value của mảng session đã tạo trong configs. Ở đây giá trị là 'unicode_session'
    static function isInvalid()
    {

        global $config;

        if (!empty($config['session'])) { // Kiểm tra sự tồn tại của session
            $sessionConfig = $config['session'];
            if (!empty($sessionConfig['session_key'])) { // Kiểm tra sự tồn tại của $sessionConfig
                $sessionKey = $sessionConfig['session_key'];
                return $sessionKey;
            } else {
                self::showErrors('Thiếu cấu hình session_key. Vui lòng kiểm tra file: configs/session.php');
            }
        } else {
            self::showErrors('Thiếu cấu hình session. Vui lòng kiểm tra file: configs/session.php');
        }
    }
}
