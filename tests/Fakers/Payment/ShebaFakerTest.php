<?php

declare(strict_types=1);

namespace Tests\Fakers\Payment;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Exceptions\InvalidBankNameException;
use AliYavari\PersianFaker\Fakers\Payment\ShebaFaker;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use RangeException;
use Tests\TestCase;
use TypeError;

final class ShebaFakerTest extends TestCase
{
    protected $loader;

    protected array $bankCodes = ['bank1' => '012', 'bank2' => '090', 'bank3' => '064'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->bankCodes);
    }

    // ---------------
    // Data Providers
    // ---------------

    /**
     * Provides datasets in the format: `dataset => [string $checkNumber, string $sheba]`
     */
    public static function checkNumbersProvider(): iterable
    {
        yield 'two_digits' => ['87', '0570028180010653892101'];

        yield 'one_digits' => ['02', '0190000000101975503003'];
    }

    /**
     * Provides datasets in the format: `dataset => [string $separator, string $expectedFormat]`
     *
     * Base number is `IR700160000001234567890123`
     */
    public static function formatShebaWithIrSeparatorProvider(): iterable
    {
        yield 'space' => [' ', 'IR70 0160 0000 0123 4567 8901 23'];

        yield 'dash' => ['-', 'IR70-0160-0000-0123-4567-8901-23'];

        yield 'nothing' => ['', 'IR700160000001234567890123'];
    }

    /**
     * Provides datasets in the format: `dataset => [string $separator, string $expectedFormat]`
     *
     * Base number is `700160000001234567890123`
     */
    public static function formatShebaWithoutIrSeparatorProvider(): iterable
    {
        yield 'space' => [' ', '70 0160 0000 0123 4567 8901 23'];

        yield 'dash' => ['-', '70-0160-0000-0123-4567-8901-23'];

        yield 'nothing' => ['', '700160000001234567890123'];
    }

    public function test_bank_validation_passes_with_null_bank_name(): void
    {
        $faker = new ShebaFaker($this->loader, bank: null);
        $isValid = $this->callProtectedMethod($faker, 'isBankValid');

        $this->assertTrue($isValid);
    }

    public function test_bank_validation_passes_with_existed_bank_name(): void
    {
        $faker = new ShebaFaker($this->loader, bank: 'bank2');
        $isValid = $this->callProtectedMethod($faker, 'isBankValid');

        $this->assertTrue($isValid);
    }

    public function test_bank_validation_fails_with_not_existed_bank_name(): void
    {
        $faker = new ShebaFaker($this->loader, bank: 'newName');
        $isValid = $this->callProtectedMethod($faker, 'isBankValid');

        $this->assertFalse($isValid);
    }

    public function test_it_returns_random_bank_code_when_bank_name_is_null_or_not_set(): void
    {
        $faker = new ShebaFaker($this->loader, bank: null);
        $bankCode = $this->callProtectedMethod($faker, 'getBankCode');

        $this->assertContains($bankCode, $this->bankCodes);
    }

    public function test_it_returns_specific_bank_code_when_bank_name_is_set(): void
    {
        $faker = new ShebaFaker($this->loader, bank: 'bank2');
        $bankCode = $this->callProtectedMethod($faker, 'getBankCode');

        $this->assertSame($this->bankCodes['bank2'], $bankCode);
    }

    public function test_it_generate_random_account_number_number(): void
    {
        $faker = new ShebaFaker($this->loader);
        $number = $this->callProtectedMethod($faker, 'generateRandomAccountNumber');

        $this->assertIsNumeric($number);
        $this->assertGreaterThanOrEqual(10, mb_strlen($number));
        $this->assertLessThanOrEqual(15, mb_strlen($number));
    }

    public function test_it_fills_remain_places_with_0(): void
    {
        $faker = new ShebaFaker($this->loader);
        $filledNumber = (string) $this->callProtectedMethod($faker, 'fillEmptyPlaces', ['12345678901']); // 11 digits

        $this->assertSame(18, mb_strlen($filledNumber));
        $this->assertSame('0000000', mb_substr($filledNumber, 0, 7));
        $this->assertSame('12345678901', mb_substr($filledNumber, -11));
    }

    #[DataProvider('checkNumbersProvider')]
    public function test_it_calculate_check_number(string $checkNumber, string $sheba): void
    {
        $faker = new ShebaFaker($this->loader);
        $calculatedCheckNumber = $this->callProtectedMethod($faker, 'calculateCheckNumber', [$sheba]);

        $this->assertSame($checkNumber, $calculatedCheckNumber);
        $this->assertCheckNumber($sheba, $calculatedCheckNumber);
    }

    public function test_it_throws_an_exception_if_input_number_is_less_than_22_digits(): void
    {
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('The input number must have 22 digits, 21-digit number is given.');

        $faker = new ShebaFaker($this->loader);
        $this->callProtectedMethod($faker, 'calculateCheckNumber', ['123456789012345678901']);
    }

    public function test_it_throws_an_exception_if_input_number_is_more_than_22_digits(): void
    {
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('The input number must have 22 digits, 23-digit number is given.');

        $faker = new ShebaFaker($this->loader);
        $this->callProtectedMethod($faker, 'calculateCheckNumber', ['12345678901234567890123']);
    }

    public function test_throws_an_exception_if_input_number_is_not_numeric(): void
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('The input must be numeric. string is given.');

        $faker = new ShebaFaker($this->loader);
        $this->callProtectedMethod($faker, 'calculateCheckNumber', ['a123456789012345678901']);
    }

    #[DataProvider('formatShebaWithIrSeparatorProvider')]
    public function test_it_formats_sheba_number_with_ir(string $separator, string $expectedFormat): void
    {
        $faker = new ShebaFaker($this->loader, separator: $separator, withIR: true);
        $formattedNumber = $this->callProtectedMethod($faker, 'formatShebaNumber', ['016', '0', '000001234567890123', '70']);

        $this->assertSame($expectedFormat, $formattedNumber);
    }

    #[DataProvider('formatShebaWithoutIrSeparatorProvider')]
    public function test_it_formats_sheba_number_without_ir(string $separator, string $expectedFormat): void
    {
        $faker = new ShebaFaker($this->loader, separator: $separator, withIR: false);
        $formattedNumber = $this->callProtectedMethod($faker, 'formatShebaNumber', ['016', '0', '000001234567890123', '70']);

        $this->assertSame($expectedFormat, $formattedNumber);
    }

    public function test_it_returns_fake_sheba_number_for_random_bank(): void
    {
        $faker = new ShebaFaker($this->loader);
        $shebaNumber = $faker->generate();

        $this->assertIsString($shebaNumber);
        $this->assertSame(26, mb_strlen($shebaNumber));
        $this->assertContains(mb_substr($shebaNumber, 4, 3), $this->bankCodes);
        $this->assertCheckNumber(mb_substr($shebaNumber, 5), mb_substr($shebaNumber, 2, 2));
    }

    public function test_it_returns_fake_sheba_number_for_specific_bank(): void
    {
        $faker = new ShebaFaker($this->loader, bank: 'bank2');
        $shebaNumber = $faker->generate();

        $this->assertIsString($shebaNumber);
        $this->assertSame(26, mb_strlen($shebaNumber));
        $this->assertSame($this->bankCodes['bank2'], mb_substr($shebaNumber, 4, 3));
        $this->assertCheckNumber(mb_substr($shebaNumber, 5), mb_substr($shebaNumber, 2, 2));
    }

    public function test_it_returns_fake_sheba_number_with_specific_separator(): void
    {
        $faker = new ShebaFaker($this->loader, separator: '-');
        $shebaNumber = $faker->generate();

        $this->assertIsString($shebaNumber);
        $this->assertMatchesRegularExpression('/^IR\d{2}\-\d{4}\-\d{4}\-\d{4}\-\d{4}\-\d{4}\-\d{2}$/', $shebaNumber);

        $shebaNumberDigits = str_replace('-', '', $shebaNumber);
        $this->assertContains(mb_substr($shebaNumberDigits, 4, 3), $this->bankCodes);
        $this->assertCheckNumber(mb_substr($shebaNumberDigits, 5), mb_substr($shebaNumberDigits, 2, 2));
    }

    public function test_it_throws_an_exception_if_bank_name_is_not_valid(): void
    {
        $faker = new ShebaFaker($this->loader, bank: 'anonymous');

        $this->expectException(InvalidBankNameException::class);
        $this->expectExceptionMessage('The bank name anonymous is not a valid bank name.');

        $faker->generate();
    }

    // ----------------
    // Helper Methods
    // ----------------

    private function assertCheckNumber(string $digits, string $checkDigit): void
    {
        /*
        /--------------------------------------------------------------------------
        / Iran's Sheba Number Validation Algorithm
        /--------------------------------------------------------------------------
        / It follows the International Bank Account Number (IBAN) standard with some specific rules:
        / - It is a 26-character string starting with 'IR' (the country code for Iran).
        / - The remaining characters are numeric and consist of:
        /   - A two-digit check number
        /   - A three-digit bank identifier code
        /   - A one-digit account type identifier (usually 0)
        /   - An eighteen-digit bank account number (left-padded with zeros if necessary)
        /
        / For the full validation/creation algorithm, see:
        / https://en.wikipedia.org/wiki/International_Bank_Account_Number
        /
        / Summary of Validation Algorithm:
        / 1. Concatenate the 22-digit bank and account number, the numeric value of the country code,
        /    and the 2-digit check digit.
        / 2. Calculate the remainder of the division of this number by 97 — it should equal 1.
        /
        / Note: As the IBAN standard, 'IR' converts to 1827.
        */

        $preparedNumber = $digits.'1827'.$checkDigit;

        $reminder = bcmod($preparedNumber, '97');

        $this->assertSame('1', $reminder);
    }
}
