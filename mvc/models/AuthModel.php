<?php

class AuthModel extends DB{
    // check username
    // check password
    function login($username, $password){
        $flag = true;
        $checkUser = $this->db->row(
            "SELECT * FROM tbl_user WHERE username = ?", 
            $username
        );
        if(!empty($checkUser)){
            $pwd_peppered = hash_hmac("sha256", $password, $_ENV['SECRECT_KEY']);
            if(!password_verify($pwd_peppered, $checkUser['password'])){
                $flag = false;
            }
        }else{       
            $flag = false;
        }
        return $flag;        
    }

    function register($username, $password){
        $flag = true;
        $checkUser = $this->db->row(
            "SELECT * FROM tbl_user WHERE username = ?", 
            $username
        );
        if(!empty($checkUser)){
           $flag = false;
        }else{
            $pwd_peppered = hash_hmac("sha256", $password, $_ENV['SECRECT_KEY']);
            $pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID);
            $result = $this->db->insert('tbl_user', [
                'user_id' => null,
                'username' => $username,
                'password' => $pwd_hashed,
            ]);
            $result < 1 && $flag = false;
        }
        return $flag;        
    }
}