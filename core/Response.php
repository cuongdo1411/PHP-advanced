<?php
class Response
{
    // Hàm chuyển hướng
    public function redirect($uri = '')
    {
        if (preg_match('~^(http|https)~is', $uri)) { // Kiểm tra xem có bắt đầu bằng "http://" hoặc "https://" hay không? Nếu có thì $uri là một đường dẫn tuyệt đối
            $url = $uri; // gán $url = $uri
        } else {
            $url = WEB_ROOT . '/' . $uri; // Nếu không có thì sẽ gán đường dẫn tạo sẵn trước đó.
        }
        header('Location: ' . $url); // Chuyển hướng đến đường dẫn bằng hàm header.
        exit;
    }
}
