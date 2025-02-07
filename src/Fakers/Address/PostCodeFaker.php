<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Address;

use AliYavari\PersianFaker\Contracts\FakerInterface;

/**
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class PostCodeFaker implements FakerInterface
{
    public function __construct(protected bool $withSeparator = false) {}

    public function generate(): string
    {
        $postCode = $this->generateRandomPostCode();

        return $this->withSeparator ? $this->addSeparator($postCode) : $postCode;
    }

    /**
     * - Only for safety, valid digits are restricted to the range of 1-9.
     */
    protected function generateRandomPostCode(): string
    {
        $postCode = '';

        for ($i = 1; $i <= 10; $i++) {
            $postCode .= random_int(1, 9);
        }

        return $postCode;
    }

    protected function addSeparator(string $postCode): string
    {
        return sprintf('%s-%s', substr($postCode, 0, 5), substr($postCode, 5));
    }
}
