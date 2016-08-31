<?php

function __autoload($class_name){
    $path = strtolower($class_name).'.php';

    if(file_exists($path)) {
        require_once($path);
    } else {
        throw new Exception('Failed to include class: '.$class_name);
    }
}

$obj = new Faq();
