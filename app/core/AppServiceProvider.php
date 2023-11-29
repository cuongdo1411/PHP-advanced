<?php

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {

        // Data of footer
        $data['copyright'] = 'Copyright 2021 by Unicode';

        // Data of header
        if (!empty(Session::data('cart'))) {
            $cart = Session::data('cart');
            $totalQuantity = null;
            foreach ($cart as $item) {
                $totalQuantity += $item['quantity'];
            }
            $data['quantity'] = $totalQuantity;
        }

        $adminID = Session::data('adminID');
        if (!empty($adminID)) {
            $users = $this->db->table('users')->where('id', '=', $adminID)->get();
            $data['username_admin'] = $users[0]['username'];
        }

        $userID = Session::data('userID');
        if (!empty($userID)) {
            $users = $this->db->table('users')->where('id', '=', $userID)->get();
            $data['username_user'] = $users[0]['username'];
        }
        
        View::share($data);
    }
}
