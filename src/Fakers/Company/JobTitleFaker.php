<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Company;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * @internal
 *
 * Generates a random job title in Persian Language.
 *
 * @extends SimplePicker<int, string>
 *
 * @implements FakerInterface<string>
 */
final class JobTitleFaker extends SimplePicker implements FakerInterface
{
    /**
     * This returns a fake company job title
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
