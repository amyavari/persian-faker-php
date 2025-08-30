<?php

declare(strict_types=1);

namespace Tests\Fakers\Payment;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Exceptions\InvalidBankNameException;
use AliYavari\PersianFaker\Fakers\Payment\CardNumberFaker;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use RangeException;
use Tests\TestCase;
use TypeError;

final class CardNumberFakerTest extends TestCase
{
    private $loader;

    private array $banksBins = ['bank1' => '123456', 'bank2' => '234567', 'bank3' => '456789'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->banksBins);
    }

    // ---------------
    // Data Providers
    // ---------------

    /**
     * Provides datasets in the format: `dataset => [int $checkDigit, string $cardNumber]`
     */
    public static function checkDigitsProvider(): iterable
    {
        yield 'products_only_one_digit' => [8, '123412341234123'];

        yield 'products_have_two_digits' => [2, '473745009214726'];

        yield 'sum_is_multiple_of_10' => [0, '456789777221862'];
    }

    /**
     * Provides datasets in the format: `dataset => [string $separator, string $expectedFormat]`
     *
     * Base number is `1234567890123456`
     */
    public static function formatCardNumberSeparatorProvider(): iterable
    {
        yield 'space' => [' ', '1234 5678 9012 3456'];

        yield 'dash' => ['-', '1234-5678-9012-3456'];

        yield 'nothing' => ['', '1234567890123456'];
    }

    #[Test]
    public function bank_validation_passes_with_null_bank_name(): void
    {
        $faker = new CardNumberFaker($this->loader, bank: null);
        $isValid = $this->callProtectedMethod($faker, 'isBankValid');

        $this->assertTrue($isValid);
    }

    #[Test]
    public function bank_validation_passes_with_existed_bank_name(): void
    {
        $faker = new CardNumberFaker($this->loader, bank: 'bank2');
        $isValid = $this->callProtectedMethod($faker, 'isBankValid');

        $this->assertTrue($isValid);
    }

    #[Test]
    public function bank_validation_fails_with_not_existed_bank_name(): void
    {
        $faker = new CardNumberFaker($this->loader, bank: 'newName');
        $isValid = $this->callProtectedMethod($faker, 'isBankValid');

        $this->assertFalse($isValid);
    }

    #[Test]
    public function it_returns_random_bin_when_bank_name_is_null_or_not_set(): void
    {
        $faker = new CardNumberFaker($this->loader, bank: null);
        $bin = $this->callProtectedMethod($faker, 'getBin');

        $this->assertContains($bin, $this->banksBins);
    }

    #[Test]
    public function it_returns_specific_bin_when_bank_name_is_set(): void
    {
        $faker = new CardNumberFaker($this->loader, bank: 'bank2');
        $bin = $this->callProtectedMethod($faker, 'getBin');

        $this->assertSame($this->banksBins['bank2'], $bin);
    }

    #[Test]
    public function it_generate_random_nine_digit_number(): void
    {
        $faker = new CardNumberFaker($this->loader);
        $number = $this->callProtectedMethod($faker, 'generateRandomCardNumber');

        $this->assertIsNumeric($number);
        $this->assertSame(9, mb_strlen((string) $number));
    }

    #[Test]
    #[DataProvider('checkDigitsProvider')]
    public function it_calculate_check_digit(int $checkDigit, string $cardNumber): void
    {
        $faker = new CardNumberFaker($this->loader);
        $calculatedCheckDigit = $this->callProtectedMethod($faker, 'calculateCheckDigit', [$cardNumber]);

        $this->assertSame($checkDigit, $calculatedCheckDigit);
        $this->assertCheckDigit($cardNumber, $checkDigit);
    }

    #[Test]
    public function it_throws_an_exception_if_input_number_is_less_than_fifteen_digits(): void
    {
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('The input number must have 15 digits, 14-digit number is given.');

        $faker = new CardNumberFaker($this->loader);
        $this->callProtectedMethod($faker, 'calculateCheckDigit', ['12345678901234']);
    }

    #[Test]
    public function it_throws_an_exception_if_input_number_is_more_than_fifteen_digits(): void
    {
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('The input number must have 15 digits, 16-digit number is given.');

        $faker = new CardNumberFaker($this->loader);
        $this->callProtectedMethod($faker, 'calculateCheckDigit', ['1234567890123456']);
    }

    #[Test]
    public function throws_an_exception_if_input_number_is_not_numeric(): void
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('The input must be numeric. string is given.');

        $faker = new CardNumberFaker($this->loader);
        $this->callProtectedMethod($faker, 'calculateCheckDigit', ['a23456789012345']);
    }

    #[Test]
    #[DataProvider('formatCardNumberSeparatorProvider')]
    public function it_formats_card_number_by_given_separator(string $separator, string $expectedFormat): void
    {
        $faker = new CardNumberFaker($this->loader, separator: $separator);
        $formattedNumber = $this->callProtectedMethod($faker, 'formatCardNumber', ['123456', 789012345, 6]);

        $this->assertSame($expectedFormat, $formattedNumber);
    }

    #[Test]
    public function it_returns_fake_card_number_for_random_bank(): void
    {
        $faker = new CardNumberFaker($this->loader);
        $cardNumber = $faker->generate();

        $this->assertIsString($cardNumber);
        $this->assertIsNumeric($cardNumber);
        $this->assertSame(16, mb_strlen($cardNumber));
        $this->assertContains(mb_substr($cardNumber, 0, 6), $this->banksBins);
        $this->assertCheckDigit(mb_substr($cardNumber, 0, 15), mb_substr($cardNumber, -1));
    }

    #[Test]
    public function it_returns_fake_card_number_for_specific_bank(): void
    {
        $faker = new CardNumberFaker($this->loader, bank: 'bank2');
        $cardNumber = $faker->generate();

        $this->assertIsString($cardNumber);
        $this->assertIsNumeric($cardNumber);
        $this->assertSame(16, mb_strlen($cardNumber));
        $this->assertSame($this->banksBins['bank2'], mb_substr($cardNumber, 0, 6));
        $this->assertCheckDigit(mb_substr($cardNumber, 0, 15), mb_substr($cardNumber, -1));
    }

    #[Test]
    public function it_returns_fake_card_number_with_specific_separator(): void
    {
        $faker = new CardNumberFaker($this->loader, separator: '-');
        $cardNumber = $faker->generate();

        $this->assertIsString($cardNumber);
        $this->assertMatchesRegularExpression('/^\d{4}\-\d{4}\-\d{4}\-\d{4}$/', $cardNumber);

        $cardNumberDigits = str_replace('-', '', $cardNumber);
        $this->assertContains(mb_substr($cardNumberDigits, 0, 6), $this->banksBins);
        $this->assertCheckDigit(mb_substr($cardNumberDigits, 0, 15), mb_substr($cardNumberDigits, -1));
    }

    #[Test]
    public function it_throws_an_exception_if_bank_name_is_not_valid(): void
    {
        $faker = new CardNumberFaker($this->loader, bank: 'anonymous');

        $this->expectException(InvalidBankNameException::class);
        $this->expectExceptionMessage('The bank name anonymous is not a valid bank name.');

        $faker->generate();
    }

    // ----------------
    // Helper Methods
    // ----------------

    private function assertCheckDigit(string $digits, string|int $checkDigit): void
    {
        /*
        /----------------------------------------------
        / Iran's Bank Card Number Validation Algorithm
        /----------------------------------------------
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
        foreach (mb_str_split($digits) as $key => $value) {
            $multipleBy = (($key + 1) % 2 === 0) ? 1 : 2;

            $product = $value * $multipleBy;

            if ($product >= 10) {
                $product -= 9;
            }

            $sum += $product;
        }

        if ($sum % 10 === 0) {
            $this->assertEquals(0, $checkDigit);

            return;
        }

        $multipleOf10 = (intdiv($sum, 10) + 1) * 10;

        $this->assertEquals($multipleOf10 - $sum, $checkDigit);
    }
}
