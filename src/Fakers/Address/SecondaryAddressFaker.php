<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Address;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;

/**
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class SecondaryAddressFaker implements FakerInterface
{
    /** @use \AliYavari\PersianFaker\Cores\Randomable<int, string>*/
    use Randomable;

    /**
     * @var list<string>
     */
    public array $prefixes;

    /**
     * @param  \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string>  $loader
     */
    public function __construct(DataLoaderInterface $loader)
    {
        $this->prefixes = $loader->get();
    }

    public function generate(): string
    {
        $randomNumber = random_int(1, 50);

        return sprintf('%s %s', $this->getRandomPrefix(), $randomNumber);
    }

    protected function getRandomPrefix(): string
    {
        return $this->getOneRandomElement($this->prefixes);
    }
}
