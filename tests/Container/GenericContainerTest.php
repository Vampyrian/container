<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Vampyrian\Container\Container\GenericContainer;

class GenericContainerTest extends TestCase
{
    public function testContainerRegistration(): void
    {
        $container = new GenericContainer();
        $container->register(ClassA::class, fn () => new ClassA());

        $class = $container->get(ClassA::class);
        $this->assertInstanceOf(ClassA::class, $class);
    }

    public function testAutowire(): void
    {
        $container = new GenericContainer();

        $class = $container->get(ClassA::class);
        $this->assertInstanceOf(ClassA::class, $class);
    }
}

class ClassA {}