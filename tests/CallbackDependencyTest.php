<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Vampyrian\Container\Container\GenericContainer;
use Vampyrian\Container\Interfaces\ContainerInterface;

class CallbackDependencyTest extends TestCase
{
    public function testRegisterCallbackReceivesContainer(): void
    {
        $container = GenericContainer::getInstance();
        $container->register(ClassD::class, fn (ContainerInterface $c) => new ClassD($c->get(ClassC::class)));

        $this->assertInstanceOf(ClassC::class, $container->get(ClassD::class)->c);
    }

    public function testSingletonCallbackReceivesContainer(): void
    {
        $container = GenericContainer::getInstance();
        $container->singleton(ClassE::class, fn (ContainerInterface $c) => new ClassE($c));

        $this->assertSame($container, $container->get(ClassE::class)->container);
    }
}

class ClassE
{
    public function __construct(public ContainerInterface $container) {}
}
