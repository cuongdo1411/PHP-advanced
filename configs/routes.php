<?php
// Tạo một mảng $routes và thêm vào đó:
// default_controller => home;
$routes['default_controller'] = 'home';
/**
 * Làm cho đường dẫn đẹp hơn bằng cách:
 * Đường dẫn ảo => đường dẫn thật
 */
$routes['san-pham'] = 'product/index'; // san-pham => product/index
$routes['trang-chu'] = 'home'; // trang-chu => home
$routes['tin-tuc/.+-(\d+).html'] = 'news/new1/$1'; //tin-tuc/.+-(\d+).html => news/category/$1 // tin-tuc/the-gioi-1.html