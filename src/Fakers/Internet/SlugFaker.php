<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Internet;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\HasVariableCount;
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
    use HasVariableCount;

    private const string SEPARATOR = '-';

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
     * @throws InvalidElementNumberException
     */
    public function generate(): string
    {
        if (! $this->isNumberInRange($this->nbWords)) {
            throw new InvalidElementNumberException(
                sprintf('The number of words should be in range %s-%s, %s is given.', self::MIN_NUMBER, self::MAX_NUMBER, $this->nbWords)
            );
        }

        $wordsNumber = $this->variableNbWords ? $this->getVariableNumber($this->nbWords) : $this->nbWords;

        return $this->getSlug($wordsNumber);
    }

    private function getSlug(int $wordsNumber): string
    {
        $slug = $this->wordFaker->generateText($wordsNumber);

        return $this->replaceWordsSeparator($slug);
    }

    private function replaceWordsSeparator(string $slug): string
    {
        return str_replace(' ', self::SEPARATOR, $slug);
    }
}
