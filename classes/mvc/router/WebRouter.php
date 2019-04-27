<?php

namespace mvc\router;

class WebRouter {

    private $mainProject = 'tpl';
    private $defaultCtl = array('ctl' => 'ActionGroup', 'act' => 'header404');
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
        
        $options = ($this->routes[$this->orig_route] ?: null);
        
        if (isset($options['auth_route'], $this->routes['auth_route']) 
                && !\call_user_func($options['auth'].'::is_valid')) {
            header("Location: ".$options['auth_route']);
            exit();
        }
        
        if (isset($options['ctl'], $options['auth'], $options['act'])) {
            if (!\call_user_func($options['auth'].'::is_valid')) {
                $ctl = $options['ctl'];
                $act = $options['act'];
            } else {
                header();
                exit();
            }
        } else if (isset($options['ctl'], $options['act'])) {
            $ctl = $options['ctl'];
            $act = $options['act'];
        } else {
            $ctl = $this->default_ctl;
            $act = $this->default_act;
        }
        
        if (!\method_exists($ctl, $act)) {
            
        }
        
        return array($ctl, $act);
    }
}