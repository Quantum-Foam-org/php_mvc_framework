<?php


class Main {

	private static $mainProject = 'tpl';
    private static $default_ctl = '404';
    private static $routes = array(
        'ex_admin' => array(),
        'open_page' => array()
    );
    public static $orig_route = null;
    
    public static function run() {
        \local\classes\request\Uri::set();

        list($class, $action) = self::get_ctl();
        $ctl = new $ctl_class();
        $ctl->$action();
    }

    private static function get_ctl() {
        self::$orig_route = \local\classes\request\Uri::$orig_uri;
		$pos = strrpos('/', self::$orig_route);
		$class = str_replace('/', '\\', substr(self::$orig_route, 0, $pos-1));
        $action = substr(self::$orig_route, $pos);
        
        if (!class_exists($class) || !method_exists($class, $action)) {
            $ctl = 'ctl_' . self::$default_ctl;
        }

        unset($pos);
        
        return array($class, $action);
    }
}

\Main::run();
