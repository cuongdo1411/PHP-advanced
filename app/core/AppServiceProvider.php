<?php

class AppServiceProvider extends ServiceProvider
{
    public function boot(){

        $data = $this->db->table('infouser')->where('id','=',1)->get();
        $data['copyright'] = 'Copyright 2021 by Unicode';
        
        View::share($data);
    }
}
