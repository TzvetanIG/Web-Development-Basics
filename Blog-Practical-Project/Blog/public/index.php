<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include '../../Framework/App.php';
$app = GFramework\App::getInstance();
$app->run();





