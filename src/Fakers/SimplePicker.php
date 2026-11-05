<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;

/**
 * @internal
 *
 * Returns a random element from a one-dimensional data list.
 *
 * @implements FakerInterface<string>
 */
final class SimplePicker implements FakerInterface
{
    /** @use Randomable<string> */
    use Randomable;

    /**
     * @var array<array-key, string>
     */
    private array $data;

    /**
     * @param  DataLoaderInterface<array-key, string>  $loader
     */
    public function __construct(DataLoaderInterface $loader)
    {
        $this->data = $loader->get();
    }

    /**
     * This returns a random element
     */
    public function generate(): string
    {
        return $this->getOneRandomElement($this->data);
    }
}
