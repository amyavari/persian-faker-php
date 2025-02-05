<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Contracts;

/**
 * @template TValue
 */
interface FakerInterface
{
    /**
     * This method returns the fake value
     *
     * @return TValue
     */
    public function generate();
}
