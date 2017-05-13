<?php

namespace \local\classes\request;

class Uri {
    public static $rem_peices = array();
    public static $orig_uri = null;
    
    public static function set() {
        $uri = str_replace('index.php', '', $_SERVER['REQUEST_URI']);
        if (($pos = strpos($uri, '?'))) {
            $uri = substr($uri, 0, $pos);
        }
        self::$orig_uri = filter_var($uri, FILTER_SANITIZE_STRING, array('flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK));
        if (self::$orig_uri) {
        	$parts = explode('/', self::$orig_uri);
	        $c = 0;
	        foreach($parts as $i => &$part) {
	            if (strlen($part) == 0) {
	                unset($parts[$i]);
	            } else {
	                self::$rem_peices[] = $part;
	            }
	        }
        }
    }
}
?>
