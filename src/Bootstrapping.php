<?php
namespace Tornado;

use Tornado\Service\Container;
use Tornado\Service\Router;

final class Bootstrapping
{
    private const CONFIG_DIR = __DIR__ . '/../config/';

    /**
     * @return App
     */
    public function init(): App
    {
        return new App($this->createContainer(), $this->createRouter());
    }

    /**
     * @return Router
     */
    private function createRouter(): Router
    {
        return new Router(require self::CONFIG_DIR . 'routes.php');
    }

    /**
     * @return Container
     */
    private function createContainer(): Container
    {
        return new Container(require self::CONFIG_DIR . 'services.php');
    }
}