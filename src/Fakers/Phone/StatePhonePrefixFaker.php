<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Phone;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Randomable;

/**
 * @implements \AliYavari\PersianFaker\Contracts\FakerInterface<string>
 */
class StatePhonePrefixFaker implements FakerInterface
{
    /** @use \AliYavari\PersianFaker\Cores\Randomable<string, string> */
    use Randomable;

    /**
     * @var array<string, string>
     */
    protected array $phonePrefixes;

    /**
     * @param  \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, string>  $loader
     */
    public function __construct(DataLoaderInterface $loader)
    {
        $this->phonePrefixes = $loader->get();
    }

    public function generate(): string
    {
        return $this->getRandomPrefix();
    }

    protected function getRandomPrefix(): string
    {
        return $this->getOneRandomElement($this->phonePrefixes);
    }
}
