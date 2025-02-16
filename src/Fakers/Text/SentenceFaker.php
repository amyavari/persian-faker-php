<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Text;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;

/**
 * Generates fake sentence(s)
 *
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string|list<string>>
 */
class SentenceFaker implements FakerInterface
{
    /** @use \AliYavari\PersianFaker\Cores\Arrayable<string> */
    use Arrayable;

    protected float $variablePercentage = 0.4;

    protected int $maxNumber = 100;

    protected int $minNumber = 1;

    protected string $separator = ' ';

    /**
     * @param  int  $nbWords  The number of words to include in each sentence.
     * @param  int  $nbSentences  The number of sentences to be returned.
     * @param  bool  $asText  Whether to return the sentences as a single string (true) or as an array of strings (false).
     * @param  bool  $variableNbWords  Whether to allow variability in the number of words per sentence (true) or use a fixed count (false).
     */
    public function __construct(
        protected WordFaker $wordFaker,
        protected int $nbWords = 6,
        protected int $nbSentences = 1,
        protected bool $asText = false,
        protected bool $variableNbWords = true,
    ) {}

    /**
     * This returns random sentence(s).
     *
     * If $nbSentences is equal to 1, or $asText is true, a single word is returned as a string.
     * If $nbSentences is greater than 1, and $asText is false, an array of words is returned.
     *
     * @return string|list<string>
     *
     * @throws \AliYavari\PersianFaker\Exceptions\InvalidElementNumberException
     */
    public function generate(): string|array
    {
        if (! $this->isWordsNumberValid()) {
            throw new InvalidElementNumberException(
                sprintf('The number of words should be in range %s-%s, %s is given.', $this->minNumber, $this->maxNumber, $this->nbWords)
            );
        }

        if (! $this->isSentencesNumberValid()) {
            throw new InvalidElementNumberException(
                sprintf('The number of sentences should be in range %s-%s, %s is given.', $this->minNumber, $this->maxNumber, $this->nbSentences)
            );
        }

        $sentences = $this->getRandomSentences();

        return $this->shouldBeText() ? $this->convertToString($sentences, $this->separator) : $sentences;
    }

    protected function isWordsNumberValid(): bool
    {
        return $this->nbWords >= $this->minNumber && $this->nbWords <= $this->maxNumber;
    }

    protected function isSentencesNumberValid(): bool
    {
        return $this->nbSentences >= $this->minNumber && $this->nbSentences <= $this->maxNumber;
    }

    protected function getVariableWordsNumber(): int
    {
        $min = (int) ($this->nbWords * (1 - $this->variablePercentage));
        $max = (int) ($this->nbWords * (1 + $this->variablePercentage));

        $wordsNumber = random_int($min, $max);

        if ($wordsNumber < $this->minNumber) {
            return $this->minNumber;
        }

        if ($wordsNumber > $this->maxNumber) {
            return $this->maxNumber;
        }

        return $wordsNumber;
    }

    protected function shouldBeText(): bool
    {
        return $this->nbSentences === 1 || $this->asText;
    }

    /**
     * @return list<string>
     */
    protected function getRandomSentences(): array
    {
        $sentences = [];

        for ($i = 1; $i <= $this->nbSentences; $i++) {
            $wordsNumber = $this->variableNbWords ? $this->getVariableWordsNumber() : $this->nbWords;

            $sentences[] = $this->getSentence($wordsNumber);
        }

        return $sentences;
    }

    protected function getSentence(int $wordsNumber): string
    {
        /** @var string */
        $sentence = $this->wordFaker->shouldReturnString($wordsNumber)->generate();

        return $this->addDotAtTheEnd($sentence);
    }

    protected function addDotAtTheEnd(string $sentence): string
    {
        return sprintf('%s.', $sentence);
    }
}
