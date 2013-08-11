<?php


class configure {
    protected static $type;
    protected $filters;
    
    public function get_type() {
        $cl = get_called_class();
        if (!is_array($cl::$type)) {
            $type = array($cl::$type, $cl::$type);
        } else {
            $type = $cl::$type;
        }
        return $type;
    }
    
    public function get_ctl() {
        list(, $tpl) = $this->get_type();
        return model::obj($tpl);
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