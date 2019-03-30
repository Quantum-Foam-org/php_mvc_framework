<?php

use mvc\router as router;

$wr = new router\WebRouter();

$wr->routes =  array(
        'ex_admin' => array('auth' => 'rma_auth', 'ctl' => 'MySite', 'action' => 'admin_action'),
        'ex_admin/login' => array('auth' => 'rma_auth', 'ctl' => 'MySite', 'action' => 'admin_login'),
        '/' => array('ctl' => 'MySite', 'action' => 'root')
    );

$wr->run();