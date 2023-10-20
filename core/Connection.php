<?php
// class Connection có nhiệm vụ kết nối đến Cơ sở dữ liệu.
class Connection
{
    private static $instance = null, $conn = null;

    private function __construct($config)
    {
        // Kết nối database.
        try { // Cấu hình các trường hợp ngoại lệ.
            // Cấu hình dsn
            // mysql:
            // dbname: tên cơ sở dữ liệu.
            // host: localhost
            $dsn = 'mysql:dbname=' . $config['db'] . ';host=' . $config['host']; // mysql:dbname='webanhang';host='localhost';

            // Cấu hình $option.
            /**
             * - Cấu hình urf8
             * - Cấu hình ngoại lệ khi truy vấn bị lỗi
             */
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', //...
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //...
            ];

            // Câu lệnh kết nối
            $con = new PDO($dsn, $config['user'], !empty($config['pass']) ? empty($config['pass']): '', $options); // Khởi tạo đối tượng PDO("Cấu hình DSN", "username", "password", "Cấu hình PDO")

            self::$conn = $con; // Gán vào câu lệnh kết nối vào $conn.

        } catch (Exception $exception) { // catch: phần xử lý các trường hợp ngoại lệ. $exception: được dùng để nhận ngoại lệ được ném ra.
            $mess = $exception->getMessage(); // getMessage được lấy từ đối tượng Exception, có chức năng mô tả chi tiết lỗi.
            
            
            
            //-------------------XEM LẠI------------------
            $data['mess'] = $mess;
            App::$app->loadError('database', $data);
            //--------------------------------------------
            
            
            
            die(); // Hàm die này dùng để dừng chương trình đồng thời hiển thị lỗi từ biến $mess.
        }
    }

    public static function getInstance($config)
    {
        if (self::$instance == null) // Kiểm tra $instance để đảm bảo rằng chỉ có một đối tượng duy nhất của lớp được tạo ra.
        {
            $connection = new Connection($config);
            self::$instance = self::$conn;
        }
        return self::$instance;
    }
}
