<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Person;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidGenderException;

/**
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class TitleFaker implements FakerInterface
{
    /** @use \AliYavari\PersianFaker\Cores\Randomable<int, string> */
    use Randomable;

    /**
     * @var array<string, list<string>>
     */
    protected array $titles;

    /**
     * @param  \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, list<string>>  $loader
     * @param  string|null  $gender  The gender can be either 'male' or 'female'.
     */
    public function __construct(DataLoaderInterface $loader, protected ?string $gender = null)
    {
        $this->titles = $loader->get();
    }

    /**
     * This returns a fake person's title
     *
     * @throws \AliYavari\PersianFaker\Exceptions\InvalidGenderException
     */
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
