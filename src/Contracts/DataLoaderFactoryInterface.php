<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Contracts;

/**
 * Interface for Data Loader Factories for initializing instances of data loaders.
 *
 * @template TKey as array-key
 * @template TData
 */
interface DataLoaderFactoryInterface
{
    /**
     * Get DataLoader instance
     *
     * @param  mixed  ...$args  Necessary arguments for DataLoader constructor
     * @return \AliYavari\PersianFaker\Contracts\DataLoaderInterface<TKey, TData>
     */
    public static function getInstance(mixed ...$args): DataLoaderInterface;
}
