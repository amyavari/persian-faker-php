<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Payment;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidBankNameException;
use RangeException;
use TypeError;

/**
 * @internal
 *
 * Generates a random Iran's account Sheba numbe.
 *
 * @implements FakerInterface<string>
 */
final class ShebaFaker implements FakerInterface
{
    /**
     * @use Arrayable<string>
     * @use Randomable<string>
     */
    use Arrayable, Randomable;

    /**
     * @var array<string, string>>
     */
    protected array $bankCodes;

    /**
     * @param  DataLoaderInterface<string, string>  $loader
     * @param  bool  $withIR  Determines whether the output should include 'IR' (true) or not (false)
     * @param  string  $separator  The separator used to format the Sheba number in its standard representation.
     * @param  string|null  $bank  The name of the bank in Iran. See ./src/data/payment.php
     */
    public function __construct(DataLoaderInterface $loader, protected bool $withIR = true, protected string $separator = '', protected ?string $bank = null)
    {
        $this->bankCodes = $loader->get();
    }

    /**
     * This returns a fake Iran's account Sheba number.
     *
     * @throws InvalidBankNameException
     */
    public function generate(): string
    {
        if (! $this->isBankValid()) {
            throw new InvalidBankNameException(sprintf('The bank name %s is not a valid bank name.', $this->bank));
        }

        $bankCode = $this->getBankCode();

        $accountNumber = $this->generateRandomAccountNumber();

        $formattedAccountNum = $this->fillEmptyPlaces($accountNumber);

        $accountType = '0'; // It's usual

        $checkNumber = $this->calculateCheckNumber($bankCode.$accountType.$formattedAccountNum);

        return $this->formatShebaNumber($bankCode, $accountType, $formattedAccountNum, $checkNumber);
    }

    protected function isBankValid(): bool
    {
        if (is_null($this->bank)) {
            return true;
        }

        return array_key_exists($this->bank, $this->bankCodes);
    }

    protected function getBankCode(): string
    {
        return is_null($this->bank) ? $this->getOneRandomElement($this->bankCodes) : $this->bankCodes[$this->bank];
    }

    protected function generateRandomAccountNumber(): string
    {
        return random_int(100_000_000, 999_999_999).random_int(0, 999_999);
    }

    protected function fillEmptyPlaces(string $number): string
    {
        return mb_str_pad($number, 18, '0', STR_PAD_LEFT);
    }

    /**
     * To see Iran's Bank Card Number Validation algorithm, please check \Tests\Fakers\Payment\ShebaFakerTest.
     *
     * @throws RangeException
     * @throws TypeError
     */
    protected function calculateCheckNumber(string $digits): string
    {
        if (mb_strlen($digits) !== 22) {
            throw new RangeException(
                sprintf('The input number must have 22 digits, %s-digit number is given.', mb_strlen($digits))
            );
        }

        if (! is_numeric($digits)) {
            throw new TypeError(
                sprintf('The input must be numeric. %s is given.', get_debug_type($digits))
            );
        }

        /*
        / Summary of Check Number Calculation Algorithm:
        /
        / 1. Concatenate the 22-digit bank and account number, the numeric value of the country code (1827), and '00'.
        / 2. Calculate the remainder of the division of this number by 97
        / 3. Calculate the check Number by subtracting the modulus result from 98.
        /   - If the check Number is a single digit, pad it with a leading zero.
        */

        $preparedNumber = $digits.'1827'.'00';

        $reminder = bcmod($preparedNumber, '97');

        $checkNumberValue = 98 - $reminder;

        return mb_str_pad((string) $checkNumberValue, 2, '0', STR_PAD_LEFT);
    }

    protected function formatShebaNumber(string $bankCode, string $accountType, string $shebaNumber, string $checkNumber): string
    {
        $fullShebaNumber = 'IR'.$checkNumber.$bankCode.$accountType.$shebaNumber;

        $chunks = mb_str_split($fullShebaNumber, 4);

        $fullFormatted = $this->convertToString($chunks, $this->separator);

        return $this->withIR ? $fullFormatted : mb_substr($fullFormatted, 2);
    }
}
