<?php

namespace \local\classes\request;

class Vars {

    public $get = array();
    public $post = array();
    public $cookie = array();
    protected static $instance;
    
    protected $get_filtered = FALSE;
    protected $post_filtered = FALSE;
    protected $cookie_filtered = FALSE;
    protected $def_val = array('get' => array(), 'post' => array(), 'cookie' => array());
    protected $def_san = array('get' => '', 'post' => '', 'cookie' => '');
    
    public static $types = array(
        'get', 
        'post', 
        'cookie'
        );
    
    
    public function __construct() {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->cookie = $_COOKIE;
    }
    
    public static function obj() {
        
        if (self::$instance === null) {
        	self::$instance = new Vars();
        }
        
        return self::$instance;
    }
    
    public function get_validation($type) {
        return $this->def_val[$type];
    }
    
    public function get_sanitize($type) {
        return $this->def_san[$type];
    }
    
    public function set_validation($type, $values) {
        $this->def_val[$type] = $values;
        
        return $this;
    }
    
    public function set_sanitize($type, $values) {
        $this->del_san[$type] = $values;
        
        return $this;
    }
    
    public function filter_input_all($type) {
        $type = strtolower($type);
        if (in_array($type, self::$types)) {
            switch ($type) {
                case 'get':
                    $input_array = INPUT_GET;
                    break;
                case 'post':
                    $input_array = INPUT_POST;
                    break;
                case 'cookie':
                    $input_array = INPUT_COOKIE;
                    break;
            }
            
            if (!empty($this->def_val[$type])) {
                // require external filter functions needed
                foreach (array_keys($this->def_val[$type]) as $prop) {
                    if ($this->def_val[$type][$prop]['filter'] == FILTER_CALLBACK) {
                        require_once(config::$func_dir.'/filters/'.$this->def_val[$type][$prop]['options'].'.php');
                    }
                }
                request_vars::obj()->{$type} = filter_input_array($input_array, $this->def_val[$type]);
                request_vars::obj()->{$type.'_filtered'} = TRUE;
            }
        } else {
            logger::obj()->write(__CLASS__.'::'.__METHOD__.': had incorrect type:'.$type, 1);
        }
    }
    
    public function run_filter($type) {
        if ($this->{$type . '_filtered'} === FALSE) {
            switch ($type) {
                case 'get':
                    $_GET = sanitize::clean_all($_GET, $this->get_sanitize($type));
                    break;
                case 'post':
                    $_POST = sanitize::clean_all($_POST, $this->get_sanitize($type));
                    break;
                case 'cookie':
                    $_COOKIE = sanitize::clean_all($_COOKIE, $this->get_sanitize($type));
                    break;
            }
            
            $this->filter_input_all($type);
        }
    }

}