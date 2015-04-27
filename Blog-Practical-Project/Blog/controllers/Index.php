<?php
namespace Controllers;

use GFramework\App;
use GFramework\Validation;
use GFramework\ValidationRules;
use GFramework\View;

class Index extends BaseController {
    public function index(){
        $this->view->display('layouts.index');
    }
} 