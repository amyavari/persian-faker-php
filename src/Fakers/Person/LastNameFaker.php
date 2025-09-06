<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Person;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * @internal
 *
 * Generates a random last name in Persian for Iranian individuals.
 *
 * @extends SimplePicker<int, string>
 *
 * @implements FakerInterface<string>
 */
final class LastNameFaker extends SimplePicker implements FakerInterface
{
    /**
     * This returns a fake last name
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
