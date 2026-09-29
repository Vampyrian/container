# Container

A small dependency injection container for PHP with autowiring and singleton support. For learning purposes only.

## Installation

```bash
composer require vampyrian/container
```

## Getting the container

The container is a process-wide singleton. Get it either through the `container()` helper or directly from the class:

```php
use Vampyrian\Container\Container\GenericContainer;
use function Vampyrian\Container\Container\container;

$container = container();
// or
$container = GenericContainer::getInstance();
```

Both return the same instance, so anything you register is visible everywhere in the process.

## Autowiring

Classes don't have to be registered. When you ask for a class the container doesn't know about, it inspects the constructor and resolves each class-typed parameter recursively:

```php
class Logger {}

class UserService
{
    public function __construct(public Logger $logger) {}
}

$service = container()->get(UserService::class);
// $service->logger is a Logger created by the container
```

Autowiring only works for constructor parameters typed with a class or interface that the container can itself resolve. Scalar parameters (`string $dsn`, `int $port`), untyped parameters and interfaces need an explicit registration.

## Registering a factory

Use `register()` to tell the container how to build a class. The callback runs on every `get()` call, so each call returns a new instance:

```php
container()->register(Mailer::class, fn () => new Mailer('smtp.example.com', 587));

$a = container()->get(Mailer::class);
$b = container()->get(Mailer::class);
// $a !== $b
```

This is also how you bind an interface to an implementation:

```php
container()->register(CacheInterface::class, fn () => new RedisCache());
```

## Registering a singleton

Use `singleton()` when the class should be created once and shared. The callback runs on the first `get()`, and later calls return the same instance:

```php
container()->singleton(Database::class, fn () => new Database('mysql:host=localhost'));

$a = container()->get(Database::class);
$b = container()->get(Database::class);
// $a === $b
```

## Resolving dependencies inside a callback

Callbacks receive the container as their argument, so you can resolve other services while building one:

```php
use Vampyrian\Container\Interfaces\ContainerInterface;

container()->singleton(UserRepository::class, fn (ContainerInterface $c) => new UserRepository(
    $c->get(Database::class),
));
```

The argument is optional; callbacks that don't need it can omit it.

## Chaining

`register()` and `singleton()` return the container, so calls can be chained:

```php
container()
    ->singleton(Database::class, fn () => new Database('mysql:host=localhost'))
    ->register(Mailer::class, fn () => new Mailer('smtp.example.com', 587));
```

## Running the tests

```bash
composer test
```
