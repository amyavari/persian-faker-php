<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Phone;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidStateNameException;

/**
 * @internal
 *
 * Generates a random phone number in Iran.
 *
 * @implements FakerInterface<string>
 */
final class PhoneNumberFaker implements FakerInterface
{
    /** @use Randomable<string> */
    use Randomable;

    /**
     * @var array<string, string>
     */
    private array $statePrefixes;

    /**
     * @param  DataLoaderInterface<string, string>  $loader
     * @param  string  $separator  The separator between the mobile provider prefix, the first three digits, and the last four digits.
     * @param  string|null  $state  The name of the state in Iran. See ./src/Data/phone.php
     */
    public function __construct(DataLoaderInterface $loader, private string $separator = '', private ?string $state = null)
    {
        $this->statePrefixes = $loader->get();
    }

    /**
     * This returns a fake phone number
     *
     * @throws InvalidStateNameException
     */
    public function generate(): string
    {
        if (! $this->isStateValid()) {
            throw new InvalidStateNameException(sprintf('The state name %s is not valid.', $this->state));
        }

        return $this->formatPhone($this->getStatePrefix(), $this->generateRandomPhoneNumber());
    }

    private function isStateValid(): bool
    {
        if (is_null($this->state)) {
            return true;
        }

        return array_key_exists($this->state, $this->statePrefixes);
    }

    private function getStatePrefix(): string
    {
        return is_null($this->state) ? $this->getOneRandomElement($this->statePrefixes) : $this->statePrefixes[$this->state];
    }

    private function generateRandomPhoneNumber(): string
    {
        return (string) random_int(10_000_000, 99_999_999);
    }

    private function formatPhone(string $statePrefix, string $phoneNumber): string
    {
        return sprintf('%s%s%s', $statePrefix, $this->separator, $phoneNumber);
    }
}
