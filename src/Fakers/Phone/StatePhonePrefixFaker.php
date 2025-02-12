<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Phone;

use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * Generates a random state phone prefix in Iran.
 *
 * @extends \AliYavari\PersianFaker\Fakers\SimplePicker<string, string>
 */
class StatePhonePrefixFaker extends SimplePicker
{
    /**
     * This returns a fake state phone prefix
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
