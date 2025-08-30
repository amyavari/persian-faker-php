<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Address;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * @internal
 *
 * Generates a random full address in Iran
 *
 * @extends  SimplePicker<int, string>
 *
 * @implements FakerInterface<string>
 */
final class AddressFaker extends SimplePicker implements FakerInterface
{
    /**
     * This returns a fake full address
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
