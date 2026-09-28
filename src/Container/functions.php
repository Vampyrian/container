<?php

declare(strict_types=1);

namespace Vampyrian\Container\Container;

use Vampyrian\Container\Interfaces\ContainerInterface;

function container(): ContainerInterface
{
    return GenericContainer::getInstance();
}
