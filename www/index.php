<?php

use mvc\router as router;

$wr = new router\WebRouter();

$wr->routes =  array(
        'ex_admin' => array('auth_route' => 'ex_admin/login', 'auth' => 'rma_auth', 'ctl' => 'MySite', 'act' => 'admin_action'),
        'ex_admin/login' => array('auth' => 'rma_auth', 'ctl' => 'MySite', 'act' => 'admin_login'),
        '/' => array('ctl' => 'MySite', 'act' => 'root')
    );

$wr->run();