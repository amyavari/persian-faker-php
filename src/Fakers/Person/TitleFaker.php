<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Person;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidGenderException;

/**
 * @internal
 *
 * Generates a random title in Persian language.
 *
 * @implements FakerInterface<string>
 */
final class TitleFaker implements FakerInterface
{
    /**
     * @use Randomable<string>
     * @use Arrayable<string>
     */
    use Arrayable, Randomable;

    /**
     * @var array<string, list<string>>
     */
    private array $titles;

    /**
     * @param  DataLoaderInterface<string, list<string>>  $loader
     * @param  string|null  $gender  The gender can be either 'male' or 'female'.
     */
    public function __construct(DataLoaderInterface $loader, private ?string $gender = null)
    {
        $this->titles = $loader->get();
    }

    /**
     * This returns a fake person's title
     *
     * @throws InvalidGenderException
     */
    public function generate(): string
    {
        if (! $this->isGenderValid()) {
            throw new InvalidGenderException(sprintf('The gender %s is not valid.', $this->gender));
        }

        return $this->getOneRandomElement($this->getTitles());
    }

    private function isGenderValid(): bool
    {
        if (is_null($this->gender)) {
            return true;
        }

        return array_key_exists($this->gender, $this->titles);
    }

    /**
     * @return list<string>
     */
    private function getTitles(): array
    {
        return is_null($this->gender) ? $this->flatten($this->titles) : $this->titles[$this->gender];
    }
}
