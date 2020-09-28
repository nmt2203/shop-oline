<?php
// session_start();
class View
{
    protected $file = "";
    protected $data = "";

    public function __construct($viewName, $data)
    {
        $this->file = $viewName;
        $this->data = $data;
    }

    public function render() {
        if (file_exists(VIEW . $this->file)) {
            require_once VIEW . $this->file;
        }
        else {
            require_once VIEW."error.php";
        }
    }

}