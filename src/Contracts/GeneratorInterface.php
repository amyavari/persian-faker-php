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

    /**
     * Get random person first name
     *
     * @param  string|null  $gender  The gender can be either 'male' or 'female'
     */
    public function firstName(?string $gender = null): string;

    /**
     * Get random male first name
     */
    public function firstNameMale(): string;

    /**
     * Get random female first name
     */
    public function firstNameFemale(): string;

    /**
     * Get random person last name
     */
    public function lastName(): string;

    /**
     * Get random person full name
     *
     * @param  string|null  $gender  The gender can be either 'male' or 'female'
     */
    public function name(?string $gender = null): string;
}
