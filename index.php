<?php
include 'vendor/autoload.php';
include 'helper.php';
$sysconfig = include 'config.php';

if (!isset($_GET['method']) || !isset($_GET['controller'])) {
    header("HTTP/1.0 404 Not Found");
    exit('no params');
}

$method = $_GET['method'];
$controller = $_GET['controller'];

$className = '\\DevManage\\Controller\\' . ucwords($controller);
if (!class_exists($className)) {
    header("HTTP/1.0 404 Not Found");
    exit('no class');
}


$class = new $className();

if (!method_exists($class, $method)) {
    header("HTTP/1.0 404 Not Found");
    exit('no method');
}

call_user_func([$class, $method]);