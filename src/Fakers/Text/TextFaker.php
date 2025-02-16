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
     * @use \AliYavari\PersianFaker\Cores\Randomable<int, string>
     */
    use Arrayable, Randomable;

    protected int $maxNumber = 1000;

    protected int $minNumber = 10;

    protected string $separator = ' ';

    protected int $wordLenForMinCalc = 10;

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
                sprintf('The number of chars should be in range %s-%s, %s is given.', $this->minNumber, $this->maxNumber, $this->maxNbChars)
            );
        }

        $words = $this->getMultipleRandomElements($this->words, $this->getMinNumberOfWords());

        while (true) {

            if (! $this->isWithinCharLimit($words)) {
                $words = $this->removeExtraWord($words);

                break;
            }

            $words[] = $this->getOneRandomElement($this->words);
        }

        return $this->convertToString($words, $this->separator);
    }

    protected function isCharsNumberValid(): bool
    {
        return $this->maxNbChars >= $this->minNumber && $this->maxNbChars <= $this->maxNumber;
    }

    protected function getMinNumberOfWords(): int
    {
        return (int) ($this->maxNbChars / $this->wordLenForMinCalc);
    }

    /**
     * @param  list<string>  $words
     */
    protected function isWithinCharLimit(array $words): bool
    {
        return strlen($this->convertToString($words, $this->separator)) <= $this->maxNbChars;
    }

    /**
     * @param  list<string>  $words
     * @return list<string>
     */
    protected function removeExtraWord(array $words): array
    {
        array_pop($words);

        return $words;
    }
}
