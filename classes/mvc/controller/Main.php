<?php

namespace mvc\controller;

class Main {

    public $vars = array();
    private static $instance = FALSE;
    protected $path = null;
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
    
    public function getView(string $projectName, string $tpl) : View {
        return view::obj($type, $tpl, $this->path);
    }

    protected function filterInput(array $filters) {
        foreach ($filters as $type => $filter) {
            if (in_array($type, request_vars::$types)) {
                request_vars::obj()->set_validation($type, $filter);
                request_vars::obj()->run_filter($type);
            } else {
                logger::obj()->write('Invalid type: '.$type, -2);
            }
        }
        
        logger::obj()->write('ctl');
        logger::obj()->write(request_vars::obj()->post);
        logger::obj()->write(request_vars::obj()->get);
        logger::obj()->write('ctl');
    }
}
