<?php
namespace Tornado\Service;

class Container
{
    private array $definitions = [];

    public function __construct(array $serviceRegistration)
    {
        foreach($serviceRegistration as $registration) {
            $registration($this);
        }
    }

    /**
     * @param string $id
     * @param callable $factory
     * @return void
     */
    public function set(string $id, callable $factory): void
    {
        $this->definitions[$id] = $factory;
    }

    /**
     * @param string $id
     * @return object
     * @throws \Exception
     */
    public function get(string $id): object
    {
        //UPDATE: to not work with sigletons by design of this conteainer, instances are just created on the fly.
        if (!isset($this->definitions[$id])) {
            throw new \Exception("Service $id not defined");
        }
        return ($this->definitions[$id])($this);
    }
}
