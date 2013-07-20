<?php

class main {

    private static $default_ctl = '404';
    private static $routes = array(
        'ex_admin' => array('auth' => array('rma_admin', 'rma_auth')),
        'ex_admin/login' => array('auth' => array('rma_admin', 'rma_auth')),
        'open_page' => array()
    );
    public static $orig_route = null;

    public static function run() {
        request_uri::set();

        $ctl_class = self::get_ctl();
        $ctl = new $ctl_class();
        $ctl->handle();
        $vars = $ctl->get_model()->work();

        $ctl->get_view()->show($vars);
    }

    private static function get_ctl() {
        $ctl = '';
        $options = array();
        
        self::$orig_route = substr(request_uri::$orig_uri, 1);
        $last = self::$orig_route[strlen(self::$orig_route)-1];
        if ($last == '/') {
            self::$orig_route = substr(self::$orig_route, 0, -1);
        }
        $key = self::$orig_route;
        if (isset(self::$routes[$key])) {
                $ctl = 'ctl_'.end(explode('/', $key));
                $options = self::$routes[$key];
        }
        if (!empty($options) && isset($options['auth'])) {
            $cls = end($options['auth']);
            $auth = call_user_func($cls.'::obj');
            if (!$auth::is_valid()) {
                $ctl = 'ctl_'.$cls;
            }
        }
        if (!class_exists($ctl)) {
            $ctl = 'ctl_' . self::$default_ctl;
        }

        unset($last, $cls, $auth, $options);
        
        return $ctl;
    }

}

main::run();
