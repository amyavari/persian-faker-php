<?php

declare(strict_types=1);

namespace Tests;

use Mockery;
use PHPUnit\Framework\TestCase as BaseTestCase;
use ReflectionMethod;

abstract class TestCase extends BaseTestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    protected function callProtectedMethod(object $obj, string $method, array $args = []): mixed
    {
        $reflectedMethod = new ReflectionMethod($obj, $method);

        return $reflectedMethod->invoke($obj, ...$args);
    }
}
