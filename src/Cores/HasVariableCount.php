<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Cores;

/**
 * @internal
 *
 * This trait has methods for checking and varying the number of elements (words, sentences, paragraphs).
 */
trait HasVariableCount
{
    protected const int MIN_NUMBER = 1;

    protected const int MAX_NUMBER = 100;

    protected const float VARIABLE_PERCENTAGE = 0.4;

    /**
     * Checks that the number is between MIN_NUMBER and MAX_NUMBER.
     */
    protected function isNumberInRange(int $number): bool
    {
        return $number >= self::MIN_NUMBER && $number <= self::MAX_NUMBER;
    }

    /**
     * Returns a random number up to VARIABLE_PERCENTAGE more or less than the given number,
     * kept between MIN_NUMBER and MAX_NUMBER.
     */
    protected function getVariableNumber(int $number): int
    {
        $min = (int) ($number * (1 - self::VARIABLE_PERCENTAGE));
        $max = (int) ($number * (1 + self::VARIABLE_PERCENTAGE));

        $variableNumber = random_int($min, $max);

        if ($variableNumber < self::MIN_NUMBER) {
            return self::MIN_NUMBER;
        }

        if ($variableNumber > self::MAX_NUMBER) {
            return self::MAX_NUMBER;
        }

        return $variableNumber;
    }
}
