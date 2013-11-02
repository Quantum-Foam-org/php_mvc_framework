<?php

class session {
    protected static $instance;

    public static function obj() {
        $class = get_called_class();
        if (!(self::$instance instanceOf $class)) {
            $class = $class;

            self::$instance = new $class('my-sess');
        }

        return self::$instance;
    }

    public function __construct($name) {
        session_name($name);
        session_start();
    }

    public function session_set($var, $val) {
        $_SESSION[$var] = sanitize::clean_all($val);
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
