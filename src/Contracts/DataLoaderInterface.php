<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Contracts;

/**
 * Interface for all Data loaders to retrieve data.
 *
 * @template TKey as array-key
 * @template TData The expected return type of the loaded data.
 */
interface DataLoaderInterface
{
    /**
     * Loads data from a path and retrieves its value.
     *
     * @return array<TKey, TData>
     */
    public function get();
}
