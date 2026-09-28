<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Vampyrian\Container\Container\GenericContainer;

class SimpleGenericContainerTest extends TestCase
{
    public function testContainerRegistration(): void
    {
        $container = new GenericContainer();
        $container->register(ClassC::class, fn () => new ClassC());

        $class = $container->get(ClassC::class);
        $this->assertInstanceOf(ClassC::class, $class);
    }

    public function testAutowire(): void
    {
        $container = new GenericContainer();

        $class = $container->get(ClassC::class);
        $this->assertInstanceOf(ClassC::class, $class);
    }
}

class ClassA {}