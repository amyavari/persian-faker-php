<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidGenderException;

/**
 * @implements FakerInterface<string>
 */
class TitleFaker implements FakerInterface
{
    /** @use Randomable<int, string> */
    use Randomable;

    /**
     * @var array<string, list<string>>
     */
    protected array $titles;

    /**
     * @param  DataLoaderInterface<string, list<string>>  $loader
     */
    public function __construct(DataLoaderInterface $loader, protected ?string $gender = null)
    {
        $this->titles = $loader->get();
    }

    public function generate(): string
    {
        if (is_null($this->gender)) {
            return $this->getRandomTitle();
        }

        if ($this->gender === 'male') {
            return $this->getMaleTitle();
        }

        if ($this->gender === 'female') {
            return $this->getFemaleTitle();
        }

        throw new InvalidGenderException(sprintf('The gender %s is not valid.', $this->gender));
    }

    protected function getRandomTitle(): string
    {
        $allTitles = array_merge($this->titles['male'], $this->titles['female']);

        return $this->getOneRandomElement($allTitles);
    }

    protected function getMaleTitle(): string
    {
        return $this->getOneRandomElement($this->titles['male']);
    }

    protected function getFemaleTitle(): string
    {
        return $this->getOneRandomElement($this->titles['female']);
    }
}
