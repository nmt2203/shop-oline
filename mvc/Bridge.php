<?php
define("ROOT", dirname(__DIR__) . DIRECTORY_SEPARATOR);
define("MVC", ROOT . "mvc" . DIRECTORY_SEPARATOR);
define("CONFIG", MVC . "config" . DIRECTORY_SEPARATOR);
define("CONTROLLER", MVC . "controller" . DIRECTORY_SEPARATOR);
define("CORE", MVC . "core" . DIRECTORY_SEPARATOR);
define("MODEL", MVC . "model" . DIRECTORY_SEPARATOR);
define("VIEW", MVC . "view" . DIRECTORY_SEPARATOR);
define("ADMIN", VIEW . "admin" . DIRECTORY_SEPARATOR);
define("CUSTOMER", VIEW . "customer" . DIRECTORY_SEPARATOR);
define("PUBLICS", ROOT . "public" . DIRECTORY_SEPARATOR);
define("CSS", PUBLICS . "css" . DIRECTORY_SEPARATOR);
define("JS", PUBLICS . "js" . DIRECTORY_SEPARATOR);
define("UPLOADS", PUBLICS . "uploads" . DIRECTORY_SEPARATOR);

$module = [MODEL, VIEW, CONTROLLER, CORE];
set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $module));
spl_autoload_register("spl_autoload", false);
// Process URL from browser
require_once CORE . "App.php";
// How controllers call Views & Models
require_once CORE . "Controller.php";
require_once CORE . "View.php";
