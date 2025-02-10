<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Address;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;

/**
 * Generates a random city name in Iran
 *
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class CityFaker implements FakerInterface
{
    /** @use \AliYavari\PersianFaker\Cores\Randomable<int, string> */
    use Randomable;

    /**
     * @var list<string>
     */
    protected array $cities;

    /**
     * @param  \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string>  $loader
     */
    public function __construct(DataLoaderInterface $loader)
    {
        $this->cities = $loader->get();
    }

    /**
     * This returns a fake city name
     */
    public function generate(): string
    {
        return $this->getRandomCity();
    }

    protected function getRandomCity(): string
    {
        return $this->getOneRandomElement($this->cities);
    }
}
