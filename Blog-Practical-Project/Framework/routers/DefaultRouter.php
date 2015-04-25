<?php
namespace GFramework\Routers;

use GFramework\Routers\iRouter;

class DefaultRouter implements iRouter
{
    private $controller = null;
    private $method = null;
    private $params = array();

    public function getUri() {
        $uri = substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1);
        return $uri;
    }
}