<?php

declare(strict_types=1);

namespace Vampyrian\Container\Container;

use Vampyrian\Container\Interfaces\ContainerInterface;

class GenericContainer implements ContainerInterface
{
    /** @var array<class-string, callable(): object> */
    private array $registeredClasses = [];

    /**
     * @template T of object
     * @param class-string<T> $className
     * @param callable(): T $callback
     * @return $this
     */
    public function register(string $className, callable $callback): ContainerInterface
    {
        $this->registeredClasses[$className] = $callback;
        return $this;
    }

    /**
     * @template T of object
     * @param class-string<T> $className
     * @return T
     */
    public function get(string $className): object
    {
        $callback = $this->registeredClasses[$className] ?? $this->autowire(...);
        return $callback($className);
    }

    /**
     * @template T of object
     * @param class-string<T> $className
     * @return T
     */
    private function autowire(string $className): object
    {
        return new $className();

    }
}