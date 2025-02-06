<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Person;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidGenderException;

/**
 * @implements FakerInterface<string>
 */
class FirstNameFaker implements FakerInterface
{
    /** @use Randomable<int, string> */
    use Randomable;

    /** @var array<string, list<string>> */
    protected array $names;

    /**
     * @param  DataLoaderInterface<string, list<string>>  $loader
     */
    public function __construct(DataLoaderInterface $loader, protected ?string $gender = null)
    {
        $this->names = $loader->get();
    }

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
        return $this->getOneRandomElement(array_merge($this->names['male'], $this->names['female']));
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
