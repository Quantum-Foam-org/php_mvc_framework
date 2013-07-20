<?php


class sanitize {
    
    // removes the null byte and html tags from user intput
    // a trim is also ran
    public static function clean($data, $tags = '') {
        return strip_tags(trim(str_replace(chr(0), '', $data)), $tags);
    }
    
    
    public static function clean_all(array $data, $tags = '') {
        foreach ($data as &$var) {
           if (is_array($var)) {
                self::clean_all($var, $tags);
           } else {
                $var = self::clean($var, $tags);
           }
        }
        
        return $data;
    }
}