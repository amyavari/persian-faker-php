<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Company;

use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * @internal
 *
 * Generates a random company name of Iranian companies.
 *
 * @extends \AliYavari\PersianFaker\Fakers\SimplePicker<int, string>
 */
class CompanyNameFaker extends SimplePicker
{
    /**
     * This returns a fake company name
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
