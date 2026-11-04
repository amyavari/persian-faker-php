<?php

declare(strict_types=1);

use AliYavari\PersianFaker\Exceptions\InvalidGenderException;
use AliYavari\PersianFaker\Exceptions\InvalidStateNameException;

dataset('genders', [
    'male' => ['gender' => 'male'],
    'female' => ['gender' => 'female'],
]);

it('returns a title of any gender', function (): void {
    expect(persian_faker()->title())
        ->toBeIn(fakerData('person.titles', merge: true));
});

it('returns a male title', function (): void {
    $maleTitles = fakerData('person.titles.male');

    expect(persian_faker()->title(gender: 'male'))
        ->toBeIn($maleTitles);

    expect(persian_faker()->titleMale())
        ->toBeIn($maleTitles);
});

it('returns a female title', function (): void {
    $femaleTitles = fakerData('person.titles.female');

    expect(persian_faker()->title(gender: 'female'))
        ->toBeIn($femaleTitles);

    expect(persian_faker()->titleFemale())
        ->toBeIn($femaleTitles);
});

it('throws an exception for a title with an invalid gender', function (): void {
    expect(fn (): string => persian_faker()->title(gender: 'anonymous'))
        ->toThrow(InvalidGenderException::class, 'The gender anonymous is not valid.');
});

it('returns a first name of any gender', function (): void {
    expect(persian_faker()->firstName())
        ->toBeIn(fakerData('person.first_names', merge: true));
});

it('returns a male first name', function (): void {
    $maleFirstNames = fakerData('person.first_names.male');

    expect(persian_faker()->firstName(gender: 'male'))
        ->toBeIn($maleFirstNames);

    expect(persian_faker()->firstNameMale())
        ->toBeIn($maleFirstNames);
});

it('returns a female first name', function (): void {
    $femaleFirstNames = fakerData('person.first_names.female');

    expect(persian_faker()->firstName(gender: 'female'))
        ->toBeIn($femaleFirstNames);

    expect(persian_faker()->firstNameFemale())
        ->toBeIn($femaleFirstNames);
});

it('throws an exception for a first name with an invalid gender', function (): void {
    expect(fn (): string => persian_faker()->firstName(gender: 'anonymous'))
        ->toThrow(InvalidGenderException::class, 'The gender anonymous is not valid.');
});

it('returns a last name', function (): void {
    expect(persian_faker()->lastName())
        ->toBeIn(fakerData('person.last_names'));
});

it('returns a full name of any gender', function (): void {
    expect(persian_faker()->name())
        ->toBeIn(allPossibleFullNames(fakerData('person.first_names', merge: true)));
});

it('returns a full name of the given gender', function (string $gender): void {
    expect(persian_faker()->name(gender: $gender))
        ->toBeIn(allPossibleFullNames(fakerData("person.first_names.{$gender}")));
})->with('genders');

it('throws an exception for a full name with an invalid gender', function (): void {
    expect(fn (): string => persian_faker()->name(gender: 'anonymous'))
        ->toThrow(InvalidGenderException::class, 'The gender anonymous is not valid.');
});

it('returns a valid national code of any state', function (): void {
    $nationalCode = persian_faker()->nationalCode();

    expect($nationalCode)
        ->toBeDigits()
        ->toHaveLength(10)
        ->toEndWith(nationalCodeCheckDigit($nationalCode));

    expect(mb_substr($nationalCode, 0, 3)) // The first three digits are the state prefix
        ->toBeIn(fakerData('person.national_code_state_prefixes', merge: true));
})->repeat(50); // One run can miss one of the two check digit cases

it('returns a valid national code of the given state', function (string $state): void {
    $nationalCode = persian_faker()->nationalCode(state: $state);

    expect($nationalCode)
        ->toBeDigits()
        ->toHaveLength(10)
        ->toEndWith(nationalCodeCheckDigit($nationalCode));

    expect(mb_substr($nationalCode, 0, 3)) // The first three digits are the state prefix
        ->toBeIn(fakerData("person.national_code_state_prefixes.{$state}"));
})->with('states');

it('throws an exception for a national code with an invalid state', function (): void {
    expect(fn (): string => persian_faker()->nationalCode(state: 'anonymous'))
        ->toThrow(InvalidStateNameException::class, 'The state name anonymous is not valid.');
});

// ------------
// Helpers
// ------------

/**
 * Get every possible full name ("first name" + space + "last name") of the given first names.
 *
 * @param  list<string>  $firstNames
 * @return list<string>
 */
function allPossibleFullNames(array $firstNames): array
{
    $lastNames = fakerData('person.last_names');

    $fullNames = [];

    foreach ($firstNames as $firstName) {
        foreach ($lastNames as $lastName) {
            $fullNames[] = sprintf('%s %s', $firstName, $lastName);
        }
    }

    return $fullNames;
}

/**
 * Calculate the check digit (the last digit) of an Iranian national code.
 *
 * Iranian National Code Algorithm:
 * The Iranian National Code is a 10-digit number.
 * The 10th digit is known as the check digit.
 * To calculate the check digit, follow these steps:
 *
 * 1. Multiply each of the first nine digits (from the left) by its positional value,
 *    where the position starts from 1 for the check digit (right-to-left).
 * 2. Sum the results of these multiplications.
 * 3. Divide the total sum by 11.
 * 4. If the remainder is less than 2, it becomes the check digit.
 *    If the remainder is 2 or greater, subtract it from 11 to get the check digit.
 */
function nationalCodeCheckDigit(string $nationalCode): string
{
    $firstNineDigits = mb_str_split(mb_substr($nationalCode, 0, 9));

    $sum = 0;

    foreach ($firstNineDigits as $index => $digit) {
        $position = 10 - $index;
        $sum += (int) $digit * $position;
    }

    $remainder = $sum % 11;

    $checkDigit = $remainder < 2 ? $remainder : 11 - $remainder;

    return (string) $checkDigit;
}
