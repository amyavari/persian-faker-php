<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Phone;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidStateNameException;

/**
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class PhoneNumberFaker implements FakerInterface
{
    /** @use \AliYavari\PersianFaker\Cores\Randomable<string, string> */
    use Randomable;

    /**
     * @var array<string, string>
     */
    protected array $statePrefixes;

    /**
     * @param  \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, string>  $loader
     */
    public function __construct(DataLoaderInterface $loader, protected string $separator = '', protected ?string $state = null)
    {
        $this->statePrefixes = $loader->get();
    }

    /**
     * @throws \AliYavari\PersianFaker\Exceptions\InvalidStateNameException
     */
    public function generate(): string
    {
        if (! $this->isStateValid()) {
            throw new InvalidStateNameException(sprintf('The state name %s is not valid.', $this->state));
        }

        return $this->formatPhone($this->getStatePrefix(), $this->generateRandomPhoneNumber());
    }

    protected function isStateValid(): bool
    {
        if (is_null($this->state)) {
            return true;
        }

        return array_key_exists($this->state, $this->statePrefixes);
    }

    protected function getStatePrefix(): string
    {
        return is_null($this->state) ? $this->getRandomPrefix() : $this->statePrefixes[$this->state];
    }

    protected function getRandomPrefix(): string
    {
        return $this->getOneRandomElement($this->statePrefixes);
    }

    protected function generateRandomPhoneNumber(): string
    {
        return (string) random_int(10000000, 99999999);
    }

    protected function formatPhone(string $statePrefix, string $phoneNumber): string
    {
        return sprintf('%s%s%s', $statePrefix, $this->separator, $phoneNumber);
    }
}
