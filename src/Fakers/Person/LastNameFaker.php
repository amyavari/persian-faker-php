<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Person;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;

/**
 * Generates a random last name in Persian for Iranian individuals.
 *
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class LastNameFaker implements FakerInterface
{
    /** @use \AliYavari\PersianFaker\Cores\Randomable<int, string> */
    use Randomable;

    /**
     * @var list<string>
     */
    protected array $names;

    /**
     * @param  \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string>  $loader
     */
    public function __construct(DataLoaderInterface $loader)
    {
        $this->names = $loader->get();
    }

    /**
     * This returns a fake last name
     */
    public function generate(): string
    {
        return $this->getOneRandomElement($this->names);
    }
}
