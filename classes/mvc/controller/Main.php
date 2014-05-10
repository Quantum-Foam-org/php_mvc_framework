<?php

namespace \local\classses\mvc\controller;

class Main {

    public $vars = array();
    private static $instance = FALSE;
    protected static $type;
    protected $filters;

    public static function obj($type) {
        $class = get_called_class();
        if (!(self::$instance instanceOf $class)) {
            $class = 'ctl_' . $type;

            self::$instance = new $class();
        }

        return self::$instance;
    }

    public function work() {
        return $this->vars;
    }
	    
    public function get_type() {
        $cl = get_called_class();
        if (!is_array($cl::$type)) {
            $type = array($cl::$type, $cl::$type);
        } else {
            $type = $cl::$type;
        }
        return $type;
    }
    
    
    public function get_view() {
        list($type, $tpl) = $this->get_type();
        return view::obj($type, $tpl);
    }

    public function __construct() {
        if (!empty($this->filters)) {
            $this->filter_input();
        }
        logger::obj()->write('ctl');
        logger::obj()->write(request_vars::obj()->post);
        logger::obj()->write(request_vars::obj()->get);
        logger::obj()->write('ctl');
    }

    protected function filter_input() {
        foreach ($this->filters as $type => $filter) {
            if (in_array($type, request_vars::$types)) {
                request_vars::obj()->set_validation($type, $filter);
                request_vars::obj()->run_filter($type);
            } else {
                logger::obj()->write('Invalid type: '.$type, -2);
            }
        }
    }
}
