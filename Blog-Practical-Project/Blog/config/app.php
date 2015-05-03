<?php
$cnf['default_controller'] =  'Index';
$cnf['default_method'] =  'index';
$cnf['namespaces']['Controllers'] = 'D:\SoftUni\Web-Development-Basics\Blog-Practical-Project\Blog\controllers';
$cnf['namespaces']['Models'] = 'D:\SoftUni\Web-Development-Basics\Blog-Practical-Project\Blog\models';
$cnf['namespaces']['Constants'] = 'D:\SoftUni\Web-Development-Basics\Blog-Practical-Project\Blog\constants';
$cnf['namespaces']['Views'] = 'D:\SoftUni\Web-Development-Basics\Blog-Practical-Project\Blog\views';

$cnf['viewsDirectory'] = 'D:\SoftUni\Web-Development-Basics\Blog-Practical-Project\Blog\views';

$cnf['session']['autostart'] = true;
$cnf['session']['type'] = 'native'; //native, database
$cnf['session']['name'] = '_sess';
$cnf['session']['lifetime'] = 3600;
$cnf['session']['path'] = '/';
$cnf['session']['domain'] = '';
$cnf['session']['secure'] = false;
$cnf['session']['dbConnection'] = 'session';
$cnf['session']['dbTable'] = 'sessions';

$cnf['pageSize'] = 5;

return $cnf;