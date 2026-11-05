<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Text;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Cores\HasVariableCount;
use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;

/**
 * @internal
 *
 * Generates fake sentence(s)
 *
 * @implements FakerInterface<string|list<string>>
 */
final class SentenceFaker implements FakerInterface
{
    /** @use Arrayable<string> */
    use Arrayable, HasVariableCount;

    private const string SEPARATOR = ' ';

    /**
     * @param  int  $nbWords  The number of words to include in each sentence.
     * @param  int  $nbSentences  The number of sentences to be returned.
     * @param  bool  $asText  Whether to return the sentences as a single string (true) or as an array of strings (false).
     * @param  bool  $variableNbWords  Whether to allow variability in the number of words per sentence (true) or use a fixed count (false).
     */
    public function __construct(
        private WordFaker $wordFaker,
        private int $nbWords = 6,
        private int $nbSentences = 1,
        private bool $asText = false,
        private bool $variableNbWords = true,
    ) {}

    /**
     * This returns random sentence(s).
     *
     * If $nbSentences is equal to 1, or $asText is true, the sentence(s) are returned as a string.
     * If $nbSentences is greater than 1, and $asText is false, an array of sentences is returned.
     *
     * @return string|list<string>
     *
     * @throws InvalidElementNumberException
     */
    public function generate(): string|array
    {
        if (! $this->isNumberInRange($this->nbWords)) {
            throw new InvalidElementNumberException(
                sprintf('The number of words should be in range %s-%s, %s is given.', self::MIN_NUMBER, self::MAX_NUMBER, $this->nbWords)
            );
        }

        if (! $this->isNumberInRange($this->nbSentences)) {
            throw new InvalidElementNumberException(
                sprintf('The number of sentences should be in range %s-%s, %s is given.', self::MIN_NUMBER, self::MAX_NUMBER, $this->nbSentences)
            );
        }

        $sentences = $this->getRandomSentences($this->nbWords, $this->nbSentences, $this->variableNbWords);

        return $this->shouldBeText() ? $this->convertToString($sentences, self::SEPARATOR) : $sentences;
    }

    /**
     * Returns $nbSentences random sentences as one string.
     * The number of words in each sentence varies around $nbWords.
     */
    public function generateText(int $nbWords, int $nbSentences): string
    {
        $sentences = $this->getRandomSentences($nbWords, $nbSentences, variableNbWords: true);

        return $this->convertToString($sentences, self::SEPARATOR);
    }

    private function shouldBeText(): bool
    {
        return $this->nbSentences === 1 || $this->asText;
    }

    /**
     * @return list<string>
     */
    private function getRandomSentences(int $nbWords, int $nbSentences, bool $variableNbWords): array
    {
        $sentences = [];

        for ($i = 1; $i <= $nbSentences; $i++) {
            $wordsNumber = $variableNbWords ? $this->getVariableNumber($nbWords) : $nbWords;

            $sentences[] = $this->getSentence($wordsNumber);
        }

        return $sentences;
    }

    private function getSentence(int $wordsNumber): string
    {
        $sentence = $this->wordFaker->generateText($wordsNumber);

        return $this->addDotAtTheEnd($sentence);
    }

    private function addDotAtTheEnd(string $sentence): string
    {
        return sprintf('%s.', $sentence);
    }
}
