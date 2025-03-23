<?php

declare(strict_types=1);

namespace Tests\Fakers\Payment;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidBankNameException;
use AliYavari\PersianFaker\Fakers\Payment\CardNumberFaker;
use Mockery;
use RangeException;
use Tests\TestCase;
use TypeError;

class CardNumberFakerTest extends TestCase
{
    use Randomable;

    protected $loader;

    protected array $banksBins = ['bank1' => '123456', 'bank2' => '234567', 'bank3' => '456789'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->banksBins);
    }

    public function test_bank_validation_passes_with_null_bank_name(): void
    {
        $faker = new CardNumberFaker($this->loader, bank: null);
        $isValid = $this->callProtectedMethod($faker, 'isBankValid');

        $this->assertTrue($isValid);
    }

    public function test_bank_validation_passes_with_existed_bank_name(): void
    {
        $bank = array_rand($this->banksBins);

        $faker = new CardNumberFaker($this->loader, bank: $bank);
        $isValid = $this->callProtectedMethod($faker, 'isBankValid');

        $this->assertTrue($isValid);
    }

    public function test_bank_validation_fails_with_not_existed_bank_name(): void
    {
        $faker = new CardNumberFaker($this->loader, bank: 'newName');
        $isValid = $this->callProtectedMethod($faker, 'isBankValid');

        $this->assertFalse($isValid);
    }

    public function test_it_returns_random_bin_when_bank_name_is_null_or_not_set(): void
    {
        $faker = new CardNumberFaker($this->loader, bank: null);
        $bin = $this->callProtectedMethod($faker, 'getBin');

        $this->assertContains($bin, $this->banksBins);
    }

    public function test_it_returns_specific_bin_when_bank_name_is_set(): void
    {
        $bank = array_rand($this->banksBins);

        $faker = new CardNumberFaker($this->loader, bank: $bank);
        $bin = $this->callProtectedMethod($faker, 'getBin');

        $this->assertSame($this->banksBins[$bank], $bin);
    }

    public function test_it_generate_random_nine_digit_number(): void
    {
        $faker = new CardNumberFaker($this->loader);
        $number = $this->callProtectedMethod($faker, 'generateRandomCardNumber');

        $this->assertIsNumeric($number);
        $this->assertSame(9, strlen((string) $number));
    }

    public function test_it_calculate_check_digit(): void
    {
        $number = random_int(100000000000000, 999999999999999);

        $faker = new CardNumberFaker($this->loader);
        $checkDigit = $this->callProtectedMethod($faker, 'calculateCheckDigit', [$number]);

        $this->assertTrue($this->isCheckDigitValid($number, $checkDigit));
    }

    public function test_it_calculate_check_digit_if_sum_is_multiple_of_ten(): void
    {
        $faker = new CardNumberFaker($this->loader);
        $checkDigit = $this->callProtectedMethod($faker, 'calculateCheckDigit', [456789777221862]);

        $this->assertSame(0, $checkDigit);
    }

    public function test_it_throws_an_exception_if_input_number_is_less_than_fifteen_digits(): void
    {
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('The input number must have 15 digits, 14-digit number is given.');

        $faker = new CardNumberFaker($this->loader);
        $this->callProtectedMethod($faker, 'calculateCheckDigit', ['12345678901234']);
    }

    public function test_it_throws_an_exception_if_input_number_is_more_than_fifteen_digits(): void
    {
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('The input number must have 15 digits, 16-digit number is given.');

        $faker = new CardNumberFaker($this->loader);
        $this->callProtectedMethod($faker, 'calculateCheckDigit', ['1234567890123456']);
    }

    public function test_throws_an_exception_if_input_number_is_not_numeric(): void
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('The input must be numeric. string is given.');

        $faker = new CardNumberFaker($this->loader);
        $this->callProtectedMethod($faker, 'calculateCheckDigit', ['a23456789012345']);
    }

    public function test_it_formats_card_number(): void
    {
        $separator = $this->getOneRandomElement(['', ' ', '-']);

        $faker = new CardNumberFaker($this->loader, separator: $separator);
        $formattedNumber = $this->callProtectedMethod($faker, 'formatCardNumber', ['123456', 789012345, 6]);

        $this->assertSame("1234{$separator}5678{$separator}9012{$separator}3456", $formattedNumber);
    }

    public function test_it_returns_fake_card_number_for_random_bank(): void
    {
        $faker = new CardNumberFaker($this->loader);
        $cardNumber = $faker->generate();

        $this->assertIsString($cardNumber);
        $this->assertIsNumeric($cardNumber);
        $this->assertSame(16, strlen($cardNumber));
        $this->assertContains(substr($cardNumber, 0, 6), $this->banksBins);
        $this->assertTrue($this->isCheckDigitValid((int) substr($cardNumber, 0, 15), substr($cardNumber, -1)));
    }

    public function test_it_returns_fake_card_number_for_specific_bank(): void
    {
        $bank = array_rand($this->banksBins);

        $faker = new CardNumberFaker($this->loader, bank: $bank);
        $cardNumber = $faker->generate();

        $this->assertIsString($cardNumber);
        $this->assertIsNumeric($cardNumber);
        $this->assertSame(16, strlen($cardNumber));
        $this->assertSame($this->banksBins[$bank], substr($cardNumber, 0, 6));
        $this->assertTrue($this->isCheckDigitValid((int) substr($cardNumber, 0, 15), substr($cardNumber, -1)));
    }

    public function test_it_returns_fake_card_number_with_specific_separator(): void
    {
        $faker = new CardNumberFaker($this->loader, separator: '-');
        $cardNumber = $faker->generate();

        $this->assertIsString($cardNumber);
        $this->assertMatchesRegularExpression('/^\d{4}\-\d{4}\-\d{4}\-\d{4}$/', $cardNumber);

        $cardNumberDigits = str_replace('-', '', $cardNumber);
        $this->assertContains(substr($cardNumberDigits, 0, 6), $this->banksBins);
        $this->assertTrue($this->isCheckDigitValid((int) substr($cardNumberDigits, 0, 15), substr($cardNumberDigits, -1)));
    }

    public function test_it_throws_an_exception_if_bank_name_is_not_valid(): void
    {
        $faker = new CardNumberFaker($this->loader, bank: 'anonymous');

        $this->expectException(InvalidBankNameException::class);
        $this->expectExceptionMessage('The bank name anonymous is not a valid bank name.');

        $faker->generate();
    }

    // ----------------
    // Helper Methods
    // ----------------

    private function isCheckDigitValid(int $digits, string|int $checkDigit): bool
    {
        /*
        /-------------------------------------
        / Iran's Bank Card Number Validation Algorithm
        /-------------------------------------
        / Iranian bank card number is a 16-digit number.
        / The 16th digit is known as the check digit.
        / To calculate the check digit, follow these steps:
        /
        / 1. Multiply each of the first 15 digits by either 1 or 2, based on its positional value.
        /    - Positions start at 1 for the leftmost digit.
        /    - If the position is odd, multiply the digit by 2.
        /    - If the position is even, multiply the digit by 1.
        / 2. If the result of any multiplication is a two-digit number (greater than 9),
        /    add the digits together to reduce it to a single digit (or equivalently, subtract 9 from the result).
        / 3. Sum all the results from the previous step.
        / 4. The check digit is the smallest number that, when added to the sum,
        /    results in a multiple of 10. In other words, subtract the sum from the
        /    nearest higher multiple of 10 to get the check digit.
        */

        $sum = 0;
        foreach (str_split((string) $digits) as $key => $value) {
            $multipleBy = (($key + 1) % 2 === 0) ? 1 : 2;

            $product = $value * $multipleBy;

            if ($product >= 10) {
                $product -= 9;
            }

            $sum += $product;
        }

        if ($sum % 10 === 0) {
            return $checkDigit == 0;
        }

        $multipleOf10 = (intdiv($sum, 10) + 1) * 10;

        return $multipleOf10 - $sum == $checkDigit;
    }
}
