<?php

declare(strict_types=1);

use AliYavari\PersianFaker\Exceptions\InvalidBankNameException;

// The bank names in the docs: docs/en/07-payment.md (cardNumber and shebaNumber)
dataset('banks', [
    'melli' => ['bank' => 'melli'],
    'sepah' => ['bank' => 'sepah'],
    'tos_e_saderat' => ['bank' => 'tos_e_saderat'],
    'sanat_madan' => ['bank' => 'sanat_madan'],
    'keshavarzi' => ['bank' => 'keshavarzi'],
    'maskan' => ['bank' => 'maskan'],
    'saderat' => ['bank' => 'saderat'],
    'post_bank' => ['bank' => 'post_bank'],
    'mellat' => ['bank' => 'mellat'],
    'tejarat' => ['bank' => 'tejarat'],
    'refah' => ['bank' => 'refah'],
    'parsian' => ['bank' => 'parsian'],
    'noor' => ['bank' => 'noor'],
    'pasargad' => ['bank' => 'pasargad'],
    'melal' => ['bank' => 'melal'],
    'ghavamin' => ['bank' => 'ghavamin'],
    'mehr_iran' => ['bank' => 'mehr_iran'],
    'karafarin' => ['bank' => 'karafarin'],
    'gardeshgari' => ['bank' => 'gardeshgari'],
    'saman' => ['bank' => 'saman'],
    'sina' => ['bank' => 'sina'],
    'sarmaye' => ['bank' => 'sarmaye'],
    'shahr' => ['bank' => 'shahr'],
    'dey' => ['bank' => 'dey'],
    'eghtesad_novin' => ['bank' => 'eghtesad_novin'],
    'ansar' => ['bank' => 'ansar'],
    'iran_zamin' => ['bank' => 'iran_zamin'],
    'taavon' => ['bank' => 'taavon'],
]);

it('returns a bank name from the data file', function (): void {
    expect(persian_faker()->bank())
        ->toBeIn(fakerData('payment.bank_names'));
});

it('returns a valid card number of any bank', function (): void {
    $cardNumber = persian_faker()->cardNumber();

    expect($cardNumber)
        ->toBeDigits()
        ->toHaveLength(16)
        ->toEndWith(cardNumberCheckDigit($cardNumber));

    expect(mb_substr($cardNumber, 0, 6)) // The first six digits are the bank BIN
        ->toBeIn(fakerData('payment.bank_bins'));
})->repeat(50); // One run can miss the check digit 0

it('returns a valid card number of the given bank', function (string $bank): void {
    $cardNumber = persian_faker()->cardNumber(bank: $bank);

    expect($cardNumber)
        ->toBeDigits()
        ->toHaveLength(16)
        ->toStartWith(fakerValue("payment.bank_bins.{$bank}"))
        ->toEndWith(cardNumberCheckDigit($cardNumber));
})->with('banks');

it('returns a card number with the given separator', function (): void {
    expect(persian_faker()->cardNumber(separator: '-'))
        ->toMatch('/^\d{4}-\d{4}-\d{4}-\d{4}$/');
});

it('throws an exception for a card number with an invalid bank', function (): void {
    expect(fn (): string => persian_faker()->cardNumber(bank: 'anonymous'))
        ->toThrow(InvalidBankNameException::class, 'The bank name anonymous is not a valid bank name.');
});

it('returns a Sheba number with IR by default and without IR on request', function (): void {
    expect(persian_faker()->shebaNumber())
        ->toMatch('/^IR\d{24}$/');

    expect(persian_faker()->shebaNumber(withIR: false))
        ->toMatch('/^\d{24}$/');
});

it('returns a valid Sheba number of any bank', function (): void {
    $shebaNumber = persian_faker()->shebaNumber(withIR: false); // The flag only removes "IR", to keep the assertions simple

    expect($shebaNumber)
        ->toBeDigits()
        ->toHaveLength(24);

    expect(shebaNumberRemainder($shebaNumber))
        ->toBe(1); // A valid Sheba number always gives 1

    expect(mb_substr($shebaNumber, 2, 3)) // The three digits after the check number are the bank code
        ->toBeIn(fakerData('payment.bank_sheba_codes'));
})->repeat(50); // One run can miss a one-digit check number

