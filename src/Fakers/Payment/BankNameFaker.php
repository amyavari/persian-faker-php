<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Payment;

use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * Generates a random bank name in Iran.
 *
 * @extends \AliYavari\PersianFaker\Fakers\SimplePicker<int, string>
 */
class BankNameFaker extends SimplePicker
{
    /**
     * This returns a fake company name
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
