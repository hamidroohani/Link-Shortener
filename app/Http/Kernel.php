<?php

namespace App\Http;

use App\Http\Config;
use App\Models\DB;

class Kernel
{
    public $controller = "LinkController";
    public $action = "index";
    public $params = [];

    public function __construct()
    {
        $url = (array)$this->parseUrl();//[c,a,[p]]
        if (!isset($url[0])) {
            $url[0] = "home";
        }
        $format_url = ucfirst($url[0]) . "Controller";
        if (file_exists(Config::CONTROLLERS_PATH . $format_url . ".php")) {
            $this->controller = $format_url;
            unset($url[0]);
        }

        $database = new DB();
        $database->check_table_exists();

        require_once Config::CONTROLLERS_PATH . $this->controller . ".php";
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->action = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [""];
        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode("/", rtrim($_GET['url'], "/"));
        }
    }
}