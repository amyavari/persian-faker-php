<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Company;

use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * Generates a random company catchphrase in Persian Language.
 *
 * @extends \AliYavari\PersianFaker\Fakers\SimplePicker<int, string>
 */
class CatchphraseFaker extends SimplePicker
{
    /**
     * This returns a fake company catchphrase
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
