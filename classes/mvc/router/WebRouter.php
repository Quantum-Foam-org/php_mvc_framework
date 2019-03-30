<?php

namespace mvc\router;

class WebRouter {

    private $mainProject = 'tpl';
    private $defaultCtl = '404';
    private $routes = array();
    private $origRoute = null;
    
    public function __set($name, $value) {
        if (in_array($name, array('mainProject', 'defaultCtl', 'routes'))) {
            $this->$name = $value;
        }
    }
    
    public function __get($name) {
        $value = FALSE;
        if ($name === 'origRoute') {
            $value = $this->$name;
        }
        
        return $value;
    }
    
    public function run() : void {
        \local\classes\request\Uri::set();

        list($class, $action) = $this->get_ctl();
        $ctl = new $ctl_class();
        $ctl->$action();
    }

    private function get_ctl() : array {
        $this->orig_route = \local\classes\request\Uri::$orig_uri;
	$pos = \strrpos('/', $this->orig_route);
	$class = \str_replace('/', '\\', \substr($this->orig_route, 0, $pos-1));
        $action = \substr($this->orig_route, $pos);
        
        $options = ($this->routes[$this->orig_route] ?: null);
        
        if (!empty($options) && isset($options['auth'])) {
            $auth_cls = $options['auth'];
            $auth = \call_user_func($auth_cls.'::obj');
            if (!$auth::is_valid()) {
                $ctl = 'ctl_'.$cls;
            }
        }
        
        if (!\class_exists($class) || !\method_exists($class, $action)) {
            $ctl = 'ctl_' . $this->default_ctl;
        }
        
        unset($pos);
        
        return array($class, $action);
    }
}