it('returns a valid Sheba number of the given bank', function (string $bank): void {
    $shebaNumber = persian_faker()->shebaNumber(withIR: false, bank: $bank); // The flag only removes "IR", to keep the assertions simple

    expect($shebaNumber)
        ->toBeDigits()
        ->toHaveLength(24);

    expect(shebaNumberRemainder($shebaNumber))
        ->toBe(1); // A valid Sheba number always gives 1

    expect(mb_substr($shebaNumber, 2, 3)) // The three digits after the check number are the bank code
        ->toBe(fakerValue("payment.bank_sheba_codes.{$bank}"));
})->with('banks');

it('returns a Sheba number with the given separator', function (): void {
    expect(persian_faker()->shebaNumber(separator: '-'))
        ->toMatch('/^IR\d{2}-\d{4}-\d{4}-\d{4}-\d{4}-\d{4}-\d{2}$/');

    expect(persian_faker()->shebaNumber(withIR: false, separator: '-'))
        ->toMatch('/^\d{2}-\d{4}-\d{4}-\d{4}-\d{4}-\d{4}-\d{2}$/');
});

it('throws an exception for a Sheba number with an invalid bank', function (): void {
    expect(fn (): string => persian_faker()->shebaNumber(bank: 'anonymous'))
        ->toThrow(InvalidBankNameException::class, 'The bank name anonymous is not a valid bank name.');
});

// ------------
// Helpers
// ------------

/**
 * Calculate the check digit (the last digit) of an Iranian bank card number.
 *
 * Iran's Bank Card Number Validation Algorithm:
 * Iranian bank card number is a 16-digit number.
 * The 16th digit is known as the check digit.
 * To calculate the check digit, follow these steps:
 *
 * 1. Multiply each of the first 15 digits by either 1 or 2, based on its positional value.
 *    - Positions start at 1 for the leftmost digit.
 *    - If the position is odd, multiply the digit by 2.
 *    - If the position is even, multiply the digit by 1.
 * 2. If the result of any multiplication is a two-digit number (greater than 9),
 *    add the digits together to reduce it to a single digit (or equivalently, subtract 9 from the result).
 * 3. Sum all the results from the previous step.
 * 4. The check digit is the smallest number that, when added to the sum,
 *    results in a multiple of 10. In other words, subtract the sum from the
 *    nearest higher multiple of 10 to get the check digit.
 */
function cardNumberCheckDigit(string $cardNumber): string
{
    $firstFifteenDigits = mb_str_split(mb_substr($cardNumber, 0, 15));

    $sum = 0;

    foreach ($firstFifteenDigits as $index => $digit) {
        $position = $index + 1;
        $multiplier = $position % 2 === 1 ? 2 : 1;

        $product = (int) $digit * $multiplier;

        if ($product > 9) {
            $product -= 9;
        }

        $sum += $product;
    }

    $remainder = $sum % 10;

    $checkDigit = $remainder === 0 ? 0 : 10 - $remainder;

    return (string) $checkDigit;
}

/**
 * Calculate the remainder of an Iranian Sheba number (without 'IR') divided by 97. A valid Sheba number gives 1.
 *
 * Iran's Sheba Number Validation Algorithm:
 * It follows the International Bank Account Number (IBAN) standard with some specific rules:
 * - It is a 26-character string starting with 'IR' (the country code for Iran).
 * - The remaining characters are numeric and consist of:
 *   - A two-digit check number
 *   - A three-digit bank identifier code
 *   - A one-digit account type identifier (usually 0)
 *   - An eighteen-digit bank account number (left-padded with zeros if necessary)
 *
 * For the full validation/creation algorithm, see:
 * https://en.wikipedia.org/wiki/International_Bank_Account_Number
 *
 * Summary of Validation Algorithm:
 * 1. Concatenate the 22-digit bank and account number, the numeric value of the country code,
 *    and the 2-digit check number.
 * 2. Calculate the remainder of the division of this number by 97 — it should equal 1.
 *
 * Note: As the IBAN standard, 'IR' converts to 1827.
 */
function shebaNumberRemainder(string $shebaNumberWithoutIR): int
{
    $checkNumber = mb_substr($shebaNumberWithoutIR, 0, 2);
    $bankAndAccountNumber = mb_substr($shebaNumberWithoutIR, 2);

    $countryCode = '1827'; // 'IR' as numbers

    return (int) bcmod($bankAndAccountNumber.$countryCode.$checkNumber, '97');
}
