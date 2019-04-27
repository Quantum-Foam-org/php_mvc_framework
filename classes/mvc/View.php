<?php

namespace mvc;

class View {
    protected $tplName = null;
    protected $projectName = null;
    protected $path = null;
    protected $has_head_foot = TRUE;
    private static $instance = FALSE;
    
    public static function obj(string $projectName, string $tpl, string $path = null) : View {
        if (!(self::$instance instanceOf view)) {
            self::$instance = new view($type, $tpl);
        }
        
        return self::$instance;
    }
    
    public function __construct(string $projectName, string $tpl, string $path = null) {
        $this->projectName = $projectName;
        $this->tplName = $tpl;
        $this->path = $type;
        
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
            require(config::$view_dir.'/'.$this->path.'/'.$this->tplName);
            echo $__v_footer;
        }
    }
    
    private function checkView() : boolean {
        $view = config::$view_dir.'/'.$this->path.'/'.$this->tplName;
        
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