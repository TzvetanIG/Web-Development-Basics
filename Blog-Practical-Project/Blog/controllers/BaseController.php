<?php
namespace Controllers;

use GFramework\App;
use GFramework\InputData;
use GFramework\Validation;
use GFramework\View;
use GFramework\Sessions\iSession;
use GFramework\Config;

abstract class  BaseController {
    /**
     * @var \GFramework\App
     */
    protected  $app;
    /**
     * @var View
     */
    protected $view;
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var \GFramework\InputData
     */
    protected $input;
    /**
     * @var iSession
     */
    protected $session;

    function __construct() {
        $this->app = App::getInstance();
        $this->view = View::getInstance();
        $this->config = $this->app->getConfig();
        $this->session = $this->app->getSession();
        $this->input = InputData::getInstance();

        $this->view->appendLayout('startPage', 'htmlParts.startHTML');
        $this->view->appendLayout('endPage', 'htmlParts.endHTML');
        $this->view->appendLayout('header', 'htmlParts.header');
        $this->view->appendLayout('errors', 'htmlParts.errorsMessages');
        $this->view->appendLayout('menu', 'htmlParts.menu');
        $this->view->appendLayout('categories', 'htmlParts.categories');
    }

    protected function redirect($url) {
        if($url){
            header("Location: $url");
            die;
        } else {
            //TODO
            throw new \Exception('Invalid url', 500);
        }
    }

    protected function redirectWhenUserIsNotLogged($url) {
        if(!$this->session->username){
            if($url){
                header("Location: $url");
                die;
            } else {
                //TODO
                throw new \Exception('Invalid url', 500);
            }
        }
    }

    protected function redirectWhenUserIsLogged($url) {
        if($this->session->username){
            if($url){
                header("Location: $url");
                die;
            } else {
                //TODO
                throw new \Exception('Invalid url', 500);
            }
        }
    }
} 