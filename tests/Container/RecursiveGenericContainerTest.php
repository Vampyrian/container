<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Vampyrian\Container\Container\GenericContainer;

class RecursiveGenericContainerTest extends TestCase
{
    public function testRecursive(): void
    {
        $container = new GenericContainer();
        $d = $container->get(ClassD::class);
        $this->assertInstanceOf(ClassD::class, $d);
    }
}

class ClassC {}

class ClassD
{
    public function __construct(public ClassC $c) {
    }
}