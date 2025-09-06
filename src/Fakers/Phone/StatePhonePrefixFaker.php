<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Phone;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * @internal
 *
 * Generates a random state phone prefix in Iran.
 *
 * @extends SimplePicker<string, string>
 *
 * @implements FakerInterface<string>
 */
final class StatePhonePrefixFaker extends SimplePicker implements FakerInterface
{
    /**
     * This returns a fake state phone prefix
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
