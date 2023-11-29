<?php
class AuthMiddleware extends Middlewares
{

    protected $_authModel;

    public function handle()
    {
        $this->_authModel = Load::model('AuthModel');
        // Redirect Admin
        if (empty(Session::data("userId"))) {
            $response = new Response;
            $response->redirect('authentication/login');
        }
    }
}
