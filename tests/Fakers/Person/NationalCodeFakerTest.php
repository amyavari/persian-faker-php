<?php

declare(strict_types=1);

namespace Tests\Fakers\Person;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidStateNameException;
use AliYavari\PersianFaker\Fakers\Person\NationalCodeFaker;
use Mockery;
use RangeException;
use Tests\TestCase as TestsTestCase;
use TypeError;

class NationalCodeFakerTest extends TestsTestCase
{
    use Arrayable, Randomable;

    protected $loader;

    protected array $statePrefixes = [
        'state_one' => ['111', '112', '113'],
        'state_two' => ['222', '223', '224'],
        'state_three' => ['333', '334', '335'],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->statePrefixes);
    }

    public function test_state_validation_passes_with_null_state(): void
    {
        $faker = new NationalCodeFaker($this->loader, state: null);
        $isValid = $this->callProtectedMethod($faker, 'isStateValid');

        $this->assertTrue($isValid);
    }

    public function test_state_validation_passes_with_existed_state(): void
    {
        $state = array_rand($this->statePrefixes);

        $faker = new NationalCodeFaker($this->loader, state: $state);
        $isValid = $this->callProtectedMethod($faker, 'isStateValid');

        $this->assertTrue($isValid);
    }

    public function test_state_validation_fails_with_not_existed_state(): void
    {
        $faker = new NationalCodeFaker($this->loader, state: 'newState');
        $isValid = $this->callProtectedMethod($faker, 'isStateValid');

        $this->assertFalse($isValid);
    }

    public function test_it_returns_prefixes_of_all_states_when_state_is_not_set_or_is_null(): void
    {
        $faker = new NationalCodeFaker($this->loader, state: null);
        $statePrefix = $this->callProtectedMethod($faker, 'getStatePrefix');

        $this->assertContains($statePrefix, $this->flatten($this->statePrefixes));
    }

    public function test_it_returns_prefixes_of_specific_state_when_state_is_set(): void
    {
        $state = array_rand($this->statePrefixes);

        $faker = new NationalCodeFaker($this->loader, state: $state);
        $statePrefix = $this->callProtectedMethod($faker, 'getStatePrefix');

        $this->assertContains($statePrefix, $this->statePrefixes[$state]);
    }

    public function test_it_generates_random_six_digit_number(): void
    {
        $faker = new NationalCodeFaker($this->loader);
        $number = $this->callProtectedMethod($faker, 'generateRandomNationalCode');

        $this->assertSame(6, strlen((string) $number));
        $this->assertIsNumeric($number);
    }

    public function test_it_calculate_check_digit(): void
    {
        $digits = (string) random_int(100000000, 999999999);

        $faker = new NationalCodeFaker($this->loader);
        $checkDigit = $this->callProtectedMethod($faker, 'calculateCheckDigit', [$digits]);

        $this->assertTrue($this->isCheckDigitValid($digits, $checkDigit));
    }

    public function test_throws_an_exception_if_input_number_is_less_than_nine_digits(): void
    {
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('The input number must have 9 digits, 8-digit number is given.');

        $faker = new NationalCodeFaker($this->loader);
        $this->callProtectedMethod($faker, 'calculateCheckDigit', ['12345678']);
    }

    public function test_throws_an_exception_if_input_number_is_more_than_nine_digits(): void
    {
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('The input number must have 9 digits, 10-digit number is given.');

        $faker = new NationalCodeFaker($this->loader);
        $this->callProtectedMethod($faker, 'calculateCheckDigit', ['1234567890']);
    }

    public function test_throws_an_exception_if_input_number_is_not_numeric(): void
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('The input must be numeric. string is given.');

        $faker = new NationalCodeFaker($this->loader);
        $this->callProtectedMethod($faker, 'calculateCheckDigit', ['a23456789']);
    }

    public function test_it_returns_fake_national_code(): void
    {
        $faker = new NationalCodeFaker($this->loader);
        $nationalCode = $faker->generate();

        $this->assertIsString($nationalCode);
        $this->assertSame(10, strlen($nationalCode));
        $this->assertIsNumeric($nationalCode);
        $this->assertTrue($this->isCheckDigitValid(substr($nationalCode, 0, 9), substr($nationalCode, -1)));
    }

    public function test_it_returns_fake_national_code_for_specific_state(): void
    {
        $state = array_rand($this->statePrefixes);

        $faker = new NationalCodeFaker($this->loader, state: $state);
        $nationalCode = $faker->generate();

        $this->assertIsString($nationalCode);
        $this->assertSame(10, strlen($nationalCode));
        $this->assertIsNumeric($nationalCode);
        $this->assertContains(substr($nationalCode, 0, 3), $this->statePrefixes[$state]);
        $this->assertTrue($this->isCheckDigitValid(substr($nationalCode, 0, 9), substr($nationalCode, -1)));
    }

    public function test_it_throws_an_exception_with_invalid_state_name(): void
    {
        $this->expectException(InvalidStateNameException::class);
        $this->expectExceptionMessage('The state name anonymous is not valid.');

        $faker = new NationalCodeFaker($this->loader, state: 'anonymous');
        $faker->generate();
    }

    // ----------------
    // Helper Methods
    // ----------------

    private function isCheckDigitValid(string $digits, string|int $checkDigit): bool
    {
        /*
        /-------------------------------------
        / Iranian National Code Algorithm
        /-------------------------------------
        / The Iranian National Code is a 10-digit number.
        / The 10th digit is known as the check digit.
        / To calculate the check digit, follow these steps:
        /
        / 1. Multiply each of the first nine digits (from the left) by its positional value,
        /    where the position starts from 1 for the check digit (right-to-left).
        / 2. Sum the results of these multiplications.
        / 3. Divide the total sum by 11.
        / 4. If the remainder is less than 2, it becomes the check digit.
        /    If the remainder is 2 or greater, subtract it from 11 to get the check digit.
        */

        $sum = 0;
        foreach (str_split($digits) as $key => $value) {
            $sum += $value * (10 - $key);
        }

        $remainder = $sum % 11;

        if ($remainder < 2) {
            return $remainder == $checkDigit;
        }

        return (11 - $remainder) == $checkDigit;
    }
}
