<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Person;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidGenderException;

/**
 * @internal
 *
 * Generates a random first name in Persian for Iranian individuals.
 *
 * @implements FakerInterface<string>
 */
final class FirstNameFaker implements FakerInterface
{
    /**
     * @use Randomable<string>
     * @use Arrayable<string>
     */
    use Arrayable, Randomable;

    /**
     * @var array<string, list<string>>
     */
    private array $names;

    /**
     * @param  DataLoaderInterface<string, list<string>>  $loader
     * @param  string|null  $gender  The gender can be either 'male' or 'female'.
     */
    public function __construct(DataLoaderInterface $loader, private ?string $gender = null)
    {
        $this->names = $loader->get();
    }

    /**
     * This returns a fake first name
     *
     * @throws InvalidGenderException
     */
    public function generate(): string
    {
        if (! $this->isGenderValid()) {
            throw new InvalidGenderException(sprintf('The gender %s is not valid.', $this->gender));
        }

        return $this->getOneRandomElement($this->getNames());
    }

    private function isGenderValid(): bool
    {
        if (is_null($this->gender)) {
            return true;
        }

        return array_key_exists($this->gender, $this->names);
    }

    /**
     * @return list<string>
     */
    private function getNames(): array
    {
        return is_null($this->gender) ? $this->flatten($this->names) : $this->names[$this->gender];
    }
}
