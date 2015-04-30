<?php
namespace Controllers;

use GFramework\App;
use GFramework\Validation;
use GFramework\ValidationRules;
use GFramework\View;
use Models\Repositories\Data;

class Index extends BaseController {
    public function index(){
        $categories = Data::categories()->all();
        $data = array(
            'categories' => $categories,
            'grade' => 'all'
        );

        $this->view->display('layouts.index', $data);
    }
} 