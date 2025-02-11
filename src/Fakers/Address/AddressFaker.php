<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Address;

use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * Generates a random full address in Iran
 *
 * @extends \AliYavari\PersianFaker\Fakers\SimplePicker<int, string>
 */
class AddressFaker extends SimplePicker
{
    /**
     * This returns a fake full address
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
