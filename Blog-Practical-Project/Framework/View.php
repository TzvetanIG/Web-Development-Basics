<?php

namespace GFramework;


class View
{
    private static $instance = null;
    private $___viewPath = null;
    private $___viewDir = null;
    private $___data = array();
    private $___extension = '.php';

    private function __construct()
    {
        $this->___viewPath = App::getInstance()->getConfig()->app['viewsDirectory'];
        if ($this->___viewPath == null) {
            $this->___viewPath = realpath('../views');
        }
    }

    /**
     * @return \GFramework\View
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new View();
        }

        return self::$instance;
    }

    public function setViewDirectory($path)
    {
        $path = trim($path);
        if ($path) {
            $path = realpath($path) . DIRECTORY_SEPARATOR;
            if (is_dir($path) && is_readable($path)) {
                $this->___viewDir = $path;
            } else {
                //todo
                throw new \Exception('Invalid view path', 500);
            }
        } else {
            //todo
            throw new \Exception('Invalid view path', 500);
        }
    }

    public function __get($name)
    {
        return $this->___data[$name];
    }

    public function __set($name, $value)
    {
        $this->___data[$name] = $value;
    }

    public function display($name, $data = array(), $returnAsString = false)
    {
        if (is_array($data)) {
            $this->___data = array_merge($this->___data, $data);
        }

        if ($returnAsString) {
            return $this->includeFile($name);
        } else {
            echo $this->includeFile($name);
        }
    }

    private function includeFile($file) {
        if($this->___viewDir == null){
            $this->setViewDirectory($this->___viewPath);
        }

        $___fullFileName = $this->___viewDir . str_replace('.', DIRECTORY_SEPARATOR, $file) . $this->___extension;
        if(file_exists($___fullFileName) && is_readable($___fullFileName)){
            ob_start();
            include $___fullFileName;
            return ob_get_clean();
        } else {
            //TODO
            throw new \Exception('View ' . $file . 'cannot included', 500);
        }
    }
} 