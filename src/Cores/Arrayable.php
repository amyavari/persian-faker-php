<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Cores;

use AliYavari\PersianFaker\Exceptions\InvalidMultiDimensionalArray;

/**
 * Trait with methods for managing and working on arrays
 *
 * @template TOuterKey of array-key
 * @template TInnerKey of array-key
 * @template TValue
 */
trait Arrayable
{
    /**
     * This method will flatten one level of a given array
     *
     * @param  array<TOuterKey, array<TInnerKey, TValue>>  $array
     * @return array<TInnerKey, TValue>
     */
    protected function flatten(array $array): array
    {
        $flattenedArray = [];

        foreach ($array as $key => $innerArray) {
            if (! is_array($innerArray)) {
                throw new InvalidMultiDimensionalArray(sprintf('The key %s does not refer to an array.', $key));
            }

            $flattenedArray = array_merge($flattenedArray, $innerArray);
        }

        return $flattenedArray;
    }
}
