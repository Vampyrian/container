<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Vampyrian\Container\Container\GenericContainer;

class SingletonTest extends TestCase
{
    public function testSingleton()
    {
        $container = GenericContainer::getInstance();
        $container->singleton(Singleton::class, fn() => new Singleton());

        $container->get(Singleton::class);
        $this->assertEquals(1, Singleton::$count);

        $container->get(Singleton::class);
        $this->assertEquals(1, Singleton::$count);
    }

}

class Singleton
{
    public static $count = 0;

    public function __construct()
    {
        self::$count++;
    }
}