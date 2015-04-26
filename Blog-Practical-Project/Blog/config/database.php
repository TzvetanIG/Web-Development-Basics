<?php
$cnf['default']['connection_uri'] = 'mysql:host=localhost;dbname=world';
$cnf['default']['username'] = "root";
$cnf['default']['password'] = "";
$cnf['default']['pdo_options'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES 'UTF8'";
$cnf['default']['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

$cnf['session']['connection_uri'] = 'mysql:host=localhost;dbname=session_db';
$cnf['session']['username'] = 'root';
$cnf['session']['password'] = '';
$cnf['session']['pdo_options'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES 'UTF8'";
$cnf['session']['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

return $cnf;