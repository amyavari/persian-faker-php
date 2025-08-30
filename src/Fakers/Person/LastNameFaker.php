<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Person;

use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * @internal
 *
 * Generates a random last name in Persian for Iranian individuals.
 *
 * @extends \AliYavari\PersianFaker\Fakers\SimplePicker<int, string>
 */
class LastNameFaker extends SimplePicker
{
    /**
     * This returns a fake last name
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
