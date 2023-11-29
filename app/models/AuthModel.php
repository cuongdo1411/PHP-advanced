<?php
class AuthModel extends Model
{
    function tableFill()
    {
        return 'users';
    }

    function fieldFill()
    {
        return '*';
    }

    function primaryFill()
    {
        return '';
    }

    function register($data = []){
        return $this->db->table('users')->insert($data);
    }

    function login($data = []){
        return $this->db->table('users')->where('username','=',$data['username'])->where('password','=',md5($data['password']))->get();
    }

    function getUserRoleById($id){
        return $this->db->select('role_id')->table('users')->where('ID','=',$id)->get();
    }

}