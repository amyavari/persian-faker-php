<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Cores;

/**
 * @internal
 *
 * This trait has methods for managing and working on arrays.
 *
 * @template TValue
 */
trait Arrayable
{
    /**
     * This method will flatten one level of a given array.
     *
     * @param  array<array<TValue>>  $array
     * @return array<TValue>
     */
    protected function flatten(array $array): array
    {
        $flattenedArray = [];

        foreach ($array as $innerArray) {
            $flattenedArray = array_merge($flattenedArray, $innerArray);
        }

        return $flattenedArray;
    }

    /**
     * Converts an array of strings into a single string, inserting the specified separator between each string.
     *
     * @param  array<string>  $arr  The array of strings to flatten into a single string.
     * @param  string  $separator  The separator to use between elements in the resulting string.
     */
    protected function convertToString(array $arr, string $separator = ' '): string
    {
        return implode($separator, $arr);
    }
}
