<?php

declare(strict_types=1);

namespace Vampyrian\Container\Interfaces;

interface ContainerInterface
{
    /**
     * @template T of object
     * @param class-string<T> $className
     * @param callable(): T $callback
     * @return $this
     */
    public function register(string $className, callable $callback): self;

    /**
     * @template T of object
     * @param class-string<T> $className
     * @param callable(): T $callback
     * @return $this
     */
    public function singleton(string $className, callable $callback): self;

    /**
     * @template T of object
     * @param class-string<T> $className
     * @return T
     */
    public function get(string $className): object;

}