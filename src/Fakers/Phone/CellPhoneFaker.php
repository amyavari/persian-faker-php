<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Phone;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidMobileProviderException;

/**
 * Generates a random cell phone (mobile) number in Iran.
 *
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class CellPhoneFaker implements FakerInterface
{
    /**
     * @use \AliYavari\PersianFaker\Cores\Randomable<string>
     * @use \AliYavari\PersianFaker\Cores\Arrayable<string>
     */
    use Arrayable, Randomable;

    /**
     * @var array<string, list<string>>
     */
    protected array $phonePrefixes;

    /**
     * @param  \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, list<string>>  $loader
     * @param  string  $separator  The separator between the state prefix and the phone number.
     * @param  string|null  $provider  The name of the mobile provider in Iran. See ./src/Data/phone.php
     */
    public function __construct(DataLoaderInterface $loader, protected string $separator = '', protected ?string $provider = null)
    {
        $this->phonePrefixes = $loader->get();
    }

    /**
     * This returns a fake cell phone number
     *
     * @throws \AliYavari\PersianFaker\Exceptions\InvalidMobileProviderException
     */
    public function generate(): string
    {
        if (! $this->isProviderValid()) {
            throw new InvalidMobileProviderException(sprintf('The mobile provider with name %s is not valid.', $this->provider));
        }

        $randomPrefix = $this->getOneRandomElement($this->getPrefixes());

        return $this->formatPhone($randomPrefix, $this->generateRandomCellPhone());
    }

    protected function isProviderValid(): bool
    {
        if (is_null($this->provider)) {
            return true;
        }

        return array_key_exists($this->provider, $this->phonePrefixes);
    }

    /**
     * @return list<string>
     */
    protected function getPrefixes(): array
    {
        return is_null($this->provider) ? $this->flatten($this->phonePrefixes) : $this->phonePrefixes[$this->provider];
    }

    protected function generateRandomCellPhone(): string
    {
        return (string) random_int(1_000_000, 9_999_999);
    }

    protected function formatPhone(string $providerPrefix, string $phoneNumber): string
    {
        $firstPart = substr($phoneNumber, 0, 3);
        $secondPart = substr($phoneNumber, 3);

        return sprintf('%s%s%s%s%s', $providerPrefix, $this->separator, $firstPart, $this->separator, $secondPart);
    }
}
