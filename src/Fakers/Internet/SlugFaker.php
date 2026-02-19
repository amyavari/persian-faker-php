<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Internet;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;
use AliYavari\PersianFaker\Fakers\Text\WordFaker;

/**
 * @internal
 *
 * Generates fake slug
 *
 * @implements FakerInterface<string|list<string>>
 */
final readonly class SlugFaker implements FakerInterface
{
    private const VARIABLE_PERCENTAGE = 0.4;

    private const MAX_NUMBER = 100;

    private const MIN_NUMBER = 1;

    private const SEPARATOR = '-';

    /**
     * @param  int  $nbWords  The number of words to include in each slug.
     * @param  bool  $variableNbWords  Whether to allow variability in the number of words per slug (true) or use a fixed count (false).
     */
    public function __construct(
        private WordFaker $wordFaker,
        private int $nbWords = 6,
        private bool $variableNbWords = true,
    ) {}

    /**
     * This returns random slug.
     *
     * @return string|list<string>
     *
     * @throws InvalidElementNumberException
     */
    public function generate(): string|array
    {
        if (! $this->isWordsNumberValid()) {
            throw new InvalidElementNumberException(
                sprintf('The number of words should be in range %s-%s, %s is given.', self::MIN_NUMBER, self::MAX_NUMBER, $this->nbWords)
            );
        }

        $wordsNumber = $this->variableNbWords ? $this->getVariableWordsNumber() : $this->nbWords;

        return $this->getSlug($wordsNumber);
    }

    private function isWordsNumberValid(): bool
    {
        return $this->nbWords >= self::MIN_NUMBER && $this->nbWords <= self::MAX_NUMBER;
    }

    private function getVariableWordsNumber(): int
    {
        $min = (int) ($this->nbWords * (1 - self::VARIABLE_PERCENTAGE));
        $max = (int) ($this->nbWords * (1 + self::VARIABLE_PERCENTAGE));

        $wordsNumber = random_int($min, $max);

        if ($wordsNumber < self::MIN_NUMBER) {
            return self::MIN_NUMBER;
        }

        if ($wordsNumber > self::MAX_NUMBER) {
            return self::MAX_NUMBER;
        }

        return $wordsNumber;
    }

    private function getSlug(int $wordsNumber): string
    {
        $slug = $this->wordFaker->shouldReturnString($wordsNumber)->generate();

        return $this->replaceWordsSeparator($slug);
    }

    private function replaceWordsSeparator(string $slug): string
    {
        return str_replace(' ', self::SEPARATOR, $slug);
    }
}
