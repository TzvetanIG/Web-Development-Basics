<?php
$cnf['admin']['namespace'] = 'Controllers';


$cnf['administration']['namespace'] = 'Controllers\Admin';
$cnf['administration']['controllers']['user']['newName'] = 'users';
$cnf['administration']['controllers']['user']['methods']['delete'] = 'deleteById';

$cnf['administration']['controllers']['index']['methods']['delete'] = 'deleteById';

$cnf['administration']['controllers']['new']['newName'] = 'create';

$cnf['*']['controllers']['index']['methods']['delete'] = 'deleteById';

$cnf['*']['namespace'] = 'Controllers';

return $cnf;