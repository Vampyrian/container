<?php

declare(strict_types=1);

namespace Vampyrian\Container\Container;

use ReflectionClass;
use ReflectionParameter;
use Vampyrian\Container\Helpers\Singleton;
use Vampyrian\Container\Interfaces\ContainerInterface;

class GenericContainer extends Singleton implements ContainerInterface
{
    /** @var array<class-string, callable(ContainerInterface): object> */
    private array $registeredClasses = [];

    /** @var array<class-string, object> */
    private array $registeredSingletonClasses = [];

    /**
     * @template T of object
     * @param class-string<T> $className
     * @param callable(ContainerInterface): T $callback
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
     * @param callable(ContainerInterface): T $callback
     * @return $this
     */
    public function singleton(string $className, callable $callback): ContainerInterface
    {
        $this->registeredClasses[$className] = function () use ($className, $callback) {
            $instance = $callback();

            $this->registeredSingletonClasses[$className] = $instance;

            return $instance;
        };
        return $this;
    }

    /**
     * @template T of object
     * @param class-string<T> $className
     * @return T
     */
    public function get(string $className): object
    {
        if ($instance = $this->registeredSingletonClasses[$className] ?? null) {
            return $instance;
        }

        if ($callback = $this->registeredClasses[$className] ?? null) {
            return $callback();
        }

        return $this->autowire($className);
    }

    /**
     * @template T of object
     * @param class-string<T> $className
     * @return T
     */
    private function autowire(string $className): object
    {
        $reflection = new ReflectionClass($className);
        $parameters = array_map(
            fn(ReflectionParameter $parameter) => $this->get($parameter->getType()->getName()),
            $reflection->getConstructor()?->getParameters() ?? []
        );

        return new $className(...$parameters);
    }
}