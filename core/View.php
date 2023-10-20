<?php
class View{
    static public $dataShare = [];

    static public function share($data){
        return self::$dataShare = $data;
    }
}