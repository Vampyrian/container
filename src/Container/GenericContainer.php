<?php

declare(strict_types=1);

namespace Vampyrian\Container\Container;

use Vampyrian\Container\Interfaces\ContainerInterface;

class GenericContainer implements ContainerInterface
{
    private array $registeredClasses = [];

    /**
     * @param string $className
     * @param callable $callback
     * @return ContainerInterface
     */
    public function register(string $className, callable $callback): ContainerInterface
    {
        $this->registeredClasses[$className] = $callback;
        return $this;
    }

    /**
     * @template TClassName
     * @param class-string<TClassName> $className
     * @return TClassName
     */
    public function get(string $className): object
    {
        $callback = $this->registeredClasses[$className];
        return $callback();
    }
}