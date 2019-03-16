<?php

defined('APPLICATION_PATH') || define('APPLICATION_PATH',realpath(dirname(__FILE__) . '/../app'));
const DS = DIRECTORY_SEPARATOR;

#config php file
require APPLICATION_PATH . DS . 'config' . DS . 'config.php';

#library function
$page = get('page', 'index'); //if page not available, go to home
#loading home php from MODEL (absolute file)
$data = $config['DATA_PATH'] . $page . '.php';
#for view
$view = $config['VIEW_PATH'] . $page . '.phtml';

if(file_exists($data)){
    include $data;
}

if (file_exists($view)){
    include $view;
}

