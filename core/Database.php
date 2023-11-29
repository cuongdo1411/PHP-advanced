<?php

class Database{
    private $__conn;

    use QueryBuilder;
    
    // -----------------------------------------HÀM KHỞI TẠO-----------------------------------------
    function __construct(){
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
    }

    // -----------------------------------------HÀM THÊM DỮ LIỆU-----------------------------------------
    function insertData($table, $data){ // $table là tên bảng dữ liệu cần chèn vào, $data là một mảng chứa dữ liệu cần chèn
        if(!empty($data)){ // empty dùng để kiểm tra mảng $data có rỗng hay không?
            $fieldStr = ''; // Đây là tên cột
            $valueStr = ''; // Đây là giá trị truyền vào
            foreach($data as $key=>$value){ // $data = ['col1' => val1 , ...]
                $fieldStr.=$key.','; // fieldStr = col1,col2,col3,
                $valueStr.="'".$value."'".","; // valueStr = 'val1','val2','val3',
            }
            $fieldStr = rtrim($fieldStr,','); // Sử dụng rtrim để loại bỏ ký tự cuối cùng bên tay phải. Cụ thể ở đây là ký tự ','
            $valueStr = rtrim($valueStr,','); // Sử dụng rtrim để loại bỏ ký tự cuối cùng bên tay phải. Cụ thể ở đây là ký tự ','

            $sql = "INSERT INTO $table($fieldStr) VALUES ($valueStr)"; // Viết câu lệnh SQL.
            echo $sql;
            $status = $this->query($sql); // Gọi đến hàm query.
            if($status)
            {
                return true;
            }
        }
        return false;
    }

    // -----------------------------------------HÀM SỬA-----------------------------------------
    // UPDATE ten_bang => $table
    // SET col1 = val1, col2 = val2, ... => $updateStr
    // WHERE [dieu_kien]
    function updateData($table, $data, $condition='')
    {
        if(!empty($data)) // Nếu tồn tại $data
        {
            $updateStr = '';
            foreach($data as $key=>$value){ // Vòng lặp foreach, lặp qua mảng $data.
                $updateStr .="$key='$value',"; // $updateStr = " col1 = 'val1' ", " col2 = 'val2' "
            }
            
            $updateStr = rtrim($updateStr,','); // Dùng rtrim để loại bỏ ký tự cuối cùng trong chuỗi

            // Xét trường hợp có chứa điều kiện hay không?
            if(!empty($condition))
            {
                $sql = "UPDATE $table SET $updateStr WHERE $condition";
            }
            else
            {
                $sql = "UPDATE $table SET $updateStr";
            }

            $status = $this->query($sql);

            if($status)
            {
                return true;
            }
        }
        return false;
    }

    // -----------------------------------------HÀM XÓA-----------------------------------------
    // DELETE FROM $table
    // WHERE $condition
    function deleteData($table, $condition =''){
        if(!empty($condition))
        {
            $sql = "DELETE FROM $table WHERE $condition";
        }
        else
        {
            $sql = "DELETE FROM $table";
        }

        $status = $this->query($sql);

        if($status)
        {
            return true;
        }
        
        return false;
    }

    // -----------------------------------------HÀM TRUY VẤN-----------------------------------------
    function query($sql){
        try{ // Xử lý các ngoại lệ
            $statement = $this->__conn->prepare($sql);
            $statement->execute();
            return $statement;
        }
        catch (Exception $exception){
            $mess = $exception->getMessage();
            $data['mess'] = $mess;
            App::$app->loadError('database', $data);
            die();
        }
    }

    // Trả về ID mới nhất sau khi đã Insert.
    function lastInsertId()
    {
        return $this->__conn->lastInsertId(); // Phương thức lastInsertId() là phương thức có sẵn, nằm trong đối tượng Connection.
    }
}