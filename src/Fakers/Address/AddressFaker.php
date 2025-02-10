<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Address;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;

/**
 * Generates a random full address in Iran
 *
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class AddressFaker implements FakerInterface
{
    /** @use \AliYavari\PersianFaker\Cores\Randomable<int, string> */
    use Randomable;

    /**
     * @var list<string>
     */
    protected array $addresses;

    /**
     * @param  \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string>  $loader
     */
    public function __construct(DataLoaderInterface $loader)
    {
        $this->addresses = $loader->get();
    }

    /**
     * This returns a fake full address
     */
    public function generate(): string
    {
        return $this->getOneRandomElement($this->addresses);
    }
}
