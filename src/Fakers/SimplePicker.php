<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Cores\Randomable;

/**
 * @internal
 *
 * Returns a randomly selected element from the loaded one-dimensional data array.
 * It ensures consistent and reusable logic for random selection across all child classes.
 *
 * @template TKey of array-key
 * @template TValue
 */
abstract class SimplePicker
{
    /** @use Randomable<TValue> */
    use Randomable;

    /**
     * @var array<TKey, TValue>
     */
    protected array $data;

    /**
     * @param  DataLoaderInterface<TKey, TValue>  $loader
     */
    public function __construct(DataLoaderInterface $loader)
    {
        $this->data = $loader->get();
    }

    /**
     * This returns a random element
     *
     * @return TValue
     */
    protected function generate()
    {
        return $this->getOneRandomElement($this->data);
    }
}
