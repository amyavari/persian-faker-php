<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Address;

use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * Generates a random state name in Iran
 *
 * @extends \AliYavari\PersianFaker\Fakers\SimplePicker<int, string>
 */
class StateFaker extends SimplePicker
{
    /**
     * This returns a fake state name
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
