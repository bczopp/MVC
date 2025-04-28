<?php

namespace Tornado\Http;

class Request
{
    private array $get;
    private array $post;
    private array $server;
    private array $cookies;
    private array $files;

    private string $uriPath;

    private array $routeInfo;

    public function __construct(
    )
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
        $this->cookies = $_COOKIE;
        $this->files = $_FILES;
        $this->uriPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->server['REQUEST_URI'] ?? '/';
    }

    /**
     * @return string
     */
    public function getUriPath(): string
    {
        return $this->uriPath;
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->get;
    }

    /**
     * @return array
     */
    public function getParsedBody(): array
    {
        return $this->post;
    }

    /**
     * @return array
     */
    public function getCookies(): array
    {
        return $this->cookies;
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @return array
     */
    public function getRouteInfo(): array
    {
        return $this->routeInfo;
    }

    /**
     * @param array $routeInfo
     * @return void
     */
    public function setRouteInfo(array $routeInfo): void
    {
        $this->routeInfo = $routeInfo;
    }

}