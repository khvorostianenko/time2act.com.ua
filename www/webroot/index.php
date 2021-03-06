<?php

define('DS', DIRECTORY_SEPARATOR);

// dirname возвращает имя родительского каталога
define('ROOT', dirname(dirname(__FILE__)));

// var_dump(ROOT) - string(16) "D:\xampp\mvc\www"
define('VIEWS_PATH', ROOT.DS.'views');

require_once ROOT.DS.'vendor'.DS.'autoload.php';

require_once (ROOT.DS.'lib'.DS.'init.php');

session_start();

try{
    App::run($_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    echo $e->getMessage();
}

