<?php
namespace Tornado\Service;

use Tornado\Http\Request;

class Router
{
    private array $routes;
    private ?array $info = null;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function match(Request $request): bool
    {
        $path = $request->getUriPath();
        $method = $request->getMethod();

        foreach ($this->routes as $route => $info) {
            // replace {parameter} by Named Capture Group (?P<parameter>...)
            $routePattern = preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $route);
            $routeRegex = '#^' . $routePattern . '$#';

            if (preg_match($routeRegex, $path, $matches) && in_array($method, $info['httpMethod'], true)) {
                // extract only named matches
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $this->info = [
                        'route' => $route,
                        'uri_params' => $params
                    ] + $info;

                return true;
            }
        }
        return false;
    }

    /**
     * @return array|null
     */
    public function getInfo(): ?array
    {
        $info = $this->info;
        $this->info = null;
        return $info;
    }
}
