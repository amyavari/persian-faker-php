<?php

declare(strict_types=1);

namespace Tests\Fakers\Payment;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidBankNameException;
use AliYavari\PersianFaker\Fakers\Payment\ShebaFaker;
use Mockery;
use RangeException;
use Tests\TestCase;
use TypeError;

class ShebaFakerTest extends TestCase
{
    use Randomable;

    protected $loader;

    protected array $bankCodes = ['bank1' => '012', 'bank2' => '090', 'bank3' => '064'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->bankCodes);
    }

    public function test_bank_validation_passes_with_null_bank_name(): void
    {
        $faker = new ShebaFaker($this->loader, bank: null);
        $isValid = $this->callProtectedMethod($faker, 'isBankValid');

        $this->assertTrue($isValid);
    }

    public function test_bank_validation_passes_with_existed_bank_name(): void
    {
        $bank = array_rand($this->bankCodes);

        $faker = new ShebaFaker($this->loader, bank: $bank);
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
        $bank = array_rand($this->bankCodes);

        $faker = new ShebaFaker($this->loader, bank: $bank);
        $bankCode = $this->callProtectedMethod($faker, 'getBankCode');

        $this->assertSame($this->bankCodes[$bank], $bankCode);
    }

    public function test_it_generate_random_account_number_number(): void
    {
        $faker = new ShebaFaker($this->loader);
        $number = $this->callProtectedMethod($faker, 'generateRandomAccountNumber');

        $this->assertIsNumeric($number);
        $this->assertGreaterThanOrEqual(10, strlen((string) $number));
        $this->assertLessThanOrEqual(15, strlen((string) $number));
    }

    public function test_it_fills_remain_places_with_0(): void
    {
        $number = random_int(1000000000, 99999999999999);

        $faker = new ShebaFaker($this->loader);
        $filledNumber = $this->callProtectedMethod($faker, 'fillEmptyPlaces', [$number]);

        $this->assertSame(18, strlen((string) $filledNumber));
        $this->assertMatchesRegularExpression('/^0+$/', str_replace((string) $number, '', $filledNumber));
    }

    public function test_it_calculate_check_digit(): void
    {
        $number = '0'.random_int(10, 99).'0000000000'.random_int(100_000_000, 999_999_999); // The mimic of real number format

        $faker = new ShebaFaker($this->loader);
        $checkDigit = $this->callProtectedMethod($faker, 'calculateCheckNumber', [$number]);

        $this->assertIsString($checkDigit);
        $this->assertSame(2, strlen($checkDigit));
        $this->assertTrue($this->isCheckNumberValid($number, $checkDigit));
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

    public function test_it_formats_sheba_number_with_ir(): void
    {
        $separator = $this->getOneRandomElement(['', ' ', '-']);

        $faker = new ShebaFaker($this->loader, separator: $separator, withIR: true);
        $formattedNumber = $this->callProtectedMethod($faker, 'formatShebaNumber', ['016', '0', '000001234567890123', '70']);

        $this->assertSame("IR70{$separator}0160{$separator}0000{$separator}0123{$separator}4567{$separator}8901{$separator}23", $formattedNumber);
    }

    public function test_it_formats_sheba_number_without_ir(): void
    {
        $separator = $this->getOneRandomElement(['', ' ', '-']);

        $faker = new ShebaFaker($this->loader, separator: $separator, withIR: false);
        $formattedNumber = $this->callProtectedMethod($faker, 'formatShebaNumber', ['016', '0', '000001234567890123', '70']);

        $this->assertSame("70{$separator}0160{$separator}0000{$separator}0123{$separator}4567{$separator}8901{$separator}23", $formattedNumber);
    }

    public function test_it_returns_fake_sheba_number_for_random_bank(): void
    {
        $faker = new ShebaFaker($this->loader);
        $shebaNumber = $faker->generate();

        $this->assertIsString($shebaNumber);
        $this->assertSame(26, strlen($shebaNumber));
        $this->assertContains(substr($shebaNumber, 4, 3), $this->bankCodes);
        $this->assertTrue($this->isCheckNumberValid(substr($shebaNumber, 5), substr($shebaNumber, 2, 2)));
    }

    public function test_it_returns_fake_sheba_number_for_specific_bank(): void
    {
        $bank = array_rand($this->bankCodes);

        $faker = new ShebaFaker($this->loader, bank: $bank);
        $shebaNumber = $faker->generate();

        $this->assertIsString($shebaNumber);
        $this->assertSame(26, strlen($shebaNumber));
        $this->assertSame($this->bankCodes[$bank], substr($shebaNumber, 4, 3));
        $this->assertTrue($this->isCheckNumberValid(substr($shebaNumber, 5), substr($shebaNumber, 2, 2)));
    }

    public function test_it_returns_fake_sheba_number_with_specific_separator(): void
    {
        $faker = new ShebaFaker($this->loader, separator: '-');
        $shebaNumber = $faker->generate();

        $this->assertIsString($shebaNumber);
        $this->assertMatchesRegularExpression('/^IR\d{2}\-\d{4}\-\d{4}\-\d{4}\-\d{4}\-\d{4}\-\d{2}$/', $shebaNumber);

        $shebaNumberDigits = str_replace('-', '', $shebaNumber);
        $this->assertContains(substr($shebaNumberDigits, 4, 3), $this->bankCodes);
        $this->assertTrue($this->isCheckNumberValid(substr($shebaNumberDigits, 5), substr($shebaNumberDigits, 2, 2)));
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

    private function isCheckNumberValid(string $digits, string $checkDigit): bool
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

        return $reminder === '1';
    }
}
