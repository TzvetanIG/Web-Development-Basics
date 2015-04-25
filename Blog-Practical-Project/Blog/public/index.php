<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include '../../Framework/App.php';
$app = GFramework\App::getInstance();
$app->run();

$app->getSession()->counter += 1;
echo $app->getSession()->counter;
echo session_name();



