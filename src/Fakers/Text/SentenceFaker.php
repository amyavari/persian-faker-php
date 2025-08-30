<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Text;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;

/**
 * @internal
 *
 * Generates fake sentence(s)
 *
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string|list<string>>
 */
class SentenceFaker implements FakerInterface
{
    /** @use \AliYavari\PersianFaker\Cores\Arrayable<string> */
    use Arrayable;

    protected const VARIABLE_PERCENTAGE = 0.4;

    protected const MAX_NUMBER = 100;

    protected const MIN_NUMBER = 1;

    protected const SEPARATOR = ' ';

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
     * If $nbSentences is equal to 1, or $asText is true, the sentence(s) are returned as a string.
     * If $nbSentences is greater than 1, and $asText is false, an array of sentences is returned.
     *
     * @return string|list<string>
     *
     * @throws \AliYavari\PersianFaker\Exceptions\InvalidElementNumberException
     */
    public function generate(): string|array
    {
        if (! $this->isWordsNumberValid()) {
            throw new InvalidElementNumberException(
                sprintf('The number of words should be in range %s-%s, %s is given.', self::MIN_NUMBER, self::MAX_NUMBER, $this->nbWords)
            );
        }

        if (! $this->isSentencesNumberValid()) {
            throw new InvalidElementNumberException(
                sprintf('The number of sentences should be in range %s-%s, %s is given.', self::MIN_NUMBER, self::MAX_NUMBER, $this->nbSentences)
            );
        }

        $sentences = $this->getRandomSentences();

        return $this->shouldBeText() ? $this->convertToString($sentences, self::SEPARATOR) : $sentences;
    }

    /**
     * Returns a new instance of this class which is configured
     * to return a string containing $nbSentences,
     * where each sentence contains $nbWords, which is allowed to vary.
     */
    public function shouldReturnString(int $nbWords, int $nbSentences): self
    {
        return new self($this->wordFaker, nbWords: $nbWords, nbSentences: $nbSentences, variableNbWords: true, asText: true);
    }

    protected function isWordsNumberValid(): bool
    {
        return $this->nbWords >= self::MIN_NUMBER && $this->nbWords <= self::MAX_NUMBER;
    }

    protected function isSentencesNumberValid(): bool
    {
        return $this->nbSentences >= self::MIN_NUMBER && $this->nbSentences <= self::MAX_NUMBER;
    }

    protected function getVariableWordsNumber(): int
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
