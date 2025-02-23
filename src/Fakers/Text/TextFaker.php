<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Text;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;

/**
 * Generates fake text
 *
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class TextFaker implements FakerInterface
{
    /**
     * @use \AliYavari\PersianFaker\Cores\Arrayable<string>
     * @use \AliYavari\PersianFaker\Cores\Randomable<string>
     */
    use Arrayable, Randomable;

    protected const MAX_NUMBER = 1000;

    protected const MIN_NUMBER = 10;

    protected const SEPARATOR = ' ';

    protected const WORD_LEN_FOR_MIN_CALC = 10;

    /**
     * @var list<string>
     */
    protected array $words;

    /**
     * @param  \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string>  $loader
     * @param  int  $maxNbChars  The maximum number of characters to which the returned text should be limited.
     */
    public function __construct(DataLoaderInterface $loader, protected int $maxNbChars = 10)
    {
        $this->words = $loader->get();
    }

    /**
     * This returns random text.
     *
     * @throws \AliYavari\PersianFaker\Exceptions\InvalidElementNumberException
     */
    public function generate(): string
    {
        if (! $this->isCharsNumberValid()) {
            throw new InvalidElementNumberException(
                sprintf('The number of chars should be in range %s-%s, %s is given.', self::MIN_NUMBER, self::MAX_NUMBER, $this->maxNbChars)
            );
        }

        $words = $this->getMultipleRandomElements($this->words, $this->getMinNumberOfWords());

        while (true) {
            if (! $this->isWithinCharLimit($words)) {
                $words = $this->removeExtraWords($words);

                break;
            }

            $words[] = $this->getOneRandomElement($this->words);
        }

        return $this->convertToString($words, self::SEPARATOR);
    }

    protected function isCharsNumberValid(): bool
    {
        return $this->maxNbChars >= self::MIN_NUMBER && $this->maxNbChars <= self::MAX_NUMBER;
    }

    protected function getMinNumberOfWords(): int
    {
        return (int) ($this->maxNbChars / self::WORD_LEN_FOR_MIN_CALC);
    }

    /**
     * @param  list<string>  $words
     */
    protected function isWithinCharLimit(array $words): bool
    {
        return strlen($this->convertToString($words, self::SEPARATOR)) <= $this->maxNbChars;
    }

    /**
     * @param  list<string>  $words
     * @return list<string>
     */
    protected function removeExtraWords(array $words): array
    {
        while (true) {
            if (! $this->isWithinCharLimit($words)) {
                array_pop($words);

                continue;
            }

            return $words;
        }
    }
}
