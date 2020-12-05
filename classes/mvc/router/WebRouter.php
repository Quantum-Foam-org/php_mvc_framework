<?php

namespace mvc\router;

use \local\classes\request\Uri;

class WebRouter {

    private $mainProject = 'tpl';
    private $defaultCtl = [
        404 => ['ctl' => 'ActionGroup', 'act' => 'page404'],
        500 => ['ctl' => 'ActionGroup', 'act' => 'page500']
        ];
    private $routes = array();
    
    public function __set($name, $value) {
        if (in_array($name, array('mainProject', 'routes'))) {
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
        Uri::set();

        try {
            list($class, $action) = $this->get_ctl();
        } catch(\UnexpectedValueException $uve) {
            $this->header404();
        }
        $ctl = new $class();
        $ctl->$action();
        exit();
    }

    private function get_ctl() : array {
        $options = ($path = Uri::getCurrentUri()->url['path'] ? $this->routes[$path] : null);
        
        if (isset($options['auth_route'], $options['auth'], $this->routes['auth_route'])) {
            if (\class_exists($options['auth'])
                && !\call_user_func($options['auth'].'::is_valid')
            ) {
                $route = sprintf("Location: %s", $this->routes['auth_route']);
                header($route);
                exit();
            } else {
                $log = 'Authentication route not configured';
                Logger::obj()->write($log, -1);
            
                throw new \BadMethodCallException($log);
            }
        }
        
        if (isset($options['ctl'], $options['act'])) {
            $ctl = $options['ctl'];
            $act = $options['act'];
        } else {
            $this->header404();
        }
        
        if (!\class_exists($ctl) || !\method_exists($ctl, $act)) {
            $log = 'Unable to find controller action';
            Logger::obj()->write($log, -1);
            
            throw new \UnexpectedValueException($log);
        }
        
        return array($ctl, $act);
    }
    
    public function header404() {
       // $route = sprintf('Location: %s', $this->defaultCtl[404])
        header($route);
        exit();
    }
}