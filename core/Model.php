<?php
/**Base Model */
abstract class Model extends Database{

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    abstract function tableFill();

    abstract function fieldFill();

    abstract function primaryFill();

    // Lấy tất cả bản ghi
    function getAll()
    {
        $tableName = $this->tableFill();
        $fieldSelect = $this->fieldFill();
        $sql = "SELECT $fieldSelect FROM $tableName";
        $query = $this->db->query($sql);
        if(!empty($query))
        {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    // Lấy 1 bản ghi
    function getFirst($id)
    {
        $tableName = $this->tableFill();
        $fieldSelect = $this->fieldFill();
        $primaryKey = $this->primaryFill();

        if(empty($fieldSelect))
        {
            $fieldSelect = '*';
        }

        $sql = "SELECT $fieldSelect FROM $tableName WHERE $primaryKey = $id";
        $query = $this->db->query($sql);
        if(!empty($query))
        {
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }
}