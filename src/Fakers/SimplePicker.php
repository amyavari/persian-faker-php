<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;

/**
 * Returns a randomly selected element from the loaded one-dimensional data array.
 *
 * This method leverages the `Randomable` trait to pick a single random element
 * from the dataset provided by the `DataLoaderInterface`. It ensures consistent
 * and reusable logic for random selection across all child classes.
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<TValue>
 */
abstract class SimplePicker implements FakerInterface
{
    /** @use \AliYavari\PersianFaker\Cores\Randomable<TValue> */
    use Randomable;

    /**
     * @var array<TKey, TValue>
     */
    protected array $data;

    /**
     * @param  \AliYavari\PersianFaker\Contracts\DataLoaderInterface<TKey, TValue>  $loader
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
    public function generate()
    {
        return $this->getOneRandomElement($this->data);
    }
}
