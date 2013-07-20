<?php

date_default_timezone_set('UTC');

$ini = parse_ini_file('config/init.ini', TRUE);

$ini['root_dir']['dir'] = __DIR__;

require_once($ini['root_dir']['dir'].'/classes/config.php');
require_once($ini['root_dir']['dir'].'/classes/utility/array_utils.php');

config::init($ini);