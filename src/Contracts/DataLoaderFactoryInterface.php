<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Contracts;

/**
 * @template TKey as array-key
 * @template TData
 */
interface DataLoaderFactoryInterface
{
    /**
     * Get DataLoader instance
     *
     * @param  mixed  ...$args  Necessary arguments for DataLoader constructor
     * @return DataLoaderInterface<TKey, TData>
     */
    public static function getInstance(mixed ...$args): DataLoaderInterface;
}
