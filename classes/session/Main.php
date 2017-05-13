<?php

namespace \local\classes\session;

class Main {
    protected static $instance;

    public static function obj($sname = null) {
        $class = get_called_class();
        if (!(self::$instance instanceOf $class)) {
        	self::$instance = new $class($sname);
        }

        return self::$instance;
    }

    public function __construct($sname) {
    	
    	if ($sname !== null) {
    		session_name($sname);
    	}
        session_start();
    }

    public function session_set($var, $val) {
    	$var = filter_var($var, FILTER_SANITIZE_STRING);
    	
    	if ($var !== FALSE) {
        	$_SESSION[$var] = filter_var($val, FILTER_SANITIZE_STRING, array('flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_ENCODE_HIGH));
    	}
    	
        return $var;
    }

    public function destroy() {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', 0, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        session_unset();
        session_destroy();
    }

    public function __destruct() {
        session_write_close();
    }

}
