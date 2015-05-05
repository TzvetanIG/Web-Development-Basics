<?php

namespace GFramework;
class Config
{
    private static $instance = null;
    private $configFolder = null;
    private $configArray = array();

    private function __construct()
    {
    }

    /**
     * @return \GFramework\Config
     */
    public static function getInstance()
    {
        if(self::$instance == null){
            self::$instance = new \GFramework\Config();
        }

        return self::$instance;
    }

    public function getConfigFolder(){
        return $this->configFolder;
    }

    public function setConfigFolder($configFolder) {
        if(!$configFolder){
            throw new \Exception('Empty config folder path');
        }

        $validPath = realpath($configFolder);
        if($validPath != false && is_dir($validPath) && is_readable($validPath)){
            $this->configArray = array();
            $this->configFolder = $validPath . DIRECTORY_SEPARATOR;

            $namespaces = $this->app['namespaces'];
            if(is_array($namespaces)){
                Loader::registerNamespaces($namespaces);
            }
        } else {
            throw new \Exception('Config directory read error: ' . $configFolder);
        }
    }

    private function includeConfigFile($path) {
        if(!$path) {
            throw new \Exception;
        }

        $file = realpath($path);
        if($file != false && is_file($file) && is_readable($file)){
            $basename = explode('.php', basename($file))[0];
            $this->configArray[$basename] = include $file;
        } else {
            throw new \Exception('Config file read error: ' . $path );
        }
    }

    public function __get($name) {
        if(!$this->configArray[$name]){
            $this->includeConfigFile($this->configFolder . $name . '.php');
        }

        if(array_key_exists($name, $this->configArray)){
            return $this->configArray[$name];
        }

        return null;
    }
} 