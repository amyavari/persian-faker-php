<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Address;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * @internal
 *
 * Generates a random city name in Iran
 *
 * @extends SimplePicker<int, string>
 *
 * @implements FakerInterface<string>
 */
final class CityFaker extends SimplePicker implements FakerInterface
{
    /**
     * This returns a fake city name
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
