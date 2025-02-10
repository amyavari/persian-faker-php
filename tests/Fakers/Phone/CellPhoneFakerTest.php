<?php

declare(strict_types=1);

namespace Tests\Fakers\Phone;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidMobileProviderException;
use AliYavari\PersianFaker\Fakers\Phone\CellPhoneFaker;
use AliYavari\PersianFaker\Loaders\DataLoader;
use Tests\TestCase;

class CellPhoneFakerTest extends TestCase
{
    use Arrayable, Randomable;

    protected DataLoaderInterface $loader;

    protected array $phonePrefixes;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = new DataLoader('phone.mobile_prefixes');

        $this->phonePrefixes = $this->loader->get();
    }

    public function test_provider_validation_passes_with_null_provider(): void
    {
        $faker = new CellPhoneFaker($this->loader, provider: null);
        $isValid = $this->callProtectedMethod($faker, 'isProviderValid');

        $this->assertTrue($isValid);
    }

    public function test_provider_validation_passes_with_existed_provider(): void
    {
        $provider = array_rand($this->phonePrefixes);

        $faker = new CellPhoneFaker($this->loader, provider: $provider);
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

        $this->assertEqualsCanonicalizing($prefixes, $this->flatten($this->phonePrefixes));
    }

    public function test_it_returns_prefixes_of_specific_provider_when_provider_is_set(): void
    {
        $provider = array_rand($this->phonePrefixes);

        $faker = new CellPhoneFaker($this->loader, provider: $provider);
        $prefixes = $this->callProtectedMethod($faker, 'getPrefixes');

        $this->assertEqualsCanonicalizing($prefixes, $this->phonePrefixes[$provider]);

    }

    public function test_it_generates_random_cell_phone_number(): void
    {
        $faker = new CellPhoneFaker($this->loader);
        $number = $this->callProtectedMethod($faker, 'generateRandomCellPhone');

        $this->assertEquals(7, strlen((string) $number));
        $this->assertIsNumeric($number);
    }

    public function test_it_formats_cell_phone_number(): void
    {
        $separator = $this->getOneRandomElement(['', ' ', '-']);

        $faker = new CellPhoneFaker($this->loader, separator: $separator);
        $formattedNumber = $this->callProtectedMethod($faker, 'formatPhone', ['0912', '1234567']);

        $this->assertEquals('0912'.$separator.'123'.$separator.'4567', $formattedNumber);
    }

    public function test_it_returns_fake_cell_phone_with_random_prefix(): void
    {
        $faker = new CellPhoneFaker($this->loader);
        $phone = $faker->generate(); // Expected format: 09121234567

        $this->assertIsString($phone);
        $this->assertEquals(11, strlen($phone));
    }

    public function test_it_returns_fake_cell_phone_with_specific_separator(): void
    {
        $faker = new CellPhoneFaker($this->loader, separator: '-');
        $phone = $faker->generate(); // Expected format: 0912-123-4567

        $this->assertIsString($phone);
        $this->assertEquals(13, strlen($phone));
    }

    public function test_it_returns_fake_cell_phone_for_specific_mobile_operator(): void
    {
        $phoneProvider = array_rand($this->phonePrefixes);

        $faker = new CellPhoneFaker($this->loader, provider: $phoneProvider);
        $phone = $faker->generate(); // Expected format: 09121234567

        $this->assertIsString($phone);
        $this->assertEquals(11, strlen($phone));
        $this->assertContains(substr($phone, 0, 4), $this->phonePrefixes[$phoneProvider]);
    }

    public function test_it_throws_an_exception_with_invalid_mobile_provider_name(): void
    {
        $this->expectException(InvalidMobileProviderException::class);
        $this->expectExceptionMessage('The mobile provider with name anonymous is not valid.');

        $faker = new CellPhoneFaker($this->loader, provider: 'anonymous');
        $faker->generate();
    }
}
