<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Vampyrian\Container\Container\GenericContainer;

class GenericContainerTest extends TestCase
{
    public function testContainer(): void
    {
        $container = new GenericContainer();
        $container->register(ClassA::class, fn () => new ClassA());

        $class = $container->get(ClassA::class);
        $this->assertInstanceOf(ClassA::class, $class);
    }
}

class ClassA {}