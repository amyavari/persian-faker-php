<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Address;

use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * Generates a random street name in Iran
 *
 * @extends \AliYavari\PersianFaker\Fakers\SimplePicker<int, string>
 */
class StreetNameFaker extends SimplePicker
{
    /**
     * This returns a fake street name
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
