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
$routes['gio-hang'] = 'cart/index'; // gio-hang => carts/cart
$routes['dang-ky'] = 'authentication/register';
$routes['dang-nhap'] = 'authentication/login';
$routes['quan-ly'] = 'admin/Dashboard/index';
$routes['tin-tuc/.+-(\d+).html'] = 'news/new1/$1'; //tin-tuc/.+-(\d+).html => news/category/$1 // tin-tuc/the-gioi-1.html