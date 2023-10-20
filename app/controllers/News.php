<?php
class News extends Controller {
    public $data = [];
    public function index(){
        $this->data['sub_content']['title'] = 'Trang tin tức';
        $this->data['sub_content']['new_content'] = 'Nội dung trang tin tức';
        $this->data['sub_content']['new_author'] = 'Cao Cường';
        $this->data['content'] = 'news/new1';
        // $this->data['content'] = 'news/new1';
        $this->render('layouts/client_layout', $this->data);
    }
}