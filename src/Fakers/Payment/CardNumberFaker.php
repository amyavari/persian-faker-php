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
 * Generates a random Iran's bank card number.
 *
 * @implements FakerInterface<string>
 */
final class CardNumberFaker implements FakerInterface
{
    /**
     * @use Arrayable<string>
     * @use Randomable<string>
     */
    use Arrayable, Randomable;

    /**
     * @var array<string, string>>
     */
    protected array $bankBins;

    /**
     * @param  DataLoaderInterface<string, string>  $loader
     * @param  string  $separator  The separator between the each four digits.
     * @param  string|null  $bank  The name of the bank in Iran. See ./src/data/payment.php
     */
    public function __construct(DataLoaderInterface $loader, protected string $separator = '', protected ?string $bank = null)
    {
        $this->bankBins = $loader->get();
    }

    /**
     * This returns a fake Iran's bank card number.
     *
     * @throws InvalidBankNameException
     */
    public function generate(): string
    {
        if (! $this->isBankValid()) {
            throw new InvalidBankNameException(sprintf('The bank name %s is not a valid bank name.', $this->bank));
        }

        $bankBin = $this->getBin();

        $cardNumber = $this->generateRandomCardNumber();

        $checkDigit = $this->calculateCheckDigit($bankBin.$cardNumber);

        return $this->formatCardNumber($bankBin, $cardNumber, $checkDigit);
    }

    protected function isBankValid(): bool
    {
        if (is_null($this->bank)) {
            return true;
        }

        return array_key_exists($this->bank, $this->bankBins);
    }

    protected function getBin(): string
    {
        return is_null($this->bank) ? $this->getOneRandomElement($this->bankBins) : $this->bankBins[$this->bank];
    }

    protected function generateRandomCardNumber(): int
    {
        return random_int(100_000_000, 999_999_999);
    }

    /**
     * To see Iran's Bank Card Number Validation algorithm, please check \Tests\Fakers\Payment\CardNumberFakerTest.
     *
     * @throws RangeException
     * @throws TypeError
     */
    protected function calculateCheckDigit(string $digits): int
    {
        if (mb_strlen($digits) !== 15) {
            throw new RangeException(
                sprintf('The input number must have 15 digits, %s-digit number is given.', mb_strlen($digits))
            );
        }

        if (! is_numeric($digits)) {
            throw new TypeError(
                sprintf('The input must be numeric. %s is given.', get_debug_type($digits))
            );
        }

        $sum = 0;
        foreach (mb_str_split($digits) as $key => $value) {
            $multipleBy = (($key + 1) % 2 === 0) ? 1 : 2;

            $product = (int) $value * $multipleBy;

            if ($product >= 10) {
                $product -= 9;
            }

            $sum += $product;
        }

        if ($sum % 10 === 0) {
            return 0;
        }

        $higherMultipleOf10 = (intdiv($sum, 10) + 1) * 10;

        return $higherMultipleOf10 - $sum;
    }

    protected function formatCardNumber(string $bankBin, int $cardNumber, int $checkDigit): string
    {
        $fullCardNumber = $bankBin.$cardNumber.$checkDigit;

        $chunks = mb_str_split($fullCardNumber, 4);

        return $this->convertToString($chunks, $this->separator);
    }
}
