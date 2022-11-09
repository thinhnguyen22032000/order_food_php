<?php

class Domain {
    static private $domain = 'mini_project';

    static function get(){
        return 'http://' . $_SERVER['SERVER_NAME'] .'/'. self::$domain;
    }
}