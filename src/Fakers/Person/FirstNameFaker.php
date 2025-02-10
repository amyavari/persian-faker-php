<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Person;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidGenderException;

/**
 * Generates a random first name in Persian for Iranian individuals.
 *
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class FirstNameFaker implements FakerInterface
{
    /** @use \AliYavari\PersianFaker\Cores\Randomable<int, string> */
    use Randomable;

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
        if (is_null($this->gender)) {
            return $this->getRandomName();
        }

        if ($this->gender === 'male') {
            return $this->getRandomMaleName();
        }

        if ($this->gender === 'female') {
            return $this->getRandomFemaleName();
        }

        throw new InvalidGenderException(sprintf('The gender %s is not valid.', $this->gender));
    }

    protected function getRandomName(): string
    {
        $allNames = array_merge($this->names['male'], $this->names['female']);

        return $this->getOneRandomElement($allNames);
    }

    protected function getRandomMaleName(): string
    {
        return $this->getOneRandomElement($this->names['male']);
    }

    protected function getRandomFemaleName(): string
    {
        return $this->getOneRandomElement($this->names['female']);
    }
}
