<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Text;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;

/**
 * @internal
 *
 * Generates fake paragraphs(s)
 *
 * @implements FakerInterface<string|list<string>>
 */
final class ParagraphFaker implements FakerInterface
{
    /** @use Arrayable<string> */
    use Arrayable;

    protected const VARIABLE_PERCENTAGE = 0.4;

    protected const MAX_NUMBER = 100;

    protected const MIN_NUMBER = 1;

    protected const SEPARATOR = "\n";

    protected const NB_WORDS = 6;

    /**
     * @param  int  $nbSentences  The number of sentences to include in each paragraph.
     * @param  int  $nbParagraphs  The number of paragraphs to be returned.
     * @param  bool  $asText  Whether to return the paragraphs as a single string (true) or as an array of strings (false).
     * @param  bool  $variableNbSentences  Whether to allow variability in the number of sentences per paragraph (true) or use a fixed count (false).
     */
    public function __construct(
        private SentenceFaker $sentenceFaker,
        private int $nbSentences = 3,
        private int $nbParagraphs = 1,
        private bool $asText = false,
        private bool $variableNbSentences = true,
    ) {}

    /**
     * This returns random paragraph(s).
     *
     * If $nbParagraphs is equal to 1, or $asText is true, the paragraph(s) are returned as a string.
     * If $nbParagraphs is greater than 1, and $asText is false, an array of paragraphs is returned.
     *
     * @return string|list<string>
     *
     * @throws InvalidElementNumberException
     */
    public function generate(): string|array
    {
        if (! $this->isSentencesNumberValid()) {
            throw new InvalidElementNumberException(
                sprintf('The number of sentences should be in range %s-%s, %s is given.', self::MIN_NUMBER, self::MAX_NUMBER, $this->nbSentences)
            );
        }

        if (! $this->isParagraphsNumberValid()) {
            throw new InvalidElementNumberException(
                sprintf('The number of paragraphs should be in range %s-%s, %s is given.', self::MIN_NUMBER, self::MAX_NUMBER, $this->nbParagraphs)
            );
        }

        $paragraphs = $this->getRandomParagraphs();

        return $this->shouldBeText() ? $this->convertToString($paragraphs, self::SEPARATOR) : $paragraphs;
    }

    private function isSentencesNumberValid(): bool
    {
        return $this->nbSentences >= self::MIN_NUMBER && $this->nbSentences <= self::MAX_NUMBER;
    }

    private function isParagraphsNumberValid(): bool
    {
        return $this->nbParagraphs >= self::MIN_NUMBER && $this->nbParagraphs <= self::MAX_NUMBER;
    }

    private function getVariableSentencesNumber(): int
    {
        $min = (int) ($this->nbSentences * (1 - self::VARIABLE_PERCENTAGE));
        $max = (int) ($this->nbSentences * (1 + self::VARIABLE_PERCENTAGE));

        $sentencesNumber = random_int($min, $max);

        if ($sentencesNumber < self::MIN_NUMBER) {
            return self::MIN_NUMBER;
        }

        if ($sentencesNumber > self::MAX_NUMBER) {
            return self::MAX_NUMBER;
        }

        return $sentencesNumber;
    }

    private function shouldBeText(): bool
    {
        return $this->nbParagraphs === 1 || $this->asText;
    }

    /**
     * @return list<string>
     */
    private function getRandomParagraphs(): array
    {
        $paragraphs = [];

        for ($i = 1; $i <= $this->nbParagraphs; $i++) {
            $sentencesNumber = $this->variableNbSentences ? $this->getVariableSentencesNumber() : $this->nbSentences;

            $paragraphs[] = $this->getParagraph($sentencesNumber);
        }

        return $paragraphs;
    }

    private function getParagraph(int $sentencesNumber): string
    {
        return $this->sentenceFaker->shouldReturnString(self::NB_WORDS, $sentencesNumber)->generate();
    }
}
