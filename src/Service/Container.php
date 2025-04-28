<?php
namespace Tornado\Service;

class Container
{
    private array $definitions = [];
    private array $instances   = [];

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
        if (!isset($this->instances[$id])) {
            if (!isset($this->definitions[$id])) {
                throw new \Exception("Service $id not defined");
            }
            $this->instances[$id] = ($this->definitions[$id])($this);
        }
        return $this->instances[$id];
    }
}
