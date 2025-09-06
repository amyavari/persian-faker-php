<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Company;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * @internal
 *
 * Generates a random company name of Iranian companies.
 *
 * @extends SimplePicker<int, string>
 *
 * @implements FakerInterface<string>
 */
final class CompanyNameFaker extends SimplePicker implements FakerInterface
{
    /**
     * This returns a fake company name
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
