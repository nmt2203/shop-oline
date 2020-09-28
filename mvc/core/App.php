<?php
class App
{
    protected $directory = "DoAnTH02";
    protected $controller = "Home";
    protected $action = "index";
    protected $params = [];

    #
    function __construct()
    {

        $arr = $this->UrlProcess();
        // print_r ("controller:".$arr[0]."<br>");
        // print_r ("action:".$arr[1]."<br>");
        // print_r ("param:".$arr[2]."<br>");
        // Controller
        // print_r($arr);
        if (file_exists(CONTROLLER . $arr[0] . ".php")) {
            $this->controller = $arr[0];
            
            unset($arr[0]);
        }
        require_once CONTROLLER . $this->controller . ".php";
        $this->controller = new $this->controller;

        // Action
        if (isset($arr[1])) {
            if (method_exists($this->controller, $arr[1])) {
                $this->action = $arr[1];
            }
            unset($arr[1]);
        }
        // print_r($arr);
        // Params
        $this->params = $arr ? array_values($arr) : [];
        // print_r($this->params);
        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    function UrlProcess()
    {
        if (isset($_GET["url"])) {
            return explode("/", filter_var(trim($_GET["url"], "/")));
        }
    }
    #
    // function __construct()
    // {
    //     $this->preprocess();
    //     if (file_exists(CONTROLLER . $this->controller . ".php")) {
    //         $ctl = new $this->controller;
    //         if (method_exists($ctl, $this->action)) {
    //             call_user_func_array([$ctl, $this->action], $this->params);
    //         }
    //     }
    // }

    // public function preprocess()
    // {
    //     if (isset($_GET["url"])) {
    //         $request = trim($_GET["url"], "/");
    //         if (!empty($request)) {
    //             $url = explode("/", $request);
    //             $temp = ucfirst(strtolower(array_shift($url)));
    //             $this->directory = $temp;
    //             $this->controller = isset($temp) ? $temp . "Controller" : "Home";
    //             $this->action = isset($url[0]) ? strtolower(array_shift($url)) : "index";
    //             $this->params = $url;
    //             print_r($url);
    //         }
    //     }
    // }
}
