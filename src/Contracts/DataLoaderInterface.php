<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Contracts;

/**
 * Loads data from a file and retrieves values.
 *
 * @template TKey as array-key
 * @template TData The expected return type of the loaded data.
 */
interface DataLoaderInterface
{
    /**
     * Retrieves data from the specified file and path.
     *
     * @return array<TKey, TData>
     */
    public function get();
}
