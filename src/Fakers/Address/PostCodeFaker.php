<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Address;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;

/**
 * @internal
 *
 * Generates a fake postal code for Iran
 *
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class PostCodeFaker implements FakerInterface
{
    /** @use \AliYavari\PersianFaker\Cores\Randomable<int> */
    use Randomable;

    public function __construct(protected bool $withSeparator = false) {}

    /**
     * This returns a fake postal code
     */
    public function generate(): string
    {
        $postCode = $this->generateRandomPostCode();

        return $this->withSeparator ? $this->addSeparator($postCode) : $postCode;
    }

    protected function generateRandomPostCode(): string
    {
        // Only for safety, valid digits are restricted to the range of 1-9.
        $validDigits = range(1, 9);

        $digits = $this->getMultipleRandomElements($validDigits, 10);

        return implode('', $digits);
    }

    protected function addSeparator(string $postCode): string
    {
        return sprintf('%s-%s', substr($postCode, 0, 5), substr($postCode, 5));
    }
}
