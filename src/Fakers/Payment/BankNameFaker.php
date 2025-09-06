<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Payment;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * @internal
 *
 * Generates a random bank name in Iran.
 *
 * @extends SimplePicker<int, string>
 *
 * @implements FakerInterface<string>
 */
final class BankNameFaker extends SimplePicker implements FakerInterface
{
    /**
     * This returns a fake company name
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
