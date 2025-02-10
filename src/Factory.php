<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker;

use AliYavari\PersianFaker\Contracts\GeneratorInterface;

/**
 * This class initiates and returns an instance of this package.
 *
 * @method static \AliYavari\PersianFaker\Generator create() Initiates and returns an instance of Persian Faker package.
 */
class Factory
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
