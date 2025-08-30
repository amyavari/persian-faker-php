<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Colors;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidDataKeyException;

/**
 * @internal
 *
 * Generates a random color name.
 *
 * @phpstan-type Colors array{main: list<string>, all: list<string>}
 *
 * @implements FakerInterface<string>
 */
final class ColorNameFaker implements FakerInterface
{
    /**
     * @use Randomable<string>
     * @use Arrayable<string>
     */
    use Arrayable, Randomable;

    /**
     * @var Colors
     */
    private array $colors;

    /**
     * @param  DataLoaderInterface<string, list<string>>  $loader
     * @param  bool  $onlyMain  Determines whether to return only the main (safe) color or any color.
     */
    public function __construct(private DataLoaderInterface $loader, private bool $onlyMain = false)
    {
        $colors = $loader->get();

        if (! $this->hasNecessaryKeys($colors)) {
            throw new InvalidDataKeyException('The colors array must have "main" and "all" keys.');
        }

        /**
         * @var Colors $colors
         */
        $this->colors = $colors;
    }

    /**
     * This returns a fake color name
     */
    public function generate(): string
    {
        return $this->getOneRandomElement($this->getColors());
    }

    /**
     * @param  array<mixed>  $data
     */
    private function hasNecessaryKeys(array $data): bool
    {
        return array_key_exists('main', $data) && array_key_exists('all', $data);
    }

    /**
     * @return list<string>
     */
    private function getColors(): array
    {
        return $this->onlyMain ? $this->colors['main'] : $this->flatten($this->colors);
    }
}
