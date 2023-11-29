<?php
if(preg_match('/^[0-9]+$/u', -1)){
    echo "nhập đúng";
}
session_start();
require_once 'bootstrap.php';
$app = new App();
?>