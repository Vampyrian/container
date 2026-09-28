<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Vampyrian\Container\Container\GenericContainer;

class SimpleGenericContainerTest extends TestCase
{
    public function testContainerRegistration(): void
    {
        $container = GenericContainer::getInstance();
        $container->register(ClassC::class, fn () => new ClassC());

        $class = $container->get(ClassC::class);
        $this->assertInstanceOf(ClassC::class, $class);
    }

    public function testAutowire(): void
    {
        $container = GenericContainer::getInstance();

        $class = $container->get(ClassC::class);
        $this->assertInstanceOf(ClassC::class, $class);
    }
}

class ClassA {}