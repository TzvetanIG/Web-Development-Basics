<?php
namespace GFramework\Sessions;

interface iSession {
    public function getSessionId();
    public  function saveSession();
    public function destroySession();
    public function unsetSessionProperty($key);
    public function __get($name);
    public function __set($name, $value);
    public function hasSessionProperty($key);
}