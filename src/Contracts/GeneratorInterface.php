<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Contracts;

/**
 * This interface defines the public contract for the package,
 * including final methods and their respective arguments.
 * All implementing classes must adhere to this contract.
 */
interface GeneratorInterface
{
    /**
     * Get a random person's title
     *
     * @param  string|null  $gender  The gender can be either 'male' or 'female'.
     *
     * @example 'آقای','خانم'
     */
    public function title(?string $gender = null): string;

    /**
     * Get a random male title
     *
     * @example 'آقای'
     */
    public function titleMale(): string;

    /**
     * Get a random female title
     *
     * @example 'خانم'
     */
    public function titleFemale(): string;

    /**
     * Get a random person's first name
     *
     * @param  string|null  $gender  The gender can be either 'male' or 'female'.
     *
     * @example 'علی محمد', 'عاطفه'
     */
    public function firstName(?string $gender = null): string;

    /**
     * Get a random male first name
     *
     * @example 'علی محمد'
     */
    public function firstNameMale(): string;

    /**
     * Get a random female first name
     *
     * @example 'عاطفه'
     */
    public function firstNameFemale(): string;

    /**
     * Get a random person's last name
     *
     * @example 'یاوری', 'ایزدی'
     */
    public function lastName(): string;

    /**
     * Get a random person's full name
     *
     * @param  string|null  $gender  The gender can be either 'male' or 'female'.
     *
     * @example 'علی محمد یاوری', 'عاطفه ایزدی'
     */
    public function name(?string $gender = null): string;

    /**
     * Get a random secondary address
     *
     * @example 'واحد 18' , 'طبقه 3' , 'سوئیت 4'
     */
    public function secondaryAddress(): string;

    /**
     * Get a random state in Iran
     *
     * @example 'یزد' , 'کردستان' , 'سیستان و بلوچستان'
     */
    public function state(): string;

    /**
     * Get a random city in Iran
     *
     * @example 'یزد' , 'سقز' , 'زاهدان'
     */
    public function city(): string;

    /**
     * Get a random street name in Iran
     *
     * @example 'شهر زیبا' , 'بلوار آسمان' , 'شهرک امید'
     */
    public function streetName(): string;

    /**
     * Get a random address in Iran
     *
     * @example 'بلوار خلیج فارس، خیابان لاله زار، خیابان پیروزی، کوچه چشمه نور، پلاک 425'
     */
    public function address(): string;

    /**
     * Get a random postal code in Iran
     *
     * @example '1234567890', '12345-67890'
     */
    public function postCode(bool $withSeparator = false): string;

    /**
     * Get a random state phone prefix in Iran
     *
     * @example '035', '021', '013'
     */
    public function statePhonePrefix(): string;

    /**
     * Get a random phone number in Iran
     *
     * @param  string  $separator  The separator between the state prefix and the phone number.
     * @param  string|null  $state  The name of the state in Iran. See https://github.com/amyavari/persian-faker-php?tab=readme-ov-file#phone
     *
     * @example '03512345678', '02112345678', '035-12345678', '013 12345678'
     */
    public function phoneNumber(string $separator = '', ?string $state = null): string;

    /**
     * Get a random cell phone number in Iran
     *
     * @param  string  $separator  The separator between the mobile provider prefix, the first three digits, and the last four digits.
     * @param  string|null  $provider  The name of the mobile provider in Iran. See https://github.com/amyavari/persian-faker-php?tab=readme-ov-file#phone
     *
     * @example '09121234567', '09301234567', '0912-123-4567', '0912 123 4567'
     */
    public function cellPhone(string $separator = '', ?string $provider = null): string;

    /**
     * Get a random company name in Iran
     *
     * @example 'گروه نگاه', 'آینده سازان راه امید'
     */
    public function company(): string;

    /**
     * Get a random company catchphrase
     *
     * @example 'پیشرو در خدمات طراحی وب', 'یک قدم تا دنیای دیجیتال'
     */
    public function catchphrase(): string;

    /**
     * Get a random job title
     *
     * @example 'برنامه نویس PHP', 'مدیر محصول'
     */
    public function jobTitle(): string;
}
