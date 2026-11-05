<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Color;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Cores\Randomable;

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
    public function __construct(DataLoaderInterface $loader, private bool $onlyMain = false)
    {
        $this->colors = $loader->get();
    }

    /**
     * This returns a fake color name
     */
    public function generate(): string
    {
        return $this->getOneRandomElement($this->getColors());
    }

    /**
     * @return list<string>
     */
    private function getColors(): array
    {
        return $this->onlyMain ? $this->colors['main'] : $this->flatten($this->colors);
    }
}
