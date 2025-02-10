<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Loaders;

use AliYavari\PersianFaker\Contracts\DataLoaderFactoryInterface;
use AliYavari\PersianFaker\Contracts\DataLoaderInterface;

/**
 * This class initiates an instance of Data Loader
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @implements \AliYavari\PersianFaker\Contracts\DataLoaderFactoryInterface<TKey, list<TValue>>
 */
class DataLoaderFactory implements DataLoaderFactoryInterface
{
    /**
     * Get Data Loader instance
     *
     * @param  string  ...$args  Necessary arguments for DataLoader constructor
     * @return \AliYavari\PersianFaker\Contracts\DataLoaderInterface<TKey, list<TValue>>
     */
    public static function getInstance(...$args): DataLoaderInterface
    {
        [$dataPath] = $args;

        return new DataLoader($dataPath);
    }
}
