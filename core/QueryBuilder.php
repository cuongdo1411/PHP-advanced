<?php
trait QueryBuilder
{

    public $tableName = '';
    public $where = '';
    public $operator = '';
    public $selectField = '*';
    public $limit = '';
    public $orderBy = '';
    public $groupBy = '';
    public $innerJoin = '';

    // Bảng trong CSDL
    public function table($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }

    // Điều kiện WHERE (tên cột, so sánh, giá trị)
    public function where($field, $compare, $value)
    {
        if (empty($this->where)) // Nếu $where rỗng thì
        {
            $this->operator = ' WHERE'; // Thì operator được gán giá trị là WHERE
        } else // Ngược lại
        {
            $this->operator = ' AND'; // Thì operator được gán giá trị là AND
        }
        $this->where .= "$this->operator $field $compare '$value'";
        return $this;
    }

    // Điều kiện WHERE kết hợp OR
    public function orWhere($field, $compare, $value)
    {
        if (empty($this->where)) // Nếu $where là '' thì
        {
            $this->operator = ' WHERE'; // Thì operator được gán giá trị là WHERE
        } else // Ngược lại
        {
            $this->operator = ' OR'; // Thì operator được gán giá trị là OR
        }
        $this->where .= "$this->operator $field $compare '$value'";
        return $this;
    }

    // Điều kiện WHERE kết hợp LIKE
    public function likeWhere($field, $value)
    {
        if (empty($this->where)) // Nếu $where là '' thì
        {
            $this->operator = ' WHERE'; // Thì operator được gán giá trị là WHERE
        } else // Ngược lại
        {
            $this->operator = ' AND'; // Thì operator được gán giá trị là AND
        }
        $this->where .= "$this->operator $field LIKE '%$value%'";
        return $this;
    }

    // SELECT (tên cột)
    public function select($field = "*")
    {
        $this->selectField = $field;
        return $this;
    }

    public function limit($offset, $count)
    {
        $this->limit = " LIMIT $offset, $count"; // LIMIT "nhập vị trí bắt đầu (khi lọc nó sẽ sau vị trí đã nhập)", "nhập số dòng muốn lấy"
        return $this;
    }

    /**
     * ORDER BY $id $type => truyền tên cột $id và Kiểu sắp xếp $type
     * $this->db->orderBy('id', 'DESC'); => Trường hợp chỉ truyền 1 cột 
     * $this->db->orderBy('id ASC', name DESC); => trường hợp truyền nhiều cột
     */
    public function orderBy($field, $type = 'ASC') // orderBy('id', 'ASC');
    {
        $fieldArr = array_filter(explode(',', $field)); // Hàm explode sẽ tách chuỗi thành mảng => $fieldArr = ['id', 'col1']
        if (!empty($fieldArr) && count($fieldArr) >= 2) // Nếu có tồn tại $fieldArr và độ dài của $fieldArr lớn hơn hoặc bằng 2
        {
            // SQL order by multi
            $this->orderBy = "ORDER BY " . implode(', ', $fieldArr); // Hàm implode sẽ gộp các phần tử trong mảng thành chuỗi.
        } else {
            $this->orderBy = "ORDER BY " . $field . " " . $type;
        }
        return $this;
    }

    // Group By
    public function groupBy($field)
    {
        $this->groupBy = " GROUP BY ".$field;
        return $this;
    }

    // Inner join (Tên bảng, điều kiện)
    public function join($tableName, $relationship)
    {
        $this->innerJoin .= "INNER JOIN $tableName ON $relationship" . " ";
        return $this;
    }

    // INSERT INTO (Dữ liệu thêm vào)
    // Tái sử dụng hàm insert từ Database
    public function insert($data)
    {
        $tableName = $this->tableName;
        $insertStatus = $this->insertData($tableName, $data);
        return $insertStatus;
    }

    // LastID 
    public function lastId()
    {
        return $this->lastInsertId();
    }

    // UPDATE (Dữ liệu thêm vào)
    // Tái sử dụng hàm update từ Database
    public function update($data)
    {
        $tableName = $this->tableName;
        $condition = str_replace('WHERE', '', $this->where); // Sử dụng str_replace để loại bỏ WHERE.
        $condition = trim($condition);
        $updateStatus = $this->updateData($tableName, $data, $condition);
        return $updateStatus;
    }

    // DELETE (Dữ liệu thêm vào)
    // Tái sử dụng hàm delete từ Database
    public function delete()
    {
        $condition = str_replace('WHERE', '', $this->where);
        $condition = trim($condition);
        $deleteStatus = $this->deleteData($this->tableName, $condition);
        return $deleteStatus;
    }

    // Hàm lấy 
    public function get()
    {
        $sqlQuery = "SELECT $this->selectField FROM $this->tableName $this->innerJoin $this->where $this->orderBy $this->limit $this->groupBy";
        $sqlQuery = trim($sqlQuery);
        $query = $this->query($sqlQuery);
        // Reset field
        $this->resetQuery();

        if (!empty($query)) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function first()
    {
        $sqlQuery = "SELECT $this->selectField FROM $this->tableName $this->innerJoin $this->where $this->orderBy $this->limit $this->groupBy";
        $sqlQuery = trim($sqlQuery);
        $query = $this->query($sqlQuery);

        // Reset field
        $this->resetQuery();

        if (!empty($query)) {
            return $query->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function resetQuery()
    {
        $this->tableName = '';
        $this->where = '';
        $this->operator = '';
        $this->selectField = '*';
        $this->limit = '';
        $this->orderBy = '';
        $this->groupBy = '';
        $this->innerJoin = '';
    }
}
