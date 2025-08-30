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
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class FirstNameFaker implements FakerInterface
{
    /**
     * @use \AliYavari\PersianFaker\Cores\Randomable<string>
     * @use \AliYavari\PersianFaker\Cores\Arrayable<string>
     */
    use Arrayable, Randomable;

    /**
     * @var array<string, list<string>>
     */
    protected array $names;

    /**
     * @param  \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, list<string>>  $loader
     * @param  string|null  $gender  The gender can be either 'male' or 'female'.
     */
    public function __construct(DataLoaderInterface $loader, protected ?string $gender = null)
    {
        $this->names = $loader->get();
    }

    /**
     * This returns a fake first name
     *
     * @throws \AliYavari\PersianFaker\Exceptions\InvalidGenderException
     */
    public function generate(): string
    {
        if (! $this->isGenderValid()) {
            throw new InvalidGenderException(sprintf('The gender %s is not valid.', $this->gender));
        }

        return $this->getOneRandomElement($this->getNames());
    }

    protected function isGenderValid(): bool
    {
        if (is_null($this->gender)) {
            return true;
        }

        return array_key_exists($this->gender, $this->names);
    }

    /**
     * @return list<string>
     */
    protected function getNames(): array
    {
        return is_null($this->gender) ? $this->flatten($this->names) : $this->names[$this->gender];
    }
}
