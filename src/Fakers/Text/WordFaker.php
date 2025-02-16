<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Text;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;

/**
 * Generates fake word(s)
 *
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string|list<string>>
 */
class WordFaker implements FakerInterface
{
    /**
     * @use \AliYavari\PersianFaker\Cores\Arrayable<string>
     * @use \AliYavari\PersianFaker\Cores\Randomable<int, string>
     */
    use Arrayable, Randomable;

    /**
     * @var list<string>
     */
    protected array $words;

    protected int $maxNumber = 100;

    protected int $minNumber = 1;

    protected string $separator = ' ';

    /**
     * @param  \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string>  $loader
     * @param  int  $nbWords  The number of words to be returned.
     * @param  bool  $asText  Whether the words should be returned as a string (true) or as an array (false).
     */
    public function __construct(
        protected DataLoaderInterface $loader,
        protected int $nbWords = 1,
        protected bool $asText = false,
    ) {
        $this->words = $loader->get();
    }

    /**
     * This returns random word(s).
     *
     * If $nbWords is equal to 1, or $asText is true, a single word is returned as a string.
     * If $nbWords is greater than 1, and $asText is false, an array of words is returned.
     *
     * @return string|list<string>
     *
     * @throws \AliYavari\PersianFaker\Exceptions\InvalidElementNumberException
     */
    public function generate(): string|array
    {
        if (! $this->isNumberValid()) {
            throw new InvalidElementNumberException(
                sprintf('The number should be in range %s-%s, %s is given.', $this->minNumber, $this->maxNumber, $this->nbWords)
            );
        }

        $words = $this->getWords();

        return $this->shouldBeText() ? $this->convertToString($words, $this->separator) : $words;
    }

    /**
     * Returns a new instance of this class which is configured
     * to return a string containing $nbWords.
     */
    public function shouldReturnString(int $nbWords): self
    {
        return new self($this->loader, nbWords: $nbWords, asText: true);
    }

    protected function isNumberValid(): bool
    {
        return $this->nbWords >= $this->minNumber && $this->nbWords <= $this->maxNumber;
    }

    /**
     * @return list<string>
     */
    protected function getWords(): array
    {
        return $this->getMultipleRandomElements($this->words, $this->nbWords);
    }

    protected function shouldBeText(): bool
    {
        return $this->nbWords === 1 || $this->asText;
    }
}
