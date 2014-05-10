<?php

use \local\classes\session;

abstract class Main extends \local\classes\session\Main {
    abstract public static function is_valid();
}