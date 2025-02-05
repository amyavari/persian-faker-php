<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Contracts;

interface GeneratorInterface
{
    /**
     * Get random person title
     *
     * @param  string|null  $gender  The gender can be either 'male' or 'female'
     */
    public function title(?string $gender = null): string;

    /**
     * Get random male title
     */
    public function titleMale(): string;

    /**
     * Get random female title
     */
    public function titleFemale(): string;
}
