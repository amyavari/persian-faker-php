<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker;

use AliYavari\PersianFaker\Contracts\GeneratorInterface;

/**
 * This class initiates and returns an instance of this package.
 */
final class Factory
{
    private function __construct() {}

    /**
     * This returns Persian Faker instance
     */
    public static function create(): GeneratorInterface
    {
        return new Generator;
    }
}
