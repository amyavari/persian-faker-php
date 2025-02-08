<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Contracts;

interface GeneratorInterface
{
    /**
     * Get a random person's title
     *
     * @param  string|null  $gender  The gender can be either 'male' or 'female'.
     */
    public function title(?string $gender = null): string;

    /**
     * Get a random male title
     */
    public function titleMale(): string;

    /**
     * Get a random female title
     */
    public function titleFemale(): string;

    /**
     * Get a random person's first name
     *
     * @param  string|null  $gender  The gender can be either 'male' or 'female'.
     */
    public function firstName(?string $gender = null): string;

    /**
     * Get a random male first name
     */
    public function firstNameMale(): string;

    /**
     * Get a random female first name
     */
    public function firstNameFemale(): string;

    /**
     * Get a random person's last name
     */
    public function lastName(): string;

    /**
     * Get a random person's full name
     *
     * @param  string|null  $gender  The gender can be either 'male' or 'female'.
     */
    public function name(?string $gender = null): string;

    /**
     * Get a random secondary address
     */
    public function secondaryAddress(): string;

    /**
     * Get a random state in Iran
     */
    public function state(): string;

    /**
     * Get a random city in Iran
     */
    public function city(): string;

    /**
     * Get a random street name in Iran
     */
    public function streetName(): string;

    /**
     * Get a random address in Iran
     */
    public function address(): string;

    /**
     * Get a random postal code in Iran
     */
    public function postCode(bool $withSeparator = false): string;
}
