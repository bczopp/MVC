<?php
namespace Tornado;

use Tornado\Http\Request;
use Tornado\Service\Container;
use Tornado\Service\Router;

class App
{
    public function __construct(
        private Container $container,
        private Router $router
    ) {}

    /**
     * @param Request $request
     * @return void
     * @throws \Exception
     */
    public function run(Request $request): void
    {
        if (!$this->router->match($request)) {
            throw new \Exception("route {$request->getUriPath()} not found", 404);
        }

        $info = $this->router->getInfo();
        $request->setRouteInfo($info);

        if(!is_null($info['security'] ?? null)){
            // TODO implement security
        }

        [$controllerClass, $action] = $info['handler'];
        $controller = $this->container->get($controllerClass);

        $response = call_user_func_array(
            [$controller, $action],
            [$request]
        );

        $response->send();
    }
}
