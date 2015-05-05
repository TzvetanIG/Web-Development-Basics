<?php
namespace GFramework;

final class Loader
{
    private static $namespaces = array();

    private function __construct()
    {
    }

    public static function registerAutoLoader() {
        spl_autoload_register(array('\GFramework\Loader', 'autoload'));
    }

    public static function  autoload($class) {
        self::loadClass($class);
    }

    public static function loadClass($class) {
        foreach(self::$namespaces as $key => $value){
            if(strpos($class, $key) === 0){
                $file = str_replace('\\', DIRECTORY_SEPARATOR, $class);
                $file = substr_replace($file, $value, 0, strlen($key)) . '.php';
                $fileName = realpath($file);
                if($fileName && is_readable($fileName)){
                    include $file;
                } else {
                    throw new \Exception('File not be included: ' . $file);
                }

                break;
            }
        }
    }

    public static function registerNamespace($namespace, $path) {
        $namespace = trim($namespace);
        if(strlen($namespace) > 0){
            if(!$path){
                throw new \Exception( 'Invalid path.');
            }

            $realPath = realpath($path);
            if($realPath && is_dir($realPath) && is_readable($realPath)){
                self::$namespaces[$namespace . '\\'] = $realPath . DIRECTORY_SEPARATOR;
            }
        } else {
            throw new \Exception('Invalid namespace: ' . $namespace .'.');
        }
    }

    public static function registerNamespaces($namespaces) {
        if(is_array($namespaces)){
            foreach ($namespaces as $key => $value) {
                self::registerNamespace($key, $value);
            }
        } else {
            throw new \Exception('Invalid namespaces');
        }
    }



    public static function getNamespaces() {
        return self::$namespaces;
    }

    public static function removeNamespace($namespace) {
        unset(self::$namespaces[$namespace]);
    }
}