<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Person;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidStateNameException;
use RangeException;
use TypeError;

/**
 * @internal
 *
 * Generates a random Iranian national code.
 *
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class NationalCodeFaker implements FakerInterface
{
    /**
     * @use \AliYavari\PersianFaker\Cores\Arrayable<string>
     * @use \AliYavari\PersianFaker\Cores\Randomable<string>
     */
    use Arrayable, Randomable;

    /**
     * @var array<string, list<string>>
     */
    protected array $statePrefixes;

    /**
     * @param  \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, list<string>>  $loader
     * @param  string|null  $state  The name of the state in Iran. See ./src/data/person.php
     */
    public function __construct(DataLoaderInterface $loader, protected ?string $state = null)
    {
        $this->statePrefixes = $loader->get();
    }

    /**
     * This returns a fake Iranian national code.
     *
     * @throws \AliYavari\PersianFaker\Exceptions\InvalidStateNameException
     */
    public function generate(): string
    {
        if (! $this->isStateValid()) {
            throw new InvalidStateNameException(sprintf('The state name %s is not valid.', $this->state));
        }

        $statePrefix = $this->getStatePrefix();

        $nationalCode = $this->generateRandomNationalCode();

        $checkDigit = $this->calculateCheckDigit($statePrefix.$nationalCode);

        return sprintf('%s%s%s', $statePrefix, $nationalCode, $checkDigit);
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
        $prefixes = is_null($this->state) ? $this->flatten($this->statePrefixes) : $this->statePrefixes[$this->state];

        return $this->getOneRandomElement($prefixes);
    }

    protected function generateRandomNationalCode(): int
    {
        return random_int(100_000, 999_999);
    }

    /**
     * To see Iranian National Code algorithm, please check \Tests\Fakers\Person\NationalCodeFakerTest.
     *
     * @throws \RangeException
     * @throws \TypeError
     */
    protected function calculateCheckDigit(string $digits): int
    {
        if (strlen($digits) !== 9) {
            throw new RangeException(
                sprintf('The input number must have 9 digits, %s-digit number is given.', strlen($digits))
            );
        }

        if (! is_numeric($digits)) {
            throw new TypeError(
                sprintf('The input must be numeric. %s is given.', get_debug_type($digits))
            );
        }

        $sum = 0;
        foreach (str_split($digits) as $key => $value) {
            $sum += $value * (10 - $key); /** @phpstan-ignore binaryOp.invalid */
        }

        $remainder = $sum % 11;

        if ($remainder < 2) {
            return $remainder;
        }

        return 11 - $remainder;
    }
}
