<?php

declare(strict_types=1);

namespace Tests\Fakers\Phone;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Exceptions\InvalidMobileProviderException;
use AliYavari\PersianFaker\Fakers\Phone\CellPhoneFaker;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class CellPhoneFakerTest extends TestCase
{
    use Arrayable;

    private $loader;

    private array $phonePrefixes = [
        'provider_one' => ['0911', '0912', '0913'],
        'provider_two' => ['0921', '0922', '0933'],
        'provider three' => ['0941', '0942', '0943'],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->phonePrefixes);
    }

    // ---------------
    // Data Providers
    // ---------------

    /**
     * Provides datasets in the format: `dataset => [string $separator, string $expectedFormat]`
     *
     * Base number is `09121234567`
     */
    public static function formatPhoneNumberSeparatorProvider(): iterable
    {
        yield 'space' => [' ', '0912 123 4567'];

        yield 'dash' => ['-', '0912-123-4567'];

        yield 'nothing' => ['', '09121234567'];
    }

    public function test_provider_validation_passes_with_null_provider(): void
    {
        $faker = new CellPhoneFaker($this->loader, provider: null);
        $isValid = $this->callProtectedMethod($faker, 'isProviderValid');

        $this->assertTrue($isValid);
    }

    public function test_provider_validation_passes_with_existed_provider(): void
    {
        $faker = new CellPhoneFaker($this->loader, provider: 'provider_two');
        $isValid = $this->callProtectedMethod($faker, 'isProviderValid');

        $this->assertTrue($isValid);
    }

    public function test_provider_validation_fails_with_not_existed_provider(): void
    {
        $faker = new CellPhoneFaker($this->loader, provider: 'newProvider');
        $isValid = $this->callProtectedMethod($faker, 'isProviderValid');

        $this->assertFalse($isValid);
    }

    public function test_it_returns_prefixes_of_all_providers_when_provider_is_not_set_or_is_null(): void
    {
        $faker = new CellPhoneFaker($this->loader, provider: null);
        $prefixes = $this->callProtectedMethod($faker, 'getPrefixes');

        $this->assertEqualsCanonicalizing($this->flatten($this->phonePrefixes), $prefixes); // All prefixes
    }

    public function test_it_returns_prefixes_of_specific_provider_when_provider_is_set(): void
    {
        $faker = new CellPhoneFaker($this->loader, provider: 'provider_two');
        $prefixes = $this->callProtectedMethod($faker, 'getPrefixes');

        $this->assertEqualsCanonicalizing($this->phonePrefixes['provider_two'], $prefixes);
    }

    public function test_it_generates_random_cell_phone_number(): void
    {
        $faker = new CellPhoneFaker($this->loader);
        $number = $this->callProtectedMethod($faker, 'generateRandomCellPhone');

        $this->assertSame(7, mb_strlen((string) $number));
        $this->assertIsNumeric($number);
    }

    #[DataProvider('formatPhoneNumberSeparatorProvider')]
    public function test_it_formats_cell_phone_number(string $separator, string $expectedFormat): void
    {
        $faker = new CellPhoneFaker($this->loader, separator: $separator);
        $formattedNumber = $this->callProtectedMethod($faker, 'formatPhone', ['0912', '1234567']);

        $this->assertSame($expectedFormat, $formattedNumber);
    }

    public function test_it_returns_fake_cell_phone_with_random_prefix(): void
    {
        $faker = new CellPhoneFaker($this->loader);
        $phone = $faker->generate(); // Expected format: 09121234567

        $this->assertIsString($phone);
        $this->assertSame(11, mb_strlen($phone));
        $this->assertMatchesRegularExpression('/^09\d{9}$/', $phone);
    }

    public function test_it_returns_fake_cell_phone_with_specific_separator(): void
    {
        $faker = new CellPhoneFaker($this->loader, separator: '-');
        $phone = $faker->generate(); // Expected format: 0912-123-4567

        $this->assertIsString($phone);
        $this->assertSame(13, mb_strlen($phone));
        $this->assertMatchesRegularExpression('/^09\d{2}\-\d{3}\-\d{4}$/', $phone);
    }

    public function test_it_returns_fake_cell_phone_for_specific_mobile_operator(): void
    {
        $faker = new CellPhoneFaker($this->loader, provider: 'provider_two');
        $phone = $faker->generate(); // Expected format: 09121234567

        $this->assertIsString($phone);
        $this->assertSame(11, mb_strlen($phone));
        $this->assertContains(mb_substr($phone, 0, 4), $this->phonePrefixes['provider_two']);
    }

    public function test_it_throws_an_exception_with_invalid_mobile_provider_name(): void
    {
        $this->expectException(InvalidMobileProviderException::class);
        $this->expectExceptionMessage('The mobile provider with name anonymous is not valid.');

        $faker = new CellPhoneFaker($this->loader, provider: 'anonymous');
        $faker->generate();
    }
}
