<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Company;

use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * Generates a random job title in Persian Language.
 *
 * @extends \AliYavari\PersianFaker\Fakers\SimplePicker<int, string>
 */
class JobTitleFaker extends SimplePicker
{
    /**
     * This returns a fake company job title
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
