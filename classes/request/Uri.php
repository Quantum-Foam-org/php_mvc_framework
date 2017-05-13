<?php

namespace \local\classes\request;

class Uri {
	public static $referer_uri = null;
    public static $current_uri= null;
    
    public static function set() {
    	self::$current_uri = new HTTPUrl($_SERVER['REQUEST_URI']);
    	self::$referer_uri = new HTTPUrl($_SERVER['REFERER']);
    }
}