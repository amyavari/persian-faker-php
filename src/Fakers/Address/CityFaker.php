<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Address;

use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * Generates a random city name in Iran
 *
 * @extends \AliYavari\PersianFaker\Fakers\SimplePicker<int, string>
 */
class CityFaker extends SimplePicker
{
    /**
     * This returns a fake city name
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
