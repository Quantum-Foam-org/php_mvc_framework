<?php

class view {
    protected $tpl = null;
    protected $type = null;
    protected $has_head_foot = TRUE;
    protected $file_type = '.phtml';
    private static $instance = FALSE;
    
    public static function obj($type, $tpl) {
        if (!(self::$instance instanceOf view)) {
            self::$instance = new view($type, $tpl);
        }
        
        return self::$instance;
    }
    
    public function __construct($type, $tpl) {
        $this->tpl = $tpl;
        $this->type = $type;
        
        if (isset(request_vars::obj()->get['t']) and request_vars::obj()->get['t'] == 'json') {
            $this->has_head_foot = FALSE;
            header('content-type: application/json');
        }

        $this->file_type = '.phtml';
        if (isset(request_vars::obj()->get['no_head']) && request_vars::obj()->get['no_head'] == 1) {
           $this->has_head_foot = FALSE; 
        }
        $this->check_view();
    }
    
    public function show(array $vars) {
        if (!empty($vars)) {
            extract($vars);
        }
        
        if ($this->tpl) {
            if ($this->has_head_foot) {
                require(config::$view_dir.'/header_footer.php');
            } else {
                $__v_header = '';
                $__v_footer = '';
            }
            
            echo $__v_header;
            require(config::$view_dir.'/'.$this->type.'/'.$this->tpl.$this->file_type);
            echo $__v_footer;
        }
    }
    
    private function check_view() {
        $view = config::$view_dir.'/'.$this->type.'/'.$this->tpl.$this->file_type;
        
        if (!is_readable($view)) {
            logger::obj()->write('Unable to open view phtml: '.$view, -1);
            $result = FALSE;
        } else {
            $result = TRUE;
        }
        
        return $result;
    }
    
    public function __set($var, $value) {
        $this->{$var} = $value;
    }
    
    public function __get($var) {
        return $this->{$var};
    }
}