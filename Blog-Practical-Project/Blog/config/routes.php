<?php
//$cnf['administration']['namespace'] = 'Controllers\Admin';
//$cnf['administration']['controllers']['user']['newName'] = 'users';
//$cnf['administration']['controllers']['user']['methods']['delete'] = 'deleteById';
//$cnf['administration']['controllers']['index']['methods']['delete'] = 'deleteById';
//$cnf['administration']['controllers']['new']['newName'] = 'create';
//$cnf['*']['controllers']['index']['methods']['delete'] = 'deleteById';

$cnf['*']['controllers']['user']['newName'] = 'users';

$cnf['*']['controllers']['problems']['methods']['all'] = 'category';
$cnf['*']['controllers']['problems']['methods']['toggle-visibility'] = 'toggleVisibility';

$cnf['*']['namespace'] = 'Controllers';

return $cnf;