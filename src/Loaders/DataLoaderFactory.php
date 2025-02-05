<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Loaders;

use AliYavari\PersianFaker\Contracts\DataLoaderFactoryInterface;
use AliYavari\PersianFaker\Contracts\DataLoaderInterface;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @implements DataLoaderFactoryInterface<TKey, list<TValue>>
 */
class DataLoaderFactory implements DataLoaderFactoryInterface
{
    /**
     * @param  string  ...$args  Necessary arguments for DataLoader constructor
     * @return DataLoaderInterface<TKey, list<TValue>>
     */
    public static function getInstance(...$args): DataLoaderInterface
    {
        [$dataPath] = $args;

        return new DataLoader($dataPath);
    }
}
