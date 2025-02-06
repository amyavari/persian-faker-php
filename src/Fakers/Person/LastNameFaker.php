<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Person;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;

/**
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class LastNameFaker implements FakerInterface
{
    /** @use \AliYavari\PersianFaker\Cores\Randomable<int, string> */
    use Randomable;

    /**
     * @var list<string>
     */
    protected array $lastNames;

    /**
     * @param  \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string>  $loader
     */
    public function __construct(DataLoaderInterface $loader)
    {
        $this->lastNames = $loader->get();
    }

    /**
     * This returns a fake last name
     */
    public function generate(): string
    {
        return $this->getRandomLastName();
    }

    protected function getRandomLastName(): string
    {
        return $this->getOneRandomElement($this->lastNames);
    }
}
