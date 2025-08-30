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
 * @implements FakerInterface<string>
 */
final class PostCodeFaker implements FakerInterface
{
    /** @use Randomable<int> */
    use Randomable;

    public function __construct(private bool $withSeparator = false) {}

    /**
     * This returns a fake postal code
     */
    public function generate(): string
    {
        $postCode = $this->generateRandomPostCode();

        return $this->withSeparator ? $this->addSeparator($postCode) : $postCode;
    }

    private function generateRandomPostCode(): string
    {
        // Only for safety, valid digits are restricted to the range of 1-9.
        $validDigits = range(1, 9);

        $digits = $this->getMultipleRandomElements($validDigits, 10);

        return implode('', $digits);
    }

    private function addSeparator(string $postCode): string
    {
        return sprintf('%s-%s', mb_substr($postCode, 0, 5), mb_substr($postCode, 5));
    }
}
