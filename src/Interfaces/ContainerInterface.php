<?php

declare(strict_types=1);

namespace Vampyrian\Container\Interfaces;

interface ContainerInterface
{
    public function register(string $className, callable $callback): self;

    public function get(string $className): object;


}