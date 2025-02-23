<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Cores;

/**
 * This trait has methods for retrieving random element(s) from an array.
 *
 * @template TValue
 */
trait Randomable
{
    /**
     * Retrieves one random element from the provided array.
     *
     * @param  array<TValue>  $data
     * @return TValue
     */
    protected function getOneRandomElement(array $data)
    {
        return $data[array_rand($data)];
    }

    /**
     * Retrieves random elements from the provided array.
     *
     * @param  array<TValue>  $data
     * @param  int  $number  The number of elements to return
     * @return list<TValue>
     */
    protected function getMultipleRandomElements(array $data, int $number): array
    {
        $elements = [];

        for ($i = 1; $i <= $number; $i++) {
            $elements[] = $data[array_rand($data)];
        }

        return $elements;
    }
}
