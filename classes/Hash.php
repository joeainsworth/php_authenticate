<?php

class Hash {
    public static function make($string, $salt = '') {
        return hash('sha256', $string . $salt);
    }
    
    // Improves security of password hash
    public static function salt($length) {
        return mcrypt_create_iv($length);
    }
    
    public static function unique() {
        return self::make(uniqid());
    }
}