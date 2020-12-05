<?php

namespace \local\classes\request;

class Uri {
    private static $referer_uri = null;
    private static $current_uri= null;
    
    public static function set() {
    	self::$current_uri = new HTTPUrl($_SERVER['REQUEST_URI']);
    	self::$referer_uri = new HTTPUrl($_SERVER['REFERER']);
    }
    
    public static function getCurrentUri() : ?HttpUrl {
        return self::$current_uri;
    }
    
    public static function getReferrerUri() : ?HttpUrl {
        return self::$referer_uri;
    }
}