<?php

class model {

    public $vars = array();
    private static $instance = FALSE;

    public static function obj($type) {
        $class = get_called_class();
        if (!(self::$instance instanceOf $class)) {
            $class = 'mdl_' . $type;

            self::$instance = new $class();
        }

        return self::$instance;
    }

    public function work() {
        return $this->vars;
    }

}
