<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Address;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;

/**
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class StreetNameFaker implements FakerInterface
{
    /** @use \AliYavari\PersianFaker\Cores\Randomable<int, string> */
    use Randomable;

    /**
     * @var list<string>
     */
    protected array $streetNames;

    /**
     * @param  \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string>  $loader
     */
    public function __construct(DataLoaderInterface $loader)
    {
        $this->streetNames = $loader->get();
    }

    public function generate(): string
    {
        return $this->getRandomState();
    }

    protected function getRandomState(): string
    {
        return $this->getOneRandomElement($this->streetNames);
    }
}
