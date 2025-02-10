<?php

declare(strict_types=1);

namespace Tests\Fakers\Phone;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidStateNameException;
use AliYavari\PersianFaker\Fakers\Phone\PhoneNumberFaker;
use AliYavari\PersianFaker\Loaders\DataLoader;
use Tests\TestCase;

class PhoneNumberFakerTest extends TestCase
{
    use Randomable;

    protected DataLoaderInterface $loader;

    protected array $statePrefixes;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = new DataLoader('phone.state_prefixes');

        $this->statePrefixes = $this->loader->get();
    }

    public function test_state_validation_passes_with_null_state(): void
    {
        $faker = new PhoneNumberFaker($this->loader, state: null);
        $isValid = $this->callProtectedMethod($faker, 'isStateValid');

        $this->assertTrue($isValid);
    }

    public function test_state_validation_passes_with_existed_state(): void
    {
        $state = array_rand($this->statePrefixes);

        $faker = new PhoneNumberFaker($this->loader, state: $state);
        $isValid = $this->callProtectedMethod($faker, 'isStateValid');

        $this->assertTrue($isValid);
    }

    public function test_state_validation_fails_with_not_existed_state(): void
    {
        $faker = new PhoneNumberFaker($this->loader, state: 'newState');
        $isValid = $this->callProtectedMethod($faker, 'isStateValid');

        $this->assertFalse($isValid);
    }

    public function test_it_returns_random_state_prefix_when_state_is_not_set_or_is_null(): void
    {
        $faker = new PhoneNumberFaker($this->loader, state: null);
        $statePrefix = $this->callProtectedMethod($faker, 'getStatePrefix');

        $this->assertContains($statePrefix, $this->statePrefixes);
    }

    public function test_it_returns_specific_state_prefix_when_state_is_set(): void
    {
        $state = array_rand($this->statePrefixes);

        $faker = new PhoneNumberFaker($this->loader, state: $state);
        $statePrefix = $this->callProtectedMethod($faker, 'getStatePrefix');

        $this->assertEquals($statePrefix, $this->statePrefixes[$state]);
    }

    public function test_it_generates_random_eight_digit_number(): void
    {
        $faker = new PhoneNumberFaker($this->loader);
        $number = $this->callProtectedMethod($faker, 'generateRandomPhoneNumber');

        $this->assertEquals(8, strlen((string) $number));
        $this->assertIsNumeric($number);
    }

    public function test_it_formats_phone_number(): void
    {
        $separator = $this->getOneRandomElement(['', ' ', '-']);

        $faker = new PhoneNumberFaker($this->loader, separator: $separator);
        $formattedPhone = $this->callProtectedMethod($faker, 'formatPhone', ['021', '12345678']);

        $this->assertEquals('021'.$separator.'12345678', $formattedPhone);
    }

    public function test_it_returns_fake_phone_number_with_random_prefix(): void
    {
        $faker = new PhoneNumberFaker($this->loader);
        $phoneNumber = $faker->generate(); // Expected format: 02112345678

        $this->assertIsString($phoneNumber);
        $this->assertEquals(11, strlen($phoneNumber));
    }

    public function test_it_returns_fake_phone_number_with_specific_separator(): void
    {
        $faker = new PhoneNumberFaker($this->loader, separator: '-');
        $phoneNumber = $faker->generate(); // Expected format: 021-12345678

        $this->assertIsString($phoneNumber);
        $this->assertEquals(12, strlen($phoneNumber));
    }

    public function test_it_returns_fake_phone_number_for_specific_state(): void
    {
        $state = array_rand($this->statePrefixes);

        $faker = new PhoneNumberFaker($this->loader, state: $state);
        $phoneNumber = $faker->generate(); // Expected format: 02112345678

        $this->assertIsString($phoneNumber);
        $this->assertEquals(11, strlen($phoneNumber));
        $this->assertEquals(substr($phoneNumber, 0, 3), $this->statePrefixes[$state]);
    }

    public function test_it_throws_an_exception_with_invalid_state_name(): void
    {
        $this->expectException(InvalidStateNameException::class);
        $this->expectExceptionMessage('The state name anonymous is not valid.');

        $faker = new PhoneNumberFaker($this->loader, state: 'anonymous');
        $faker->generate();
    }
}
