<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 01.08.2016
 * Time: 10:21
 */
Config::set('site_name', 'Your Site Name');

Config::set('languages', array('en', 'fr'));

Config::set('routes',array(
    'default' => '',
    'admin' => 'admin_',
    'user' => 'user_'
));

Config::set('default_route', 'default');
Config::set('default_language', 'en');
Config::set('default_controller', 'pages');
Config::set('default_action', 'index');

// Локальный Миша
//Config::set('db.host', 'localhost');
//Config::set('db.user', 'mishamart2act');
//Config::set('db.password', 'd3Fuj4');
//Config::set('db.db_name', 'time2act');

// Сервер Хост Про (удаленный для меня)
Config::set('db.host', '195.191.24.196');
Config::set('db.user', 'xgnbpama_xgnbpama_mishamart');
Config::set('db.password', 'kated3Fuj4epmillionere');
Config::set('db.db_name', 'xgnbpama_time2act');

// Сервер Хост Про (локальный для Хост Про)
//Config::set('db.host', 'localhost');
//Config::set('db.user', 'xgnbpama_xgnbpama_mishamart');
//Config::set('db.password', 'kated3Fuj4epmillionere');
//Config::set('db.db_name', 'xgnbpama_time2act');


Config::set('salt','rijeeh35sda766eue');
