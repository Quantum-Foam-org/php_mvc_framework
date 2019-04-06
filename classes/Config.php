<?php

namespace web;

// do configuration of the application
class Config extends \common\Config
{
    protected $valid_types = [
        'routes',
        'root_dir',
        'project'
    ];
    protected $routes = [];
    protected $root_dir = null;
    protected $project = [];

    public function __construct() {
        parent::__construct();
    }
    
    protected function set_routes(array $routes) : void {
        foreach ($routes as $route => $cfg)
        {
            if ($cfg)
            {
                $this->routes[$route] = $cfg;
                \common\logging\Logger::obj()->writeDebug('Added route: ' . $route . ' -> ' . var_export($cfg, 1), 1);
            }
        }
        unset($route, $cfg);
    }
    
    protected function set_project(array $project) : void {
        $this->project['name'] = $project['name'];
    }
}