<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Company;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Fakers\SimplePicker;

/**
 * @internal
 *
 * Generates a random company catchphrase in Persian Language.
 *
 * @extends SimplePicker<int, string>
 *
 * @implements FakerInterface<string>
 */
final class CatchphraseFaker extends SimplePicker implements FakerInterface
{
    /**
     * This returns a fake company catchphrase
     */
    public function generate(): string
    {
        return parent::generate();
    }
}
