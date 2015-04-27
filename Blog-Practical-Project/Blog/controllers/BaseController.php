<?php
namespace Controllers;

use GFramework\App;
use GFramework\InputData;
use GFramework\View;

abstract class  BaseController {
    /**
     * @var \GFramework\App
     */
    protected  $app;
    /**
     * @var \GFramework\View
     */
    protected $view;
    /**
     * @var \GFramework\Config
     */
    protected $config;
    /**
     * @var \GFramework\InputData
     */
    protected $input;

    function __construct() {
        $this->app = App::getInstance();
        $this->view = View::getInstance();
        $this->config = $this->app->getConfig();
        $this->input = InputData::getInstance();

        $this->view->appendLayout('startPage', 'startHTML');
        $this->view->appendLayout('endPage', 'endHTML');
        $this->view->appendLayout('header', 'header');
    }
} 