<?php

declare(strict_types=1);

namespace Tests\Fakers\Phone;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Exceptions\InvalidStateNameException;
use AliYavari\PersianFaker\Fakers\Phone\PhoneNumberFaker;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PhoneNumberFakerTest extends TestCase
{
    private $loader;

    private array $statePrefixes = ['yazd' => '035', 'teh' => '021', 'esf' => '031', 'gil' => '013'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->statePrefixes);
    }

    // ---------------
    // Data Providers
    // ---------------

    /**
     * Provides datasets in the format: `dataset => [string $separator, string $expectedFormat]`
     *
     * Base number is `02112345678`
     */
    public static function formatPhoneNumberSeparatorProvider(): iterable
    {
        yield 'space' => [' ', '021 12345678'];

        yield 'dash' => ['-', '021-12345678'];

        yield 'nothing' => ['', '02112345678'];
    }

    #[Test]
    public function state_validation_passes_with_null_state(): void
    {
        $faker = new PhoneNumberFaker($this->loader, state: null);
        $isValid = $this->callProtectedMethod($faker, 'isStateValid');

        $this->assertTrue($isValid);
    }

    #[Test]
    public function state_validation_passes_with_existed_state(): void
    {
        $faker = new PhoneNumberFaker($this->loader, state: 'teh');
        $isValid = $this->callProtectedMethod($faker, 'isStateValid');

        $this->assertTrue($isValid);
    }

    #[Test]
    public function state_validation_fails_with_not_existed_state(): void
    {
        $faker = new PhoneNumberFaker($this->loader, state: 'newState');
        $isValid = $this->callProtectedMethod($faker, 'isStateValid');

        $this->assertFalse($isValid);
    }

    #[Test]
    public function it_returns_random_state_prefix_when_state_is_not_set_or_is_null(): void
    {
        $faker = new PhoneNumberFaker($this->loader, state: null);
        $statePrefix = $this->callProtectedMethod($faker, 'getStatePrefix');

        $this->assertContains($statePrefix, $this->statePrefixes);
    }

    #[Test]
    public function it_returns_specific_state_prefix_when_state_is_set(): void
    {
        $faker = new PhoneNumberFaker($this->loader, state: 'teh');
        $statePrefix = $this->callProtectedMethod($faker, 'getStatePrefix');

        $this->assertSame($this->statePrefixes['teh'], $statePrefix);
    }

    #[Test]
    public function it_generates_random_eight_digit_number(): void
    {
        $faker = new PhoneNumberFaker($this->loader);
        $number = $this->callProtectedMethod($faker, 'generateRandomPhoneNumber');

        $this->assertSame(8, mb_strlen((string) $number));
        $this->assertIsNumeric($number);
    }

    #[Test]
    #[DataProvider('formatPhoneNumberSeparatorProvider')]
    public function it_formats_phone_number(string $separator, string $expectedFormat): void
    {
        $faker = new PhoneNumberFaker($this->loader, separator: $separator);
        $formattedPhone = $this->callProtectedMethod($faker, 'formatPhone', ['021', '12345678']);

        $this->assertSame($expectedFormat, $formattedPhone);
    }

    #[Test]
    public function it_returns_fake_phone_number_with_random_prefix(): void
    {
        $faker = new PhoneNumberFaker($this->loader);
        $phoneNumber = $faker->generate(); // Expected format: 02112345678

        $this->assertIsString($phoneNumber);
        $this->assertSame(11, mb_strlen($phoneNumber));
        $this->assertMatchesRegularExpression('/^0\d{10}$/', $phoneNumber);
    }

    #[Test]
    public function it_returns_fake_phone_number_with_specific_separator(): void
    {
        $faker = new PhoneNumberFaker($this->loader, separator: '-');
        $phoneNumber = $faker->generate(); // Expected format: 021-12345678

        $this->assertIsString($phoneNumber);
        $this->assertSame(12, mb_strlen($phoneNumber));
        $this->assertMatchesRegularExpression('/^0\d{2}\-\d{8}$/', $phoneNumber);
    }

    #[Test]
    public function it_returns_fake_phone_number_for_specific_state(): void
    {
        $faker = new PhoneNumberFaker($this->loader, state: 'teh');
        $phoneNumber = $faker->generate(); // Expected format: 02112345678

        $this->assertIsString($phoneNumber);
        $this->assertSame(11, mb_strlen($phoneNumber));
        $this->assertSame($this->statePrefixes['teh'], mb_substr($phoneNumber, 0, 3));
    }

    #[Test]
    public function it_throws_an_exception_with_invalid_state_name(): void
    {
        $this->expectException(InvalidStateNameException::class);
        $this->expectExceptionMessage('The state name anonymous is not valid.');

        $faker = new PhoneNumberFaker($this->loader, state: 'anonymous');
        $faker->generate();
    }
}
