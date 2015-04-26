<?php
namespace GFramework;

use GFramework\Routers\iRouter;

class FrontController
{
    private static $instance = null;
    private $namespace = null;
    private $controller = null;
    private $method = null;
    private $params = array();
    private $router = null;

    private function __construct()
    {
    }

    /**
     * @return \GFramework\FrontController
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new FrontController();
        }

        return self::$instance;
    }

    public function dispatch()
    {
        $router = $this->getRouter();
        $uri = $router->getUri();
        $routesConfig = App::getInstance()->getConfig()->routes;
        $packegeConfig = null;
        if (is_array($routesConfig) && count($routesConfig) > 0) {
            foreach ($routesConfig as $packege => $content) {
                if (($uri == $packege || stripos($uri, $packege . '/') === 0) && $content['namespace']) {
                    $this->namespace = $content['namespace'];
                    $uri = substr($uri, strlen($packege) + 1);
                    $packegeConfig = $content;
                    break;
                }
            }
        } else {
            //TODO
            throw new \Exception('Default route missing', 500);
        }

        if ($this->namespace == null && $routesConfig['*']['namespace']) {
            $this->namespace = $routesConfig['*']['namespace'];
            $packegeConfig = $routesConfig['*'];
        } else if ($this->namespace == null && !$routesConfig['*']['namespace']) {
            //TODO
            throw new \Exception('Default route missing', 500);
        }

        $params = explode('/', $uri);
        if ($params[0]) {
            $this->controller = strtolower($params[0]);
            if ($params[1]) {
                $this->method = strtolower($params[1]);
                unset($params[0], $params[1]);
                $this->params = array_values($params);
            } else {
                $this->method = $this->getDefaultMethod();
            }
        } else {
            $this->controller = $this->getDefaultController();
            $this->method = $this->getDefaultMethod();
        }

        if ($packegeConfig['controllers'] && is_array($packegeConfig['controllers'])) {
            $controller = $packegeConfig['controllers'][$this->controller];
            if ($controller['methods'][$this->method]) {
                $this->method = strtolower($controller['methods'][$this->method]);
            }
            if (isset($packegeConfig['controllers'][$this->controller]['newName'])) {
                $this->controller = strtolower($controller['newName']);
            }
        }

        $this->controller = ucfirst($this->controller);
        $controllerFile = "{$this->namespace}\\{$this->controller}";
//        echo $this->namespace . '<br>' . $this->controller . '<br>' . $this->method;
        //TODO
        $controllerObj = new $controllerFile();
        $controllerObj->{$this->method}();
    }

    public function getDefaultController()
    {
        $controller = App::getInstance()->getConfig()->app['default_controller'];
        if ($controller) {
            return strtolower($controller);
        }

        return 'index';
    }

    public function getDefaultMethod()
    {
        $method = App::getInstance()->getConfig()->app['default_method'];
        if ($method) {
            return strtolower($method);
        }

        return 'index';
    }

    /**
     * @return iRouter
     */
    public function getRouter()
    {
        return $this->router;
    }

    public function setRouter(iRouter $router)
    {
        $this->router = $router;
    }
} 