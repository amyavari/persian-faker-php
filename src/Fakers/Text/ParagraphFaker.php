<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Text;

use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;

/**
 * Generates fake paragraphs(s)
 *
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string|list<string>>
 */
class ParagraphFaker implements FakerInterface
{
    /** @use \AliYavari\PersianFaker\Cores\Arrayable<string> */
    use Arrayable;

    protected float $variablePercentage = 0.4;

    protected int $maxNumber = 100;

    protected int $minNumber = 1;

    protected string $separator = "\n";

    protected int $nbWords = 6;

    /**
     * @param  int  $nbSentences  The number of sentences to include in each paragraph.
     * @param  int  $nbParagraphs  The number of paragraphs to be returned.
     * @param  bool  $asText  Whether to return the paragraphs as a single string (true) or as an array of strings (false).
     * @param  bool  $variableNbSentences  Whether to allow variability in the number of sentences per paragraph (true) or use a fixed count (false).
     */
    public function __construct(
        protected SentenceFaker $sentenceFaker,
        protected int $nbSentences = 3,
        protected int $nbParagraphs = 1,
        protected bool $asText = false,
        protected bool $variableNbSentences = true,
    ) {}

    /**
     * This returns random paragraph(s).
     *
     * If $nbParagraphs is equal to 1, or $asText is true, the paragraph(s) are returned as a string.
     * If $nbParagraphs is greater than 1, and $asText is false, an array of paragraphs is returned.
     *
     * @return string|list<string>
     *
     * @throws \AliYavari\PersianFaker\Exceptions\InvalidElementNumberException
     */
    public function generate(): string|array
    {
        if (! $this->isSentencesNumberValid()) {
            throw new InvalidElementNumberException(
                sprintf('The number of sentences should be in range %s-%s, %s is given.', $this->minNumber, $this->maxNumber, $this->nbSentences)
            );
        }

        if (! $this->isParagraphsNumberValid()) {
            throw new InvalidElementNumberException(
                sprintf('The number of paragraphs should be in range %s-%s, %s is given.', $this->minNumber, $this->maxNumber, $this->nbParagraphs)
            );
        }

        $paragraphs = $this->getRandomParagraphs();

        return $this->shouldBeText() ? $this->convertToString($paragraphs, $this->separator) : $paragraphs;
    }

    protected function isSentencesNumberValid(): bool
    {
        return $this->nbSentences >= $this->minNumber && $this->nbSentences <= $this->maxNumber;
    }

    protected function isParagraphsNumberValid(): bool
    {
        return $this->nbParagraphs >= $this->minNumber && $this->nbParagraphs <= $this->maxNumber;
    }

    protected function getVariableSentencesNumber(): int
    {
        $min = (int) ($this->nbSentences * (1 - $this->variablePercentage));
        $max = (int) ($this->nbSentences * (1 + $this->variablePercentage));

        $sentencesNumber = random_int($min, $max);

        if ($sentencesNumber < $this->minNumber) {
            return $this->minNumber;
        }

        if ($sentencesNumber > $this->maxNumber) {
            return $this->maxNumber;
        }

        return $sentencesNumber;
    }

    protected function shouldBeText(): bool
    {
        return $this->nbParagraphs === 1 || $this->asText;
    }

    /**
     * @return list<string>
     */
    protected function getRandomParagraphs(): array
    {
        $paragraphs = [];

        for ($i = 1; $i <= $this->nbParagraphs; $i++) {
            $sentencesNumber = $this->variableNbSentences ? $this->getVariableSentencesNumber() : $this->nbSentences;

            $paragraphs[] = $this->getParagraph($sentencesNumber);
        }

        return $paragraphs;
    }

    protected function getParagraph(int $sentencesNumber): string
    {
        /** @var string */
        return $this->sentenceFaker->shouldReturnString($this->nbWords, $sentencesNumber)->generate();
    }
}
