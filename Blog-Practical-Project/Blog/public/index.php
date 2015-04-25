<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include '../../Framework/App.php';
$app = GFramework\App::getInstance();
$app->run();

var_dump($app->getDbConnection());