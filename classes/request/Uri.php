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
        self::$orig_uri = $uri;
        $parts = explode('/', $uri);
        $c = 0;
        foreach($parts as $i => &$part) {
            $part = sanitize::clean($part);
            if (strlen($part) == 0) {
                unset($parts[$i]);
            } else {
                self::$rem_peices[] = $part;
            }
        }
    }
}
?>
