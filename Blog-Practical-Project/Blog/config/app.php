<?php
$cnf['default_controller'] =  'Index';
$cnf['default_method'] =  'index';
$cnf['namespaces']['Controllers'] = 'D:\SoftUni\Web-Development-Basics\Blog-Practical-Project\Blog\controllers';

$cnf['session']['autostart'] = true;
$cnf['session']['type'] = 'database'; //native, database
$cnf['session']['name'] = '_sess3';
$cnf['session']['lifetime'] = 3600;
$cnf['session']['path'] = '/';
$cnf['session']['domain'] = '';
$cnf['session']['secure'] = false;
$cnf['session']['dbConnection'] = 'default';
$cnf['session']['dbTable'] = 'sessions';

return $cnf;