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
     * @use \AliYavari\PersianFaker\Cores\Randomable<string>
     */
    use Arrayable, Randomable;

    /**
     * @var list<string>
     */
    protected array $words;

    protected const MAX_NUMBER = 100;

    protected const MIN_NUMBER = 1;

    protected const SEPARATOR = ' ';

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
     * If $nbWords is equal to 1, or $asText is true, the word(s) are returned as a string.
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
                sprintf('The number should be in range %s-%s, %s is given.', self::MIN_NUMBER, self::MAX_NUMBER, $this->nbWords)
            );
        }

        $words = $this->getWords();

        return $this->shouldBeText() ? $this->convertToString($words, self::SEPARATOR) : $words;
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
        return $this->nbWords >= self::MIN_NUMBER && $this->nbWords <= self::MAX_NUMBER;
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
