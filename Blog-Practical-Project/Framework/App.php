<?php

namespace GFramework;

use GFramework\Routers\DefaultRouter;
use \GFramework\Routers\iRouter;
use GFramework\Sessions\DbSession;
use GFramework\Sessions\iSession;
use GFramework\Sessions\NativeSession;

include 'Loader.php';

class App
{
    private static $instance = null;
    /**
     * @var Config
     */
    private $config = null;
    /**
     * @var FrontController
     */
    private $frontController = null;
    /**
     * @var iRouter
     */
    private $router = null;
    private $dbConnections = array();
    /**
     * @var iSession
     */
    private $session = null;

    private function __construct()
    {
        set_exception_handler(array($this, 'exceptionHandler'));
        Loader::registerNamespace('GFramework', dirname(__FILE__) . DIRECTORY_SEPARATOR);
        Loader::registerAutoLoader();
        $this->config = Config::getInstance();

        if ($this->getConfigFolder() == null) {
            $this->setConfigFolder('../config');
        }

    }

    public function setConfigFolder($path)
    {
        $this->config->setConfigFolder($path);
    }

    public function getConfigFolder()
    {
        return $this->config->getConfigFolder();
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    public function run()
    {
        $this->frontController = FrontController::getInstance();
        if ($this->router instanceof iRouter) {
            $this->frontController->setRouter($this->router);
        } else if ($this->router == 'JsonRPCRouter') {
            //TODO
            $this->frontController->setRouter(new DefaultRouter());
        } else if ($this->router == 'CLIRouter') {
            //TODO
        } else {
            $this->frontController->setRouter(new DefaultRouter());
        }

        $session = $this->config->app['session'];
        if ($session['autostart']) {
            switch ($session['type']) {
                case 'native':
                    $s = new NativeSession($session['name'], $session['lifetime'], $session['path'],
                        $session['domain'], $session['secure']);
                    break;
                case 'database':
                    $s = new DbSession($session['dbConnection'], $session['name'], $session['dbTable'],
                        $session['lifetime'], $session['path'], $session['domain'], $session['secure']);
                    break;
                default:
                     throw new \Exception('No valid session', 500);
                    break;
            }

            $this->setSession($s);
        }


        $this->frontController->dispatch();
    }

    public function  setSession(iSession $session)
    {
        $this->session = $session;
    }

    /**
     * @return iSession
     */
    public function getSession()
    {
        return $this->session;
    }

    public function getDbConnection($connection = 'default')
    {
        if (!$connection) {
            throw new \Exception('No connection identifier provided', 500);
        }

        if ($this->dbConnections[$connection]) {
            return $this->dbConnections[$connection];
        }

        $config = $this->getConfig()->database[$connection];
        if (!$config) {
            throw new \Exception('No valid connection identificator is provided', 500);
        }

        $dbh = new \PDO($config['connection_uri'], $config['username'], $config['password'], $config['pdo_options']);
        $this->dbConnections[$connection] = $dbh;

        return $dbh;
    }

    /**
     * @return App
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new App();
        }

        return self::$instance;
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function setRouter($router)
    {
        $this->router = $router;
    }

    public  function exceptionHandler(\Exception $ex){
        if($this->config && $this->config->app['displayException'] == true){
            echo '<pre>' . print_r($ex, true) . '</pre>';
        } else {
            $this->displayError($ex->getCode());
        }
    }


    private function displayError($errorCode)
    {
        try{
            $view = \GFramework\View::getInstance();
            $view->display($this->config->app['errorView'] , array($errorCode));
        } catch (\Exception $ex) {
            Common::headerStatus($errorCode);
            echo "<h1> $errorCode </h1>";
            exit;
        }
    }

    public function __destruct()
    {
        if($this->session != null){
            $this->session->saveSession();
        }
    }
